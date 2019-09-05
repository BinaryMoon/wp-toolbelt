<?php
/**
 * Social sharing links.
 *
 * @package toolbelt
 */

// Don't display in the WordPress admin.
if ( is_admin() ) {
	return;
}


/**
 * Add social sharing buttons to the post content.
 *
 * @param string $content The post content to append the sharing option to.
 * @return string The post content with the sharing options appended.
 */
function toolbelt_social_sharing( $content ) {

	$post_types = apply_filters(
		'toolbelt_social_sharing_post_types',
		array( 'post' )
	);

	/**
	 * Not a singular post type of any sort so let's quit.
	 */
	if ( ! is_singular( $post_types ) ) {
		return $content;
	}

	/**
	 * Check a filter to see if we should quit.
	 *
	 * By default will return if it's not a blog post.
	 * You can change this with the filter.
	 * @see
	 */
	if ( ! apply_filters( 'toolbelt_display_social_sharing', true ) ) {
		return $content;
	}

	toolbelt_styles( 'social-sharing' );

	$html = '';

	// Get the canonical link for the blog post.
	// Fallback to the permalink.
	$canonical = wp_get_canonical_url();

	if ( ! $canonical ) {
		$canonical = get_permalink();
	}

	/**
	 * Let's build it ourselves from the server information.
	 */
	if ( ! $canonical && isset( $_SERVER ) ) {
		$https = 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
		$canonical = $https . ':// ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	$canonical = esc_url( $canonical );

	/**
	 * There's no url so let's quit.
	 *
	 * This can happen in some places such as buddypress where some pages are
	 * created virtually and don't have a linkable url.
	 */
	if ( empty( $canonical ) ) {
		return $content;
	}

	// Display a list of social networks.
	$networks = toolbelt_social_networks();

	foreach ( $networks as $slug => $network ) {

		$url = sprintf( $network['url'], rawurlencode( $canonical ) );
		$html .= sprintf(
			'<a href="%1$s" title="%2$s" class="%3$s" target="_blank">%4$s %5$s</a>' . "\n",
			esc_url( $url ),
			esc_attr( $network['title'] ),
			'toolbelt_' . esc_attr( $slug ),
			file_get_contents( TOOLBELT_PATH . 'svg/' . $slug . '.svg' ),
			esc_html( $network['label'] )
		);

	}

	return $content . '<section class="toolbelt_social_share">' . $html . '</section>';

}

add_filter( 'the_content', 'toolbelt_social_sharing', 99 );


/**
 * Get a list of social networks and their sharing links.
 */
function toolbelt_social_networks() {

	$networks = array(
		'facebook' => array(
			'title' => esc_html__( 'Share on Facebook', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Facebook button label', 'wp-toolbelt' ),
			'url' => 'https://facebook.com/sharer/sharer.php?u=%s',
		),
		'twitter' => array(
			'title' => esc_html__( 'Tweet on Twitter', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Tweet this', 'Twitter button label', 'wp-toolbelt' ),
			'url' => 'https://twitter.com/intent/tweet?url=%s',
		),
		'linkedin' => array(
			'title' => esc_html__( 'Share on LinkedIn', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'LinkedIn button label', 'wp-toolbelt' ),
			'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=%s',
		),
		'whatsapp' => array(
			'title' => esc_html__( 'Share on WhatsApp', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'WhatsApp button label', 'wp-toolbelt' ),
			'url' => 'https://wa.me/?text=%s',
		),
		'pinterest' => array(
			'title' => esc_html__( 'Pin on Pinterest', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Pin this', 'Pinterest button label', 'wp-toolbelt' ),
			'url' => 'https://pinterest.com/pin/create/button/?url=%s',
		),
	);

	// return apply_filters( 'toolbelt_social_networks', $networks );
	return $networks;

}
