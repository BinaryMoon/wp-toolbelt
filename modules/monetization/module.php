<?php
/**
 * Add support for Coil and the monetisation standard.
 *
 * @package toolbelt
 */

/**
 * Display monetization meta tag in the site header.
 */
function toolbelt_monetization() {

	$settings = get_option( 'toolbelt_settings', array() );

	if ( empty( $settings['monetization'] ) ) {
		return;
	}

	$key = $settings['monetization'];

?>
	<meta name="monetization" content="<?php echo esc_attr( $key ); ?>" />
<?php

}

add_action( 'wp_head', 'toolbelt_monetization' );
