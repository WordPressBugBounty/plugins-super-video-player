<?php
namespace HTML5Player\PostType;
class SVPPlayer{
    protected static $_instance = null;
    protected static $post_type = 'svplayer';

    public function __construct(){
        add_action('init', [$this, 'init']);
        if(is_admin()){
            add_filter( 'post_row_actions',[$this, 'svp_remove_row_actions'], 10, 2 );
            add_filter( 'gettext', [$this, 'svp_change_publish_button'], 10, 2 );

            add_filter('post_updated_messages', [$this, 'svp_updated_messages']);
            add_action('edit_form_after_title', [$this, 'svp_shortcode_area']);
            add_filter( 'admin_footer_text', [$this, 'svp_admin_footer']);	 
            add_filter('manage_svplayer_posts_columns', [$this, 'ST4_columns_head_only_svplayer'], 10);
            add_action('manage_svplayer_posts_custom_column', [$this, 'ST4_columns_content_only_svplayer'], 10, 2);
            add_action( 'add_meta_boxes', [$this, 'svp_myplugin_add_meta_box'] );
            
            add_action('admin_head-post.php', [$this, 'svp_hide_publishing_actions']);
            add_action('admin_head-post-new.php', [$this, 'svp_hide_publishing_actions']);

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
            'menu_icon'           => SVP_PLUGIN_DIR . 'img/icon.png',
            'has_archive'         => false,
            'hierarchical'        => false,
            'capability_type'     => 'page',
            'rewrite'             => array( 'slug' => 'svplayer'),
            'supports'            => array( 'title', 'thumbonail' ),
        ) );
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

    function svp_shortcode_area(){
        global $post;
        if($post->post_type== self::$post_type){ ?>
        <div class="svp_playlist_shortcode">
            <div class="shortcode-heading">
                <div class="icon"><span class="dashicons dashicons-video-alt3"></span> <?php _e("Super Video Player", "svp"); ?></div>
                <div class="text"> <a href="https://bplugins.com/support/" target="_blank"><?php _e("Supports", "svp"); ?></a></div>
            </div>
            <div class="shortcode-left">
                <h3><?php _e("Shortcode", "svp") ?></h3>
                <p><?php _e("Copy and paste this shortcode into your posts, pages and widget:", "svp") ?></p>
                <div class="shortcode" selectable>[vplayer id='<?php echo esc_attr($post->ID); ?>']</div>
            </div>
            <div class="shortcode-right">
                <h3><?php _e("Template Include", "svp") ?></h3>
                <p><?php _e("Copy and paste the PHP code into your template file:", "svp"); ?></p>
                <div class="shortcode">&lt;?php echo do_shortcode('[vplayer id="<?php echo esc_attr($post->ID); ?>"]');
                ?&gt;</div>
            </div>
        </div>
        <?php   
        }
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

    
    function svp_myplugin_add_meta_box() {
        add_meta_box(
            'myplugin_sectionid',
            __( 'Please show some love', 'svp' ),
            [$this, 'svp_review_callback'],
            'svplayer',
            'side'
        );	
    }

    function svp_review_callback(){
        echo  '<p>If you like <strong>Super Video Player</strong> Plugin, please leave us a <a href="https://wordpress.org/support/plugin/super-video-player/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733; rating</a> . Your Review is very important to us as it helps us to grow more.</p>

        <p>Not happy, Sorry for that. You can request for improvement. </p>

        <table>
            <tr>
                <td><a class="button button-primary button-large" href="https://wordpress.org/support/plugin/super-video-player/reviews/?filter=5#new-post" target="_blank">Write Review</a></td>
                <td><a class="button button-primary button-large" href="mailto:abuhayat.du@gmail.com" target="_blank">Request Improvement</a></td>
            </tr>
        </table>';
    }

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