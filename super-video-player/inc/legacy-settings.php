<?php
/**
 * The player settings screen shows old players' settings as they really are.
 *
 * Players render through the read-time legacy helpers in functions.php, so
 * a player saved by 1.0-1.2, or never configured, plays as it always did.
 * But the settings screen (Codestar) read the raw meta: it printed "Array"
 * as the video and poster of 1.0-1.2 players, and showed its own defaults
 * for settings stored under old keys or never saved. Pressing "Update"
 * then wrote those over the player - the video was lost, autoplay, width,
 * subtitles changed, and extra buttons appeared.
 *
 * In wp-admin, for player posts, this hands the settings screen the value
 * the player actually uses. Saving then stores it in today's format, so
 * the player keeps working and looking the same. Nothing is written here,
 * and the front end is not affected (it uses the legacy helpers directly).
 *
 * @package SuperVideoPlayer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The value the settings screen should show for a player setting, or null
 * to let WordPress read the stored meta as usual.
 *
 * @param int    $player_id Player post ID.
 * @param string $meta_key  Meta key the settings screen asks for.
 * @return mixed|null
 */
function svp_legacy_settings_value( $player_id, $meta_key ) {
	switch ( $meta_key ) {
		// 1.0-1.2 stored media as [ 'id' => ..., 'url' => ... ].
		case '_svp_video_file':
		case '_svp_video_poster':
			$raw = get_post_meta( $player_id, $meta_key, true );
			return is_array( $raw ) ? svp_legacy_media_url( $raw ) : null;

		case 'video_autoplay':
		case 'video_muted':
			$legacy = '_svp_' . $meta_key;
			if ( metadata_exists( 'post', $player_id, $meta_key ) || ! metadata_exists( 'post', $player_id, $legacy ) ) {
				return null;
			}
			return 'on' === get_post_meta( $player_id, $legacy, true ) ? '1' : '0';

		case 'video_repeat':
			if ( metadata_exists( 'post', $player_id, 'video_repeat' ) || ! metadata_exists( 'post', $player_id, '_svp_video_repeat' ) ) {
				return null;
			}
			return svp_legacy_repeat( $player_id ) ? 'loop' : 'once';

		case 'video_width':
			$width = get_post_meta( $player_id, 'video_width', true );
			if ( ( '' !== $width && false !== $width ) || ! metadata_exists( 'post', $player_id, '_svp_width' ) ) {
				return null;
			}
			return (string) svp_legacy_width( $player_id );

		case 'video_caption':
			$rows = get_post_meta( $player_id, 'video_caption', true );
			if ( is_array( $rows ) && ! empty( $rows ) ) {
				return null;
			}
			$legacy = svp_legacy_captions( $player_id );
			return empty( $legacy ) ? null : $legacy;
	}

	$controls = svp_get_control_map();
	if ( isset( $controls[ $meta_key ] ) ) {
		// New players use the settings screen's own defaults.
		if ( function_exists( 'svp_player_gates_pro_controls' ) && svp_player_gates_pro_controls( $player_id ) ) {
			return null;
		}
		if ( ! svp_controls_are_configured( $player_id ) ) {
			// Never configured: the controls the player has always shown.
			$defaults = svp_get_legacy_control_defaults();
			return empty( $defaults[ $meta_key ] ) ? '0' : '1';
		}
		// Configured before this switch existed (e.g. share, added in 1.8.6):
		// the player does not show it.
		return metadata_exists( 'post', $player_id, $meta_key ) ? null : '0';
	}

	return null;
}

/**
 * get_post_metadata filter (wp-admin only).
 *
 * @param mixed  $value     Null, or a value another filter already returned.
 * @param int    $object_id Post ID.
 * @param string $meta_key  Meta key.
 * @param bool   $single    Whether a single value was requested.
 * @return mixed
 */
function svp_legacy_settings_meta( $value, $object_id, $meta_key, $single ) {
	static $busy = false;

	if ( null !== $value || $busy || ! $meta_key || ! svp_is_legacy_settings_key( $meta_key ) || 'svplayer' !== get_post_type( $object_id ) ) {
		return $value;
	}

	// The helpers read meta too; let those reads through untouched.
	$busy  = true;
	$shown = svp_legacy_settings_value( (int) $object_id, $meta_key );
	$busy  = false;

	if ( null === $shown ) {
		return null;
	}
	// Always wrapped: for a single value WordPress returns element [0] of
	// what a filter gives it, which would cut a list of caption rows short.
	return array( $shown );
}

/**
 * @param string $meta_key Meta key.
 * @return bool Whether the settings screen may need this key translated.
 */
function svp_is_legacy_settings_key( $meta_key ) {
	static $keys = null;
	if ( null === $keys ) {
		$keys = array_merge(
			array( '_svp_video_file', '_svp_video_poster', 'video_autoplay', 'video_muted', 'video_repeat', 'video_width', 'video_caption' ),
			array_keys( svp_get_control_map() )
		);
	}
	return in_array( $meta_key, $keys, true );
}

if ( is_admin() ) {
	add_filter( 'get_post_metadata', 'svp_legacy_settings_meta', 10, 4 );
}
