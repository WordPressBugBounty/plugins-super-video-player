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
    $align        = isset( $attributes['align'] ) ? $attributes['align'] : 'full';
    $contentAlign = isset( $attributes['contentAlign'] ) ? $attributes['contentAlign'] : 'left';

    // Player reference is a post ID; absint() means it can never break out of
    // the shortcode attribute below. 0 stands for "nothing selected".
    $selected_player = isset( $attributes['selectedPlayer'] ) ? absint( $attributes['selectedPlayer'] ) : 0;

    // Allowlist both presentational values rather than only escaping them:
    // esc_attr() stops attribute breakout but still permits CSS injection
    // inside a style="" attribute.
    $allowed_aligns = array( 'left', 'center', 'right', 'justify' );
    if ( ! in_array( $contentAlign, $allowed_aligns, true ) ) {
        $contentAlign = 'left';
    }

    $allowed_block_aligns = array( 'left', 'center', 'right', 'wide', 'full' );
    $align_class          = in_array( $align, $allowed_block_aligns, true ) ? 'align' . $align : '';

    ob_start();

    printf(
        '<div class="%1$s" style="text-align:%2$s;">',
        esc_attr( trim( 'svp_block_free_existing ' . $align_class ) ),
        esc_attr( $contentAlign )
    );

    if ( $selected_player ) {
        echo do_shortcode( sprintf( '[vplayer id="%d"]', $selected_player ) );
    } elseif ( current_user_can( 'edit_posts' ) ) {
        echo esc_html__( 'No Video Player is Selected', 'svp' );
    }

    echo '</div>';
    return ob_get_clean();
}

/*
 * assets/js/block-script.js used to be enqueued here on every front-end page,
 * with jQuery as a dependency. It only ever restyled ".wp-block-svp-create",
 * a class no version of this plugin renders, so it did nothing but pull jQuery
 * onto pages that had no other need for it. Both are gone.
 */
