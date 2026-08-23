<?php
namespace SVP\Model;

if (!defined('ABSPATH')) {
    exit;
}

class EnqueueAssets{
    protected static $_instance = null;

    public function __construct(){
        add_action("admin_enqueue_scripts", [$this, 'adminAssets']);
        add_action("wp_enqueue_scripts", [$this, 'publicAssets']);
    }

    /**
     * create instance
     */
    public static function instance(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Enqueue Admin Assets
     */
    public function adminAssets(){
        wp_enqueue_style('svp-admin',  SVP_PLUGIN_DIR . 'assets/admin/css/style.css',array(),SVP_VERSION);
    }

    /**
     * Enqueue Public Assets
     */
    public function publicAssets($hook){
        wp_enqueue_script('bplugins-plyrio', SVP_PLUGIN_DIR . 'assets/public/js/super-video.js',array(), SVP_VERSION,false );

        wp_enqueue_style( 'bplugins-plyrio', SVP_PLUGIN_DIR . 'assets/public/css/player-style.css', array(), SVP_VERSION,  'all' );
    }
}

EnqueueAssets::instance();