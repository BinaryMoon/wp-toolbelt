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

define( 'TOOLBELT_COOKIE_ACCEPTED', 'toolbelt_cookies_accepted' );

/**
 * Display the cookie data in the footer.
 *
 * @return void
 */
function toolbelt_cookie_footer() {

	$message = toolbelt_cookie_message();
	$buttons = toolbelt_cookie_buttons();

	toolbelt_styles( 'cookie-banner' );

	// Generate the template html.
	printf(
		'<section class="toolbelt_cookie_wrapper"><strong>%1$s</strong>%2$s</section>',
		wp_kses_data( $message ),
		// $buttons is generated in toolbelt_cookie_buttons and all of the content is escaped already.
		$buttons // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);

	echo '<script>';
	echo 'function toolbelt_cookies_accepted() {';
	do_action( TOOLBELT_COOKIE_ACCEPTED );
	echo '}';
	echo '</script>';

	toolbelt_scripts( 'cookie-banner' );

}

add_filter( 'wp_footer', 'toolbelt_cookie_footer' );


/**
 * Get the cookie banner message.
 *
 * @return void
 */
function toolbelt_cookie_message() {

	// Privacy policy message.
	// translators: %s = privacy policy link.
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


/**
 * Work out what buttons to display in the cookie bar.
 *
 * @return void
 */
function toolbelt_cookie_buttons() {

	$button_text = apply_filters(
		'toolbelt_cookie_button_text',
		array(
			'accept' => __( 'Accept', 'wp-toolbelt' ),
			'decline' => __( 'Decline', 'wp-toolbelt' ),
			'close' => __( '&times;', 'wp-toolbelt' ),
		)
	);

	$buttons = '';

	if ( has_action( TOOLBELT_COOKIE_ACCEPTED ) ) {

		// If actions have been assigned to the cookie approved message then display
		// accept and decline buttons.
		$buttons .= '<button class="toolbelt_cookie_accept">' . esc_html( $button_text['accept'] ) . '</button>';
		$buttons .= '<button class="toolbelt_cookie_decline">' . esc_html( $button_text['decline'] ) . '</button>';

	} else {

		// No actions so display the default close button.
		$buttons .= '<button class="toolbelt_cookie_accept toolbelt_cookie_close">' . esc_html( $button_text['close'] ) . '</button>';

	}

	return $buttons;

}

