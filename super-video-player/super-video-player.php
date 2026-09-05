<?php

/*
 * Plugin Name: Super Video Player 
 * Plugin URI:  https://bplugins.com/super-video-player
 * Description: A fully customizable video player for wordpress.
 * Version: 1.8.10
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Author: bPlugins
 * Author URI: http://bplugins.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
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
                require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
                $svp_fs = fs_dynamic_init( array(
                    'id'               => '6749',
                    'slug'             => 'super-video-player',
                    'type'             => 'plugin',
                    'public_key'       => 'pk_ebfc28616ca46b064866ea36660e0',
                    'is_premium'       => false,
                    'premium_suffix'   => 'Pro',
                    'has_addons'       => false,
                    'has_paid_plans'   => true,
                    'trial'            => array(
                        'days'               => 7,
                        'is_require_payment' => false,
                    ),
                    'menu'             => array(
                        'slug'       => 'edit.php?post_type=svplayer&page=svplayer#/welcome',
                        'first-path' => 'edit.php?post_type=svplayer&page=svplayer#/welcome',
                        'network'    => true,
                    ),
                    'is_live'          => true,
                    'is_org_compliant' => true,
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
    require_once __DIR__ . '/inc/functions.php';
    require_once plugin_dir_path( __FILE__ ) . '/video-player-block.php';
    add_action( 'init', 'svp_load_textdomain' );
    function svp_load_textdomain() {
        load_plugin_textdomain( 'svp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        if ( svp_fs()->is_free_plan() ) {
            require_once __DIR__ . '/inc/metabox-free.php';
            require_once __DIR__ . '/inc/shortcode-free.php';
        }
        if ( svp_fs()->can_use_premium_code() ) {
            require_once __DIR__ . '/premium-files/metabox-pro.php';
        }
    }

    /*Some Set-up*/
    define( 'SVP_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );
    define( 'SVP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'SVP_VERSION', '1.8.10' );
    define( 'SVP_HAS_PRO', 'super-video-player-premium/super-video-player.php' === plugin_basename( __FILE__ ) );
    /* JS*/
    // Inc  common
    require_once __DIR__ . '/inc/init.php';
    require_once __DIR__ . '/vendor/codestar-framework/codestar-framework.php';
    require_once __DIR__ . '/inc/Dashboard.php';
    if ( SVP_HAS_PRO ) {
        require_once __DIR__ . '/premium-files/LicenseActivation.php';
    }
    if ( svp_fs()->can_use_premium_code() ) {
        require_once __DIR__ . '/premium-files/shortcode-pro.php';
        require_once __DIR__ . '/premium-files/settings-fields.php';
        require_once __DIR__ . '/premium-files/widgets.php';
        function svp_block_admin_script() {
            // Plyr CSS
            wp_enqueue_style(
                'plyrIoCSS',
                SVP_PLUGIN_DIR . 'assets/css/plyr.css',
                array(),
                SVP_VERSION
            );
            // Plyr JS
            wp_enqueue_script(
                'plyrIoJS',
                SVP_PLUGIN_DIR . 'assets/js/plyr.js',
                array(),
                SVP_VERSION,
                true
            );
            $is_premium = svp_fs()->can_use_premium_code();
            $GLOBALS['svp_is_premium'] = $is_premium;
            wp_localize_script( 'plyrIoJS', 'SVP_DATA', array(
                'isPremium' => $is_premium,
                'iconUrl'   => SVP_PLUGIN_DIR . 'assets/images/plyr.svg',
            ) );
        }

        /*
         * Editor only.
         *
         * This was also hooked to wp_enqueue_scripts, which loaded Plyr on every
         * front-end page of a Pro site even when no player was present -- and a
         * second time, because block.json already lists plyrIoJS in viewScript.
         * The block registration handles the front end (including the shortcode
         * and widget paths, which render through render_block()), and localises
         * SVP_DATA onto the same handle in video-player-block.php.
         */
        add_action( 'enqueue_block_editor_assets', 'svp_block_admin_script' );
    }
}