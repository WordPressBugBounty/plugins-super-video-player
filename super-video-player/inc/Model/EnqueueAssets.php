<?php
namespace SVP\Model;

if (!defined('ABSPATH')) {
    exit;
}

class EnqueueAssets{
    protected static $_instance = null;

    public function __construct(){
        add_action("admin_enqueue_scripts", [$this, 'adminAssets']);
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

    /*
     * There is deliberately no front-end enqueue here.
     *
     * This class used to load assets/public/js/super-video.js (a byte-identical
     * copy of Plyr) and assets/public/css/player-style.css (a byte-identical
     * copy of plyr.css) on EVERY front-end request, in the header, whether or
     * not the page contained a player. Both files have been deleted.
     *
     * Plyr is now loaded once, only when a player is actually rendered, via
     * block.json (viewScript -> plyrIoJS, style -> plyrIoCSS). Those handles are
     * registered in video-player-block.php::enqueueBlockAssets(). The shortcode
     * and widget paths go through render_block(), so they are covered too.
     */
}

EnqueueAssets::instance();