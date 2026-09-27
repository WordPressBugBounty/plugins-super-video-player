<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*-------------------------------------------------------------------------------*/
/* Lets register our shortcode
/*-------------------------------------------------------------------------------*/

if(!function_exists('get_meta')){	
	function get_meta($id, $key, $default = null){
		$meta = get_post_meta($id, $key, true);
		if($meta){
			return $meta;
		}
		return $default;
	}

}
/*
 * Loaded only when Pro code is not running (see super-video-player.php).
 */
function svp_shortcode_func_free($attrs){
	$atts = shortcode_atts( array(
		'id' => null,
	), $attrs );
	$id = $atts['id'];

	$post_type = get_post_type($id);
	if($post_type != 'svplayer'){
		return false;
	}

	require SVP_PLUGIN_PATH . 'inc/block-video-player.php';

	return render_block($block);
}
/*
 * 1.0-1.6 wrapped this in if ( ! defined( 'SVP_PRO' ) ). Nothing in this
 * plugin defines SVP_PRO, but a separate, standalone Super Video Player Pro
 * plugin once did, and registered its own [vplayer]. 1.8.10 dropped the guard
 * as dead code; it is restored so a site still running that add-on keeps its
 * shortcode instead of having it silently replaced.
 */
if ( ! defined( 'SVP_PRO' ) ) {
	add_shortcode('vplayer','svp_shortcode_func_free');
}