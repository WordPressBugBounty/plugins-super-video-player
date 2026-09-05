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
			// strpos(), not str_contains(): the plugin supports PHP 7.4 and
			// str_contains() is PHP 8.0+, so it fataled on every admin page load.
			if ( is_string( $hook ) && false !== strpos( $hook, 'svplayer' ) ) {
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