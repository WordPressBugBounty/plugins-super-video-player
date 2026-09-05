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
 * This file is only loaded on the free plan (see super-video-player.php), so
 * the guard that used to wrap it -- if ( ! defined( 'SVP_PRO' ) ) -- was doing
 * nothing: SVP_PRO is never defined anywhere in the plugin, so the condition
 * was always true. Removing it changes no behaviour.
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
add_shortcode('vplayer','svp_shortcode_func_free');