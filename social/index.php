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
function tb_social_sharing( $content ) {

	if ( ! is_singular() ) {
		return $content;
	}

	tb_social_styles();

	$html = '';

	// Get the canonical link for the blog post.
	// Fallback to the permalink.
	$canonical = wp_get_canonical_url();

	if ( ! $canonical ) {
		$canonical = get_permalink();
	}

	// Display a list of social networks.
	$networks = tb_social_networks();

	foreach ( $networks as $slug => $network ) {

		$url = sprintf( $network['url'], rawurlencode( $canonical ) );
		$html .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $network['title'] ) . '" class="tb_' . esc_attr( $slug ) . '">' . esc_html( $network['label'] ) . '</a>' . "\n";

	}

	return $content . '<section class="tb_social_share">' . $html . '</section>';

}

add_filter( 'the_content', 'tb_social_sharing' );


/**
 * Get a list of social networks and their sharing links.
 */
function tb_social_networks() {

	$networks = array(
		'facebook' => array(
			'title' => esc_html__( 'Share on Facebook', 'toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Facebook button label', 'toolbelt' ),
			'url' => 'https://facebook.com/sharer/sharer.php?u=%s',
		),
		'twitter' => array(
			'title' => esc_html__( 'Tweet on Twitter', 'toolbelt' ),
			'label' => esc_html_x( 'Tweet this', 'Twitter button label', 'toolbelt' ),
			'url' => 'https://twitter.com/intent/tweet?url=%s',
		),
		'linkedin' => array(
			'title' => esc_html__( 'Share on LinkedIn', 'toolbelt' ),
			'label' => esc_html_x( 'Share this', 'LinkedIn button label', 'toolbelt' ),
			'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=%s',
		),
		'whatsapp' => array(
			'title' => esc_html__( 'Share on WhatsApp', 'toolbelt' ),
			'label' => esc_html_x( 'Share this', 'WhatsApp button label', 'toolbelt' ),
			'url' => 'https://wa.me/?text=%s',
		),
		'pinterest' => array(
			'title' => esc_html__( 'Pin on Pinterest', 'toolbelt' ),
			'label' => esc_html_x( 'Pin this', 'Pinterest button label', 'toolbelt' ),
			'url' => 'https://pinterest.com/pin/create/button/?url=%s',
		),
	);

	return apply_filters( 'tb_social_networks', $networks );

}


/**
 * Display the social styles.
 */
function tb_social_styles() {

	$path = plugin_dir_path( __FILE__ );

	// Output bar styles. Do this first so that the bar has styles instantly.
	echo '<style>';
	require $path . 'style.min.css';
	echo '</style>';

}
