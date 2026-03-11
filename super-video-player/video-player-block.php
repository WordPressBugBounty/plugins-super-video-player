<?php

if (!class_exists('SVPPlugin')) {
	class SVPPlugin
	{
		function __construct()
		{
			add_action('enqueue_block_assets', [$this, 'enqueueBlockAssets']);
			add_action('init', [$this, 'onInit']);
		}

		function enqueueBlockAssets()
		{
			wp_register_script( 'plyrIoJS', SVP_PLUGIN_DIR . 'assets/js/plyr.js', [], '3.7.8' );
			wp_register_style( 'plyrIoCSS', SVP_PLUGIN_DIR . 'assets/css/plyr.css', [], '3.7.8' );

			wp_register_script('hls',SVP_PLUGIN_DIR . 'assets/js/hls.js',array(),SVP_VERSION,false);

			wp_register_script('dash', SVP_PLUGIN_DIR . 'assets/js/dash.all.min.js', array(), SVP_VERSION, false );
		}

		function onInit()
		{
			register_block_type(__DIR__ . '/build/blocks/video-player');
		}
	}
	new SVPPlugin();
}


?>