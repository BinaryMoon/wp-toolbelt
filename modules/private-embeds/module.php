<?php
/**
 * Make website embeds private.
 *
 * @package toolbelt
 */

/**
 * Swap the default Youtube urls for a safe, no-cookie, version.
 *
 * @param string $content The post content.
 * @return string
 */
function toolbelt_embed_youtube( $content ) {

	return str_replace( 'src="https://www.youtube.com/embed', 'src="https://www.youtube-nocookie.com/embed', $content );

}

add_filter( 'the_content', 'toolbelt_embed_youtube', 99 );


/**
 * Replace iframe embeds with the privacy shield button.
 *
 * @param string $html The iframe html to be processed.
 * @return string
 */
function toolbelt_embed_privacy_shield( $html ) {

	if ( is_admin() || toolbelt_is_rest_request() ) {
		return $html;
	}

	if ( ! strpos( $html, 'iframe' ) ) {
		return $html;
	}

	/**
	 * Get iframe properties.
	 *
	 * DOMDocument can cause a lot of errors to be output.
	 * Using libxml_use_internal_errors ensures that errors are not displayed to the user.
	 */
	libxml_use_internal_errors( true );
	$dom = new DOMDocument();
	/**
	 * Include the <?xml version?> to ensure text encodes properly.
	 */
	$dom->loadHTML( '<?xml version="1.0" encoding="UTF-8"?>' . $html );

	// Get the iframe and it's properties.
	$iframe = $dom->getElementsByTagName( 'iframe' );

	// Store the iframe url to be processed.
	$url = wp_parse_url( $iframe[0]->getAttribute( 'src' ) );

	$title = $iframe[0]->getAttribute( 'title' );
	if ( empty( $title ) ) {
		$title = $url['host'];
	}

	// The label to get users to load the iframe.
	$load_button_label = sprintf(
		// translators: %s = the social network to load.
		__( 'Click to load "%s"', 'wp-toolbelt' ),
		$title
	);

	/**
	 * A privacy notice informing the user of what website the iframe will be
	 * loaded from.
	 */
	$privacy_notice = sprintf(
		// translators: %s = website domain name.
		__( '%s may use cookies', 'wp-toolbelt' ),
		$url['host']
	);

	// Generate the button element.
	$new_html = sprintf(
		'<button data-iframe="%1$s" class="toolbelt-embed-shield toolbelt-embed-shield-%2$s"><strong>%3$s</strong><small>%4$s</small></button>',
		htmlentities( toolbelt_embed_youtube( $html ) ),
		esc_attr( sanitize_title( $url['host'] ) ),
		esc_html( $load_button_label ),
		esc_html( $privacy_notice )
	);

	// Output the styles for the button.
	toolbelt_styles( 'private-embeds' );

	return $new_html;

}

add_filter( 'embed_oembed_html', 'toolbelt_embed_privacy_shield' );


/**
 * Load the private embed script.
 *
 * @return void
 */
function toolbelt_embed_private_script() {

	toolbelt_scripts( 'private-embeds' );

};

add_filter( 'wp_footer', 'toolbelt_embed_private_script' );
