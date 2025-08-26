<?php
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
if (!defined('SVP_PRO')) {
	function svp_shortcode_func_free($attrs){
		extract( shortcode_atts( array(
			'id' => null,
		), $attrs ) ); 

		$post_type = get_post_type($id);
		if($post_type != 'svplayer'){
			return false;
		}

		require SVP_PLUGIN_PATH . 'inc/block-video-player.php';

		return render_block($block);
	}
	add_shortcode('vplayer','svp_shortcode_func_free');	
}