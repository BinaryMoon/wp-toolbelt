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

	$path = plugin_dir_path( __FILE__ );

	// Privacy policy message.
	/* Translators: %s = privacy policy link */
	$message = esc_html__( 'By using this website, you agree to our %s', 'toolbelt' );
	$link = esc_html__( 'cookie policy', 'toolbelt' );

	// If there's a privacy policy page then link to it.
	$privacy_policy_link = get_the_privacy_policy_link();
	if ( ! empty( $privacy_policy_link ) ) {
		$link = '<a href="' . $privacy_policy_link . '">' . $link . '</a>';
	}

	// Merge the message and the link.
	$message = sprintf( $message, $link );

	// Output bar styles. Do this first so that the bar has styles instantly.
	echo '<style>';
	require $path . 'style.min.css';
	echo '</style>';

	// Generate the template html.
	echo sprintf(
		'<section class="tb_cookie_wrapper"><strong>%s</strong><button class="tp_cookie_close">&times;</button></section>',
		$message
	);

	// Output scripts.
	echo '<script>';
	require $path . 'script.min.js';
	echo '</script>';

}

add_filter( 'wp_footer', 'toolbelt_cookie_footer' );
