<?php

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
if (!function_exists('process_controls')) {
    function process_controls($pid, $metaid, $optionkey)
    {
        $stat = get_post_meta($pid, $metaid, true);
        if (empty($stat)) {
            if ($stat == '1') {
                return $optionkey;
            }
            if ($stat == '0') {
                return null;
            }
        }
        return $optionkey;
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

function svp_get_controls($id)
{
    $controls = [
        svp_get_control($id, 'large_play', 'play-large'),
        svp_get_control($id, 'restart_btn', 'restart'),
        svp_get_control($id, 'rewind_btn', 'rewind'),
        svp_get_control($id, 'play_btn', 'play'),
        svp_get_control($id, 'forward_button', 'fast-forward'),
        svp_get_control($id, 'progress_bar', 'progress'),
        svp_get_control($id, 'current_time', 'current-time'),
        svp_get_control($id, 'mute_button', 'mute'),
        svp_get_control($id, 'volume', 'volume'),
        svp_get_control($id, 'subtitle_button', 'captions'),
        svp_get_control($id, 'settings_button', 'settings'),
        svp_get_control($id, 'pip_btn', 'pip'),
        svp_get_control($id, 'download_button', 'download'),
        svp_get_control($id, 'fullscreen_button', 'fullscreen'),
    ];

    $results = [];

    foreach ($controls as $control) {
        if ($control) {
            $results[$control] = true;
        }
    }
    return $results;
}