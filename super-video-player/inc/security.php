<?php
/**
 * Security hardening.
 *
 * @package SuperVideoPlayer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Players are configured only through their own settings screen, which saves
 * with update_post_meta() and is not affected by this. WordPress's generic
 * custom-field editing (the Custom Fields box, its AJAX actions, XML-RPC) is
 * never needed on a player, and it was how untrusted values reached the
 * player meta in CVE-2026-62044. Turn it off for the svplayer post type, for
 * every role, as defence in depth.
 *
 * @param string[] $caps    Primitive capabilities required.
 * @param string   $cap     Capability being checked.
 * @param int      $user_id User ID.
 * @param array    $args    [ post ID, meta key ] for the meta capabilities.
 * @return string[]
 */
function svp_lock_player_meta_caps( $caps, $cap, $user_id, $args ) {
	if ( ! in_array( $cap, array( 'add_post_meta', 'edit_post_meta', 'delete_post_meta' ), true ) ) {
		return $caps;
	}

	$post_id = isset( $args[0] ) ? (int) $args[0] : 0;

	if ( $post_id && 'svplayer' === get_post_type( $post_id ) ) {
		return array( 'do_not_allow' );
	}

	return $caps;
}
add_filter( 'map_meta_cap', 'svp_lock_player_meta_caps', 10, 4 );
