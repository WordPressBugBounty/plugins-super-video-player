<?php
if (!defined('ABSPATH')) {
	exit;
}

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

			/**
			 * hls.js 1.7.3 replaces the 0.9.1 build (2018) used until 1.8.15.
			 * For one release the old build ships too, as an escape hatch for
			 * a stream that only works with it:
			 * add_filter( 'svp_use_legacy_hls', '__return_true' );
			 *
			 * @param bool $legacy Load hls.js 0.9.1 instead. Default false.
			 */
			$svp_hls_file = apply_filters( 'svp_use_legacy_hls', false ) ? 'assets/js/hls-0.9.1.js' : 'assets/js/hls.js';
			wp_register_script('hls',SVP_PLUGIN_DIR . $svp_hls_file,array(),SVP_VERSION,false);

			wp_register_script('dash', SVP_PLUGIN_DIR . 'assets/js/dash.all.min.js', array(), SVP_VERSION, false );

			wp_localize_script(
				'plyrIoJS',
				'SVP_DATA',
				/**
				 * Filters the data handed to the player script as window.SVP_DATA.
				 *
				 * @param array $data isPremium, iconUrl; Pro adds i18n.
				 */
				apply_filters(
					'svp_player_data',
					array(
						'isPremium' => function_exists('svp_premium_code_available') && svp_premium_code_available(),
						'iconUrl'   => SVP_PLUGIN_DIR . 'assets/images/plyr.svg',
					)
				)
			);
		}

		function onInit()
		{
			register_block_type(__DIR__ . '/build/blocks/video-player');
		}
	}
	new SVPPlugin();
}


?>