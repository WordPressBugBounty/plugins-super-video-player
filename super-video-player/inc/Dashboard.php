<?php
if (!defined('ABSPATH')) {
	exit;
}

if( !class_exists('svplayerDashboard') ){
  class svplayerDashboard{
    function __construct(){
			add_action( 'admin_enqueue_scripts', [$this, 'adminEnqueueScripts'] );
		}

		function adminEnqueueScripts( $hook ) {
			// Only the Help & Demos page (slug "svplayer"), whose hook ends in
			// "_page_svplayer". Matching any hook that contains "svplayer" also
			// caught the Freemius pages (pricing, account), which sit under the
			// plugin's menu since 1.8.18; the dashboard script then failed there,
			// looking for an element only Help & Demos has.
			if ( is_string( $hook ) && '_page_svplayer' === substr( $hook, -14 ) ) {
				$asset_file = file_exists(SVP_PLUGIN_PATH . 'build/dashboard.asset.php') 
					? include(SVP_PLUGIN_PATH . 'build/dashboard.asset.php') 
					: ['dependencies' => ['react', 'react-dom', 'wp-components', 'wp-api-fetch', 'wp-data'], 'version' => SVP_VERSION];

				wp_enqueue_style('svplayer-admin-style', SVP_PLUGIN_DIR . 'build/dashboard.css', [], $asset_file['version']);
				wp_enqueue_script('svplayer-dashboard-script', SVP_PLUGIN_DIR . 'build/dashboard.js', array_merge($asset_file['dependencies'], ['react-dom', 'wp-util']), $asset_file['version'], true);
			}
		}
    }
    new svplayerDashboard;
	}