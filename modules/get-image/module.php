<?php
/**
 * Get a featured image from post content and attached media.
 *
 * @package toolbelt
 */

/**
 * Fill empty post thumbnails with images from the first attachment added to a
 * post.
 *
 * @param string  $html Current html for thumbnail image.
 * @param integer $post_id ID for specified post.
 * @param integer $thumbnail_id ID for thumbnail image.
 * @param string  $size expected Thumbnail size.
 * @param array   $attr Image attributes.
 * @return string
 */
function toolbelt_get_image_thumbnail_html( $html, $post_id, $thumbnail_id, $size = '', $attr = array() ) {

	// Quit early if there's already an image to display.
	if ( ! empty( $html ) ) {
		return $html;
	}

	/**
	 * Get the desired image dimensions.
	 *
	 * Default sizes.
	 * No idea what the best sizes are to use here?
	 */
	global $_wp_additional_image_sizes;

	$width = 500;
	$height = 500;

	if ( is_array( $size ) ) {
		$width = $size['width'];
		$height = $size['height'];
	}

	if ( is_string( $size ) && isset( $_wp_additional_image_sizes[ $size ] ) ) {
		$width = $_wp_additional_image_sizes[ $size ]['width'];
		$height = $_wp_additional_image_sizes[ $size ]['height'];
	}

	// Store the url for the thumbnail image.
	$image_url = '';

	/**
	 * Image css class values.
	 */
	$image_class = array(
		'wp-post-image',
		'attachment-' . $size,
		'size-' . $size,
	);

	/**
	 * Get the first attached image and use that as the featured image.
	 */
	if ( ! $html ) {

		$images = get_attached_media( 'image', $post_id );

		if ( $images ) {
			foreach ( $images as $child_id => $attachment ) {

				$html = wp_get_attachment_image( $child_id, $size, false, $attr );
				break;

			}
		}

	}

	/**
	 * Load the image from the post/ page content.
	 */
	if ( ! $html ) {

		$content = get_the_content( null, false, $post_id );

		if ( $content ) {

			// Use regex to find the src of the image.
			preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches );

			/**
			 * $matches[0] includes complete html for all images found.
			 * $matches[1] includes the urls found.
			 */
			$image_count = count( $matches[1] );

			if ( $image_count >= 1 ) {
				for ( $i = 0; $i <= $image_count; $i ++ ) {
					$image_url = $matches[1][ $i ];
					break;
				}
			}
		}

	}

	/**
	 * If there's an image then let's convert it to the appropriate format.
	 */
	if ( $image_url ) {

		if ( ! empty( $attr['class'] ) ) {
			$image_class[] = $attr['class'];
		}

		$html = sprintf(
			'<img src="%1$s" class="%2$s" />',
			esc_url( toolbelt_get_image_photon( $image_url, $width, $height ) ),
			esc_attr( implode( ' ', $image_class ) )
		);

	}

	return $html;

}

add_filter( 'post_thumbnail_html', 'toolbelt_get_image_thumbnail_html', 10, 5 );


/**
 * If Jetpack is in use then use Jetpack to ensure the image is the correct size.
 *
 * @param string $url The image url.
 * @param int    $w The image width.
 * @param int    $h The image height.
 * @return string
 */
function toolbelt_get_image_photon( $url, $w, $h ) {

	if ( ! function_exists( 'jetpack_photon_url' ) ) {
		return $url;
	}

	return jetpack_photon_url(
		$url,
		array(
			'resize' => $w . ',' . $h,
		)
	);

}

