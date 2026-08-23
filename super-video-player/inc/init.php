<?php
if (!defined('ABSPATH')) {
	exit;
}

add_action( 'init', function () {
    register_block_type( 'svp/existing', [
        'render_callback' => 'render_svp_block_free_existing',
    ] );
} );

function render_svp_block_free_existing( $attributes ) {
    $align          = isset( $attributes['align'] ) ? $attributes['align'] : 'full';
    $contentAlign   = isset( $attributes['contentAlign'] ) ? $attributes['contentAlign'] : 'left';
    $selectedPlayer = isset( $attributes['selectedPlayer'] ) ? $attributes['selectedPlayer'] : '';

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
    if ( file_exists( SVP_PLUGIN_PATH . 'assets/js/block-script.js' ) ) {
        wp_enqueue_script( 'block-script', SVP_PLUGIN_DIR . 'assets/js/block-script.js', array( 'jquery' ), SVP_VERSION, true );
    }
}
add_action( 'wp_enqueue_scripts', 'svp_block_free_script' );
