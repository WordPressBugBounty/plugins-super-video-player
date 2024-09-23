<?php

/*
 * Plugin Name: Super Video Player
 * Plugin URI:  https://bplugins.com/super-video-player
 * Description: A fully customizable video player for wordpress.
 * Version: 1.7.4
 * Author: bPlugins
 * Author URI: http://bplugins.com
 * Text Domain:  svp
 * Domain Path:  /languages
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( function_exists( 'svp_fs' ) ) {
    svp_fs()->set_basename( false, __FILE__ );
} else {
    if ( !function_exists( 'svp_fs' ) ) {
        // Create a helper function for easy SDK access.
        function svp_fs() {
            global $svp_fs;
            if ( !isset( $svp_fs ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_6749_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_6749_MULTISITE', true );
                }
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $svp_fs = fs_dynamic_init( array(
                    'id'             => '6749',
                    'slug'           => 'super-video-player',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_ebfc28616ca46b064866ea36660e0',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                        'days'               => 7,
                        'is_require_payment' => false,
                    ),
                    'menu'           => array(
                        'slug'       => 'edit.php?post_type=svplayer',
                        'first-path' => 'edit.php?post_type=svplayer',
                        'network'    => true,
                    ),
                    'is_live'        => true,
                ) );
            }
            return $svp_fs;
        }

        // Init Freemius.
        svp_fs();
        // Signal that SDK was initiated.
        do_action( 'svp_fs_loaded' );
    }
    require_once __DIR__ . '/upgrade.php';
    // Load Textdomain
    function svp_load_textdomain() {
        load_plugin_textdomain( 'svp', false, dirname( __FILE__ ) . "/languages" );
    }

    add_action( "plugins_loaded", 'svp_load_textdomain' );
    /*Some Set-up*/
    define( 'SVP_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );
    define( 'SVP_VERSION', '1.7.4' );
    /* JS*/
    // Inc  common
    include_once 'admin/blocks/init.php';
    require_once 'admin/codestar-framework/codestar-framework.php';
    require_once 'admin/inc/help-usages.php';
    if ( svp_fs()->is_free_plan() ) {
        // if(true){
        // Free version code
        require_once 'admin/inc/metabox-free.php';
        require_once 'inc/shortcode-free.php';
    }
}