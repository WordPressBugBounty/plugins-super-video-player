<?php
/**
 * VideoObject structured data (schema.org JSON-LD) for each player.
 *
 * Lets search engines index the videos and show them in video results.
 * Only data the site actually entered is published: SVP's placeholder
 * titles and descriptions are never sent, and a player with no usable
 * thumbnail gets no schema at all rather than invalid schema.
 *
 * Sites whose SEO plugin already outputs video schema can turn this off:
 *
 *     add_filter( 'svp_video_schema', '__return_false' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether a title or description is one of SVP's built-in placeholders.
 *
 * @param mixed $text Text to test.
 * @return bool True for empty text or a placeholder.
 */
function svp_schema_is_placeholder( $text ) {
	if ( ! is_string( $text ) ) {
		return true;
	}

	$normal = strtolower( trim( str_replace( array( "\u{2019}", "\u{2018}" ), "'", $text ) ) );

	return '' === $normal || in_array(
		$normal,
		array(
			'type your video title here',
			'enter video title...',
			'please like this video!',
			"don't forget to like, comment, and subscribe for more fun episodes!",
		),
		true
	);
}

/**
 * An absolute http(s) URL, or ''.
 *
 * @param mixed $url Candidate URL.
 * @return string
 */
function svp_schema_url( $url ) {
	if ( ! is_string( $url ) || ! preg_match( '#^https?://#i', trim( $url ) ) ) {
		return '';
	}

	return esc_url_raw( trim( $url ) );
}

/**
 * Build the VideoObject for a player.
 *
 * @param array $attributes Block attributes. `playerId` is set by the
 *                          [vplayer] shortcode path (inc/block-video-player.php).
 * @param int   $host_id    The post the player appears in (0 if unknown).
 * @return array|null Schema, or null when there is not enough real data.
 */
function svp_video_schema_data( $attributes, $host_id = 0 ) {
	$video = isset( $attributes['videos'][0] ) && is_array( $attributes['videos'][0] ) ? $attributes['videos'][0] : array();

	$player_id = isset( $attributes['playerId'] ) ? absint( $attributes['playerId'] ) : 0;
	$player    = $player_id ? get_post( $player_id ) : null;
	$date_post = $player ? $player : ( $host_id ? get_post( $host_id ) : null );

	if ( ! $date_post ) {
		return null;
	}

	// name: the video's own title, then the player's name, then the page title.
	$name = $video['title'] ?? '';
	if ( svp_schema_is_placeholder( $name ) && $player ) {
		$name = get_the_title( $player );
	}
	if ( svp_schema_is_placeholder( $name ) && $host_id ) {
		$name = get_the_title( $host_id );
	}
	if ( svp_schema_is_placeholder( $name ) ) {
		return null;
	}

	// thumbnailUrl is required: the poster, then the page's featured image.
	$thumbnail = svp_schema_url( $video['poster'] ?? '' );
	if ( '' === $thumbnail && $host_id ) {
		$thumbnail = svp_schema_url( (string) get_the_post_thumbnail_url( $host_id, 'full' ) );
	}
	if ( '' === $thumbnail ) {
		return null;
	}

	$upload_date = get_post_time( 'c', true, $date_post );
	if ( ! $upload_date ) {
		return null;
	}

	$schema = array(
		'@context'     => 'https://schema.org',
		'@type'        => 'VideoObject',
		'name'         => wp_strip_all_tags( $name ),
		'thumbnailUrl' => $thumbnail,
		'uploadDate'   => $upload_date,
	);

	$description = $video['description'] ?? '';
	if ( ! svp_schema_is_placeholder( $description ) ) {
		$schema['description'] = wp_strip_all_tags( $description );
	}

	$content_url = svp_schema_url( $video['src'] ?? '' );
	if ( '' !== $content_url ) {
		$schema['contentUrl'] = $content_url;
	}

	return $schema;
}

/**
 * The JSON-LD <script> for a player, or '' when there is none to print.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function svp_video_schema_script( $attributes ) {
	if ( is_feed() ) {
		return '';
	}

	$schema = svp_video_schema_data( $attributes, (int) get_the_ID() );

	/**
	 * Filters a player's VideoObject structured data.
	 *
	 * Return false to print none, e.g. when an SEO plugin already outputs
	 * video schema for the page.
	 *
	 * @param array|null $schema     VideoObject, or null if data was insufficient.
	 * @param array      $attributes The player's block attributes.
	 */
	$schema = apply_filters( 'svp_video_schema', $schema, $attributes );

	if ( ! is_array( $schema ) || empty( $schema ) ) {
		return '';
	}

	// JSON_HEX_TAG encodes < and > so the data can never close the <script> element.
	$json = wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP );

	return $json ? '<script type="application/ld+json">' . $json . '</script>' : '';
}
