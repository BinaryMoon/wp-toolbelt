<?php
/**
 * Content of the Toolbelt settings page.
 *
 * @package toolbelt
 */

?>

<style>
	.wrap { max-width: 600px; margin: 0 auto; }
	.wrap fieldset { margin-bottom: 45px; }
</style>

<div class="wrap">

	<h1 class="wp-heading-inline"><?php esc_html_e( 'Toolbelt Settings', 'wp-toolbelt' ); ?></h1>

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->

	<form action="" method="POST">

<?php

	do_action( 'toolbelt_module_settings_fields' );

	wp_nonce_field( 'toolbelt_settings' );
	submit_button( esc_html__( 'Save Settings', 'wp-toolbelt' ) );

?>

	</form>

	<?php require 'admin-credits.php'; ?>

</div>
