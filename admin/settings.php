
<?php
/**
 * Content of the Toolbelt settings page.
 *
 * @package toolbelt
 */

?>

<style>
	.column-title { width: 20%; }
	.column-docs { width: 10%; }
	.column-weight { font-style: italic; }
</style>

<div class="wrap about-wrap full-width-layout">

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->
	<h1><?php esc_html_e( 'Toolbelt settings', 'wp-toolbelt' ); ?></h1>

	<div class="about-text"><?php esc_html_e( 'Toolbelt is a lightweight, privacy focused, collection of things that add commonly needed features to your WordPress website.', 'wp-toolbelt' ); ?></div>

	<form action="" method="POST">

		<?php wp_nonce_field( 'toolbelt_settings' ); ?>

		<table class="wp-list-table widefat fixed striped">

<?php

	$modules = toolbelt_get_modules();

	foreach ( $modules as $slug => $module ) {
		toolbelt_field(
			$slug,
			$module
		);
	}

?>

		</table>

		<?php submit_button( esc_html__( 'Save Settings', 'wp-toolbelt' ) ); ?>

	</form>

</div>
