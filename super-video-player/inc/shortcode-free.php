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

		wp_enqueue_script('bplugins-frontend');
		wp_enqueue_style('bplugins-frontend');


		$props = [
			'data' => [
				'src' => get_meta($id,'_svp_video_file', ''),
				'poster' => get_meta($id,'_svp_video_poster', ''),
				'captions' => get_meta($id,'video_caption', []),
			],
			'options' => [
				'repeat' => get_meta($id,'video_repeat', false) == 'loop' ? true : false,
				'muted' => get_meta($id,'video_muted', false) == '1' ? true: false,
				'autoplay' => get_meta($id,'video_autoplay', false) == '1' ? true: false,
				'playsinline' => true
			],
			'styles' => [
				'width' => get_meta($id,'video_width', false) ? get_meta($id,'video_width') . 'px': '100%'
			]
		];

		$ext = pathinfo(get_meta($id,'_svp_video_file', ''), PATHINFO_EXTENSION);

		if($ext=='m3u8'){ 
			wp_enqueue_script('svp-hls-js');
		}
		
		if($ext=='mpd'){ 
			wp_enqueue_script('svp-dash-js');
		}


	ob_start();?>
	<div class="svpPlayer" data-props='<?php echo esc_attr(wp_json_encode($props)) ?>'></div>
	
	<?php $output = ob_get_clean();return $output;//print $output; // debug ?>

	<?php
	}
	add_shortcode('vplayer','svp_shortcode_func_free');	
}