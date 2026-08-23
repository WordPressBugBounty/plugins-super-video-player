<?php
/**
 * Server-side render callback for Super Video Player.
 *
 * @package SuperVideoPlayer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$id = wp_unique_id( 'svpVideoPlayer-' );

$needs_hls  = false;
$needs_dash = false;

if ( ! empty( $attributes['videos'] ) && is_array( $attributes['videos'] ) ) {
	foreach ( $attributes['videos'] as $video ) {
		if ( empty( $video['src'] ) || ! is_string( $video['src'] ) ) {
			continue;
		}

		// Ignore query strings and fragments when detecting the file extension.
		$path = wp_parse_url( $video['src'], PHP_URL_PATH );

		if ( ! is_string( $path ) ) {
			continue;
		}

		$extension = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );

		if ( 'm3u8' === $extension ) {
			$needs_hls = true;
		} elseif ( 'mpd' === $extension ) {
			$needs_dash = true;
		}

		// Stop once all required scripts have been identified.
		if ( $needs_hls && $needs_dash ) {
			break;
		}
	}
}

if ( $needs_hls ) {
	wp_enqueue_script( 'hls' );
}

if ( $needs_dash ) {
	wp_enqueue_script( 'dash' );
}

$json_attributes = wp_json_encode( $attributes );

if ( false === $json_attributes ) {
	$json_attributes = '{}';
}
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	id="<?php echo esc_attr( $id ); ?>"
	data-attributes="<?php echo esc_attr( $json_attributes ); ?>">
</div>