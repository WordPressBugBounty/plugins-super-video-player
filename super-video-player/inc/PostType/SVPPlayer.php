<?php
namespace HTML5Player\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class SVPPlayer{
    protected static $_instance = null;
    protected static $post_type = 'svplayer';
    

    public function __construct(){
        add_action('init', [$this, 'init']);
        if(is_admin()){

            add_action('admin_menu', [$this, 'svp_dashboard_page'], 20);

            add_filter( 'post_row_actions',[$this, 'svp_remove_row_actions'], 10, 2 );
            add_filter( 'gettext', [$this, 'svp_change_publish_button'], 10, 2 );

            add_filter('post_updated_messages', [$this, 'svp_updated_messages']);
            add_action('edit_form_after_title', [$this, 'svp_shortcode_area']);
            add_filter( 'admin_footer_text', [$this, 'svp_admin_footer']);	 
            add_filter('manage_svplayer_posts_columns', [$this, 'ST4_columns_head_only_svplayer'], 10);
            add_action('manage_svplayer_posts_custom_column', [$this, 'ST4_columns_content_only_svplayer'], 10, 2);
            // add_action( 'add_meta_boxes', [$this, 'svp_myplugin_add_meta_box'] );
            
            add_action('admin_head-post.php', [$this, 'svp_hide_publishing_actions']);
            add_action('admin_head-post-new.php', [$this, 'svp_hide_publishing_actions']);

            add_action('admin_enqueue_scripts', [$this, 'svp_admin_assets']);

        }
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
     * register post type
     */
    public function init(){
        register_post_type( 'svplayer', array(
            'labels'              => array(
            'name'          => __( 'Super Video Player' ),
            'singular_name' => __( 'Player' ),
            'add_new'       => __( 'Add New' ),
            'add_new_item'  => __( 'Add new item' ),
            'edit_item'     => __( 'Edit' ),
            'new_item'      => __( 'New' ),
            'view_item'     => __( 'View' ),
            'search_items'  => __( 'Search' ),
            'not_found'     => __( 'Sorry, we couldn\'t find any item you are looking for.' ),
        ),
            'public'              => false,
            'show_ui'             => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'show_in_rest'        => true,
            'menu_position'       => 14,
            'menu_icon'           => SVP_PLUGIN_DIR . 'assets/images/icon.png',
            'has_archive'         => false,
            'hierarchical'        => false,
            'capability_type'     => 'page',
            'rewrite'             => array( 'slug' => 'svplayer'),
            'supports'            => array( 'title', 'thumbnail' ),
        ) );

    }

    public function svp_dashboard_page(){
        add_submenu_page(
            'edit.php?post_type=svplayer',
            __('Help & Demos', 'svplayer'),
            __('Help & Demos', 'svplayer'),
            'manage_options',
            'svplayer',
            [$this, 'dashboardPage']
        );
    
        global $submenu;
        if (isset($submenu['edit.php?post_type=svplayer'])) {
            $menu = $submenu['edit.php?post_type=svplayer'];
            foreach ($menu as $index => $item) {
                if ($item[2] === 'svplayer') {
                    $dashboard = $item;
                    unset($menu[$index]);
                    array_splice($menu, 2, 0, [$dashboard]);
                    break;
                }
            }
            $submenu['edit.php?post_type=svplayer'] = $menu;
        }
    }

    public function dashboardPage() { ?>
        <div id='svpPlayerDashboard'
         data-info="<?php echo esc_attr( wp_json_encode([
            'version' => SVP_VERSION,
            'isPremium'  => svp_fs()->can_use_premium_code(),
            'hasPro'               => SVP_HAS_PRO,
            'licenseActiveNonce'   => wp_create_nonce('bPlLicenseActivation'),
            'adminUrl' => admin_url(),
        ]) ); ?>"></div>
    <?php }


   public function svp_admin_assets($hook){

    global $post;

    if( isset($post->post_type) && $post->post_type === self::$post_type ){

        wp_enqueue_style(
            'svp-admin-style',
            plugins_url('shortCodeAdmin.css', __FILE__),
            [],
            SVP_VERSION
        );

        wp_enqueue_script(
            'svp-admin-script',
            plugins_url('shortCodeAdmin.js', __FILE__),
            ['jquery'],
            SVP_VERSION,
            true
        );
    }
}

    function svp_shortcode_area(){
    global $post;

    if($post->post_type == self::$post_type){ 

        $shortcode = "[vplayer id='{$post->ID}']";
        ?>
        
        <div class="svp-shortcode-wrapper">
            <span class="svp-shortcode-text">
                <?php esc_html_e( "Copy and paste this shortcode into your posts, pages and widget", "svp" ); ?>
            </span>

            <div class="svp-shortcode-box">
                <code id="svp-copy-shortcode"><?php echo esc_html($shortcode); ?></code>

                <!-- <button type="button" class="svp-copy-btn" data-copy="<?php echo esc_attr($shortcode); ?>">
                    <span class="dashicons dashicons-clipboard"></span>
                </button> -->

                <button type="button" class="svp-copy-btn" data-copy="<?php echo esc_attr($shortcode); ?>">
                <span class="svp-copy-icon">
                    <svg class="bp3d_shortcode_copy_icon" data-clipboard-text="[3d_viewer id=&quot;6&quot;]" width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8 4V16C8 17.1046 8.89543 18 10 18L18 18C19.1046 18 20 17.1046 20 16V7.24162C20 6.7034 19.7831 6.18789 19.3982 5.81161L16.0829 2.56999C15.7092 2.2046 15.2074 2 14.6847 2H10C8.89543 2 8 2.89543 8 4Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16 18V20C16 21.1046 15.1046 22 14 22H6C4.89543 22 4 21.1046 4 20V9C4 7.89543 4.89543 7 6 7H8" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </svg>
                </span>
            </button>

            </div>
            
        </div>

        <?php
    }
}


    function svp_remove_row_actions( $idtions ) {
        global $post;
        if( $post->post_type == self::$post_type ) {
            unset( $idtions['view'] );
            unset( $idtions['inline hide-if-no-js'] );
        }
        return $idtions;
    }

    function svp_updated_messages( $messages ) {
        $messages[self::$post_type][1] = __('Player updated ');
        return $messages;
    }

    function svp_change_publish_button( $translation, $text ) {
        if ( self::$post_type == get_post_type())
        if ( $text == 'Publish' )
            return 'Save';
        
        return $translation;
    }


    function svp_admin_footer( $text ) {
        if ( self::$post_type == get_post_type() ) {
            $url = 'https://wordpress.org/support/plugin/super-video-player/reviews/?filter=5#new-post';
            $text = sprintf( __( 'If you like <strong>Super Video Player</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'post-carousel' ), $url );
        }
    
        return $text;
    }

    // CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
    function ST4_columns_head_only_svplayer($defaults) {
        $defaults['shortcode'] = 'ShortCode';
        $v = $defaults['date'];
        unset($defaults['date']);
        $defaults['date'] = $v;
        return $defaults;
    }

    function ST4_columns_content_only_svplayer($column_name, $post_id) {
        if ($column_name == 'shortcode') {
            echo '<div class="svp_front_shortcode"><input style="text-align: center; border: none; outline: none; background-color: #1e8cbe; color: #fff; padding: 4px 10px; border-radius: 3px;" value="[vplayer id=' . esc_attr($post_id) . ']" ><span class="htooltip">Copy To Clipboard</span></div>';
        }
    }

    
    // function svp_myplugin_add_meta_box() {
    //     add_meta_box(
    //         'myplugin_sectionid',
    //         __( 'Please show some love', 'svp' ),
    //         [$this, 'svp_review_callback'],
    //         'svplayer',
    //         'side'
    //     );	
    // }

    // function svp_review_callback(){
    //     echo  '<p>If you like <strong>Super Video Player</strong> Plugin, please leave us a <a href="https://wordpress.org/support/plugin/super-video-player/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733; rating</a> . Your Review is very important to us as it helps us to grow more.</p>

    //     <p>Not happy, Sorry for that. You can request for improvement. </p>

    //     <table>
    //         <tr>
    //             <td><a class="button button-primary button-large" href="https://wordpress.org/support/plugin/super-video-player/reviews/?filter=5#new-post" target="_blank">Write Review</a></td>
    //             <td><a class="button button-primary button-large" href="mailto:abuhayat.du@gmail.com" target="_blank">Request Improvement</a></td>
    //         </tr>
    //     </table>';
    // }

    function svp_hide_publishing_actions(){
        global $post;
        if($post->post_type == self::$post_type){
            echo '
                <style type="text/css">
                    #misc-publishing-actions,
                    #minor-publishing-actions{
                        display:none;
                    }
                </style>
            ';
        }
    }
}

SVPPlayer::instance();