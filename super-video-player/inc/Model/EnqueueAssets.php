<?php
namespace SVP\Model;

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
        wp_enqueue_style('svp-admin',  SVP_PLUGIN_DIR . 'admin/css/style.css',array(),SVP_VERSION);
    }

    /**
     * Enqueue Public Assets
     */
    public function publicAssets($hook){
        wp_enqueue_script('bplugins-plyrio', SVP_PLUGIN_DIR . 'public/js/super-video.js',array(), SVP_VERSION,false );

        wp_register_script('bplugins-frontend', SVP_PLUGIN_DIR . 'dist/frontend.js',array('react', 'react-dom'), SVP_VERSION,false );
        wp_register_style('bplugins-frontend', SVP_PLUGIN_DIR . 'dist/frontend.css',array(), SVP_VERSION, 'all' );

        wp_enqueue_style( 'bplugins-plyrio', SVP_PLUGIN_DIR . 'public/css/player-style.css', array(), SVP_VERSION,  'all' );

        wp_register_script('svp-hls-js',SVP_PLUGIN_DIR . 'public/js/hls.js',array(),SVP_VERSION,false);

        wp_register_script('svp-shaka-js', SVP_PLUGIN_DIR . 'public/js/shaka.js', array(), SVP_VERSION, false );
        wp_register_script('svp-dash-js', SVP_PLUGIN_DIR . 'public/js/dash.all.min.js', array(), SVP_VERSION, false );
    }
}

EnqueueAssets::instance();