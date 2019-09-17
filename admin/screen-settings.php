<?php
/**
 * Content of the Toolbelt settings page.
 *
 * @package toolbelt
 */

?>

<style>
.about-wrap h2 {
	text-align: left;
}
</style>

<div class="wrap about-wrap full-width-layout">

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->
	<h1><?php esc_html_e( 'Toolbelt Settings', 'wp-toolbelt' ); ?></h1>

	<form action="" method="POST">

<?php

	do_action( 'toolbelt_module_settings_fields' );

	wp_nonce_field( 'toolbelt_settings' );
	submit_button( esc_html__( 'Save', 'wp-toolbelt' ) );

?>

	</form>

</div>
