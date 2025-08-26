<?php

if( !class_exists('svplayerDashboard') ){
  class svplayerDashboard{
    function __construct(){
			add_action( 'admin_enqueue_scripts', [$this, 'adminEnqueueScripts'] );
		}

		function adminEnqueueScripts( $hook ) {
			if( str_contains( $hook, 'svplayer' ) ){
				wp_enqueue_style( 'svplayer-admin-style', SVP_PLUGIN_DIR . 'build/dashboard.css', ['wp-components','wp-edit-blocks','wp-block-editor'], SVP_VERSION );
				wp_enqueue_script( 'svplayer-dashboard-script', SVP_PLUGIN_DIR . 'build/dashboard.js', [ 'react', 'react-dom',  'wp-components', 'wp-i18n', 'wp-api', 'wp-util' ,'lodash', 'wp-media-utils' ,'wp-data','wp-core-data','wp-api-request','wp-element','wp-edit-post','wp-block-editor' ], SVP_VERSION, true );
			}
		}
    }
    new svplayerDashboard;
	}