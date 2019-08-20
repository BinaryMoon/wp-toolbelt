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
 */
function toolbelt_social_sharing( $content ) {

	if ( ! is_singular() ) {
		return $content;
	}

	toolbelt_social_styles();

	$html = '';

	// Get the canonical link for the blog post.
	// Fallback to the permalink.
	$canonical = wp_get_canonical_url();

	if ( ! $canonical ) {
		$canonical = get_permalink();
	}

	// Display a list of social networks.
	$networks = toolbelt_social_networks();

	foreach ( $networks as $slug => $network ) {

		$url = sprintf( $network['url'], rawurlencode( $canonical ) );
		$html .= sprintf(
			'<a href="%1$s" title="%2$s" class="%3$s" target="_blank">%4$s</a>' . "\n",
			esc_url( $url ),
			esc_attr( $network['title'] ),
			'toolbelt_' . esc_attr( $slug ),
			esc_html( $network['label'] )
		);

	}

	return $content . '<section class="toolbelt_social_share">' . $html . '</section>';

}

add_filter( 'the_content', 'toolbelt_social_sharing' );


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

	return apply_filters( 'toolbelt_social_networks', $networks );

}


/**
 * Display the social styles.
 */
function toolbelt_social_styles() {

	$path = plugin_dir_path( __FILE__ );

	// Output bar styles. Do this first so that the bar has styles instantly.
	echo '<style>';
	require $path . 'style.min.css';
	echo '</style>';

}
