<?php

add_action( 'init', function () {
    // Register block styles for both frontend + backend.
    wp_register_style( 'svp_block_free-style-css', plugins_url( 'blocks/dist/blocks.style.build.css', dirname( __FILE__ ) ), is_admin() ? array( 'wp-editor' ) : null, null );

    // Register block editor script for backend.
    wp_register_script( 'svp_block_free-js', plugins_url( '/blocks/dist/blocks.build.js', dirname( __FILE__ ) ), array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true );

    // Register block editor styles for backend.
    wp_register_style( 'svp_block_free-editor-css', plugins_url( 'blocks/dist/blocks.editor.build.css', dirname( __FILE__ ) ), array( 'wp-edit-blocks' ), null );

    // WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
    wp_localize_script(
        'svp_block_free-js',
        'cgbGlobal', // Array containing dynamic data for a JS Global.
        [
            'pluginDirPath' => plugin_dir_path( __DIR__ ),
            'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
            // Add more data here that you want to access from `cgbGlobal` object.
        ]
    );

    // Register Gutenberg block on server-side.
    register_block_type( 'svp/free', array(
        'style'         => 'svp_block_free-style-css',
        'editor_script' => 'svp_block_free-js',
        'editor_style'  => 'svp_block_free-editor-css',
    ) );

    register_block_type( 'svp/existing', [
        'render_callback' => 'render_svp_block_free_existing',
    ] );
} );

function render_svp_block_free_existing( $attributes ) {
    extract( $attributes );

    isset($align) ? $align : $align = 'full';
	isset($contentAlign) ? $contentAlign : $contentAlign = 'left';

    $alignClass = '' == $align ? '' : 'align' . $align;

    ob_start();
    echo '<div class="svp_block_free_existing ' . esc_html( $alignClass) . '" style="text-align:' . esc_html($contentAlign) . ';">';

    if ( 'empty' == $selectedPlayer && current_user_can( 'edit_posts' ) ) {
        echo 'No Video Player is Selected';
    } elseif ( !$selectedPlayer && current_user_can( 'edit_posts' ) ) {
        echo 'No Video Player is Selected';
    } elseif ( 'empty' == $selectedPlayer || !$selectedPlayer ) {
        echo '';
    } else {
        echo do_shortcode( "[vplayer id=$selectedPlayer]" );
    }
  
    echo '</div>';
    return ob_get_clean();
}

// Call custom script
function svp_block_free_script() {
    wp_enqueue_script( 'block-script', plugins_url( 'blocks/block-script.js', dirname( __FILE__ ) ), array( 'jquery' ), SVP_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'svp_block_free_script' );