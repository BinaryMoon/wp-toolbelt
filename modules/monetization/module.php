<?php
/**
 * Add support for Coil and the monetisation standard.
 *
 * @package toolbelt
 */

/**
 * Don't monetize the admin.
 */
if ( is_admin() ) {
	return;
}


/**
 * Display monetization meta tag in the site header.
 *
 * @return void
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
