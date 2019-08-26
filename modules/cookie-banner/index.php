<?php
/**
 * Cookie Banner
 *
 * @package toolbelt
 */

// Don't display in the WordPress admin.
if ( is_admin() ) {
	return;
}


/**
 * Display the cookie data in the footer.
 */
function toolbelt_cookie_footer() {

	$message = toolbelt_cookie_message();

	toolbelt_styles( 'cookie-banner' );

	// Generate the template html.
	printf(
		'<section class="toolbelt_cookie_wrapper"><strong>%s</strong><button class="tp_cookie_close">&times;</button></section>',
		wp_kses_data( $message )
	);

	// Output scripts.
	$path = plugin_dir_path( __FILE__ );

	echo '<script>';
	require $path . 'script.min.js';
	echo '</script>';

}

add_filter( 'wp_footer', 'toolbelt_cookie_footer' );


/**
 * Get the cookie banner message.
 */
function toolbelt_cookie_message() {

	// Privacy policy message.
	/* Translators: %s = privacy policy link */
	$message = esc_html__( 'By using this website, you agree to our %s', 'wp-toolbelt' );
	$link = esc_html__( 'cookie policy', 'wp-toolbelt' );

	// If there's a privacy policy page then link to it.
	$privacy_policy_link = get_the_privacy_policy_link();
	if ( ! empty( $privacy_policy_link ) ) {
		$link = $privacy_policy_link;
	}

	// Merge the message and the link.
	$message = sprintf( $message, $link );

	return apply_filters( 'toolbelt_cookie_message', $message );

}
