<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('get_meta')) {
    function get_meta($id, $key, $default = null)
    {
        $meta = get_post_meta($id, $key, true);
        // return $meta;
        if ($meta) {
            return $meta;
        }
        return $default;
    }
}

if (!function_exists('get__meta')) {
    function get__meta($id)
    {
        return function ($key) use ($id) {
            return get_post_meta($id, $key, true);
        };
    }
}

function svp_get_control($id, $key, $returnValue = null)
{
	$enabled = get_post_meta($id, $key, true);
	if ($enabled === '1') {
		return $returnValue;
	}
	return null;
}

/**
 * "Controls & Components" meta keys, mapped to Plyr control names.
 *
 * @return array<string, string>
 */
function svp_get_control_map()
{
    return [
        'large_play'        => 'play-large',
        'restart_btn'       => 'restart',
        'rewind_btn'        => 'rewind',
        'play_btn'          => 'play',
        'forward_button'    => 'fast-forward',
        'progress_bar'      => 'progress',
        'current_time'      => 'current-time',
        'mute_button'       => 'mute',
        'volume'            => 'volume',
        'subtitle_button'   => 'captions',
        'share_button'      => 'share',
        'settings_button'   => 'settings',
        'pip_btn'           => 'pip',
        'download_button'   => 'download',
        'fullscreen_button' => 'fullscreen',
    ];
}

/**
 * Controls for a player whose controls were never saved.
 *
 * Up to 1.7.4 the free renderer ignored control meta entirely and handed
 * Plyr no `controls` option, so every free player showed Plyr's default set.
 * 1.7.5 started reading the meta instead, and players that never had it
 * stored lost their whole control bar. Restoring exactly the set those
 * players used to show means an upgrade changes nothing a visitor can see.
 *
 * @return array<string, bool> Meta key => enabled.
 */
function svp_get_legacy_control_defaults()
{
    $plyr_defaults = [ 'play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'fullscreen' ];

    $defaults = [];
    foreach (svp_get_control_map() as $meta_key => $plyr_control) {
        $defaults[$meta_key] = in_array($plyr_control, $plyr_defaults, true);
    }

    return apply_filters('svp_legacy_control_defaults', $defaults);
}

/**
 * Whether the controls metabox has ever been saved for this player.
 *
 * It stores one meta row per switch, so a player with none of those rows was
 * never configured. That is different from a player whose owner switched every
 * control off, which is respected as saved.
 *
 * @param int $id Player post ID.
 * @return bool
 */
function svp_controls_are_configured($id)
{
    foreach (array_keys(svp_get_control_map()) as $meta_key) {
        if (metadata_exists('post', $id, $meta_key)) {
            return true;
        }
    }

    return false;
}

function svp_get_controls($id)
{
    $configured = svp_controls_are_configured($id);
    $defaults   = $configured ? [] : svp_get_legacy_control_defaults();

    $results = [];

    foreach (svp_get_control_map() as $meta_key => $plyr_control) {
        $enabled = $configured
            ? ('1' === get_post_meta($id, $meta_key, true))
            : ! empty($defaults[$meta_key]);

        if ($enabled) {
            $results[$plyr_control] = true;
        }
    }

    return $results;
}

/*
 * Legacy meta normalisation.
 *
 * No release has ever migrated stored player data, and the storage format
 * changed in 1.3: 1.0–1.2 saved `_svp_video_file` and `_svp_video_poster` as
 * arrays (`['url' => ...]`), flags as `_svp_video_autoplay = "on"`, width as
 * `_svp_width` and subtitles in the `_svp_re_` repeater. These helpers read
 * whichever shape a player has, without writing anything back, so players
 * created years ago render the way they did when they were saved.
 */

/**
 * A media URL from a meta value that may be a string (1.3+) or an array (1.0–1.2).
 *
 * @param mixed $value Raw meta value.
 * @return string
 */
function svp_legacy_media_url($value)
{
    if (is_array($value)) {
        $value = $value['url'] ?? '';
    }

    return is_string($value) ? $value : '';
}

/**
 * A boolean flag that is `'1'` under its current key or `'on'` under its 1.0–1.2 key.
 *
 * The legacy key is only consulted when the current key was never saved, so a
 * setting changed after 1.3 always wins.
 *
 * @param int    $id         Player post ID.
 * @param string $key        Current meta key, e.g. `video_autoplay`.
 * @param string $legacy_key 1.0–1.2 meta key, e.g. `_svp_video_autoplay`.
 * @return bool
 */
function svp_legacy_flag($id, $key, $legacy_key)
{
    if (metadata_exists('post', $id, $key)) {
        return '1' === get_post_meta($id, $key, true);
    }

    return 'on' === get_post_meta($id, $legacy_key, true);
}

/**
 * Loop setting: `video_repeat = "loop"` (1.3+) or `_svp_video_repeat = "loop"` (1.0–1.2).
 *
 * @param int $id Player post ID.
 * @return bool
 */
function svp_legacy_repeat($id)
{
    if (metadata_exists('post', $id, 'video_repeat')) {
        return 'loop' === get_post_meta($id, 'video_repeat', true);
    }

    return 'loop' === get_post_meta($id, '_svp_video_repeat', true);
}

/**
 * Player width in pixels, or 0 for responsive. `video_width` (1.3+), `_svp_width` (1.0–1.2).
 *
 * @param int $id Player post ID.
 * @return int
 */
function svp_legacy_width($id)
{
    $width = get_post_meta($id, 'video_width', true);

    if ('' === $width || false === $width) {
        $width = get_post_meta($id, '_svp_width', true);
    }

    return absint($width);
}

/**
 * Caption rows in the 1.3+ shape (`label`, `vtt`), reading the 1.0–1.2
 * `_svp_re_` repeater when the player has no `video_caption` rows.
 *
 * @param int $id Player post ID.
 * @return array<int, array{label: string, vtt: string}>
 */
function svp_legacy_captions($id)
{
    $captions = get_post_meta($id, 'video_caption', true);

    if (is_array($captions) && ! empty($captions)) {
        return $captions;
    }

    $legacy = get_post_meta($id, '_svp_re_', true);

    if (! is_array($legacy)) {
        return [];
    }

    $rows = [];
    foreach ($legacy as $row) {
        if (! is_array($row)) {
            continue;
        }
        $vtt = svp_legacy_media_url($row['_svp_sub_id'] ?? '');
        if ('' === $vtt) {
            continue;
        }
        // 1.0 always emitted srclang="en", so keep that language for these rows.
        $rows[] = [
            'label' => ($row['_svp_label'] ?? '') . '/en',
            'vtt'   => $vtt,
        ];
    }

    return $rows;
}