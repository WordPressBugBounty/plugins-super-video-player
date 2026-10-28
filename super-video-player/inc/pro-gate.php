<?php
/**
 * Marks players created from 1.8.16 on, so their Pro controls can be enforced.
 *
 * The captions toggle, share, picture-in-picture and download buttons and the
 * control shadow are Pro features, but until 1.8.16 free players showed them,
 * because they are on by default. Existing players keep them. New players
 * get this marker, and without a licence the front end turns those controls
 * off for them (src/blocks/video-player/utils/entitlement.js). Blocks carry
 * the same marker as the gateProControls attribute.
 *
 * @package SuperVideoPlayer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Post meta that marks a [vplayer] player created from 1.8.16 on. */
const SVP_GATE_META = '_svp_gate_pro_controls';

/**
 * "Add new Player" creates the player post (an auto-draft) through
 * wp_insert_post() with $update false; existing players never pass this way.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether an existing post is being updated.
 */
function svp_mark_new_player( $post_id, $post, $update ) {
	if ( $update || ! $post || 'svplayer' !== $post->post_type ) {
		return;
	}
	add_post_meta( $post_id, SVP_GATE_META, '1', true );
}
add_action( 'wp_insert_post', 'svp_mark_new_player', 10, 3 );

/**
 * @param int $player_id Player post ID.
 * @return bool Whether the player was created from 1.8.16 on.
 */
function svp_player_gates_pro_controls( $player_id ) {
	return '1' === get_post_meta( $player_id, SVP_GATE_META, true );
}
