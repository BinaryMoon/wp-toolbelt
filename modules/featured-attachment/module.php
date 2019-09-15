<?php
/**
 * Featured Attachment.
 *
 * If there's no featured image then return the first post attachment.
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
function toolbelt_post_thumbnail_html( $html, $post_id, $thumbnail_id, $size, $attr = array() ) {

	// If there's no html for the thumbnail then let's check for post attachments.
	if ( empty( $html ) ) {

		$images = get_attached_media( 'image', $post_id );

		if ( $images ) {
			foreach ( $images as $child_id => $attachment ) {

				$html = wp_get_attachment_image( (int) $child_id, $size, false, $attr );
				break;

			}
		}
	}

	/**
	 * Add native lazy loading.
	 *
	 * Currently supported in Chrome 76
	 *
	 * @link https://web.dev/native-lazy-loading
	 */
	$html = str_replace( 'src=', 'loading="lazy" src=', $html );

	return $html;

}

add_filter( 'post_thumbnail_html', 'toolbelt_post_thumbnail_html', 10, 5 );
