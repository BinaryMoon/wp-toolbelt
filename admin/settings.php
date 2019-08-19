
<?php
/**
 * Content of the Toolbelt settings page.
 *
 * @package toolbelt
 */

?>

<style>
	.column-title { width: 20%; }
</style>

<div class="wrap about-wrap full-width-layout">

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->
	<h1><?php esc_html_e( 'Toolbelt settings', 'toolbelt' ); ?></h1>

	<div class="about-text"><?php esc_html_e( 'Toolbelt is a lightweight, privacy focused, collection of things that add commonly needed features to your WordPress website.', 'toolbelt' ); ?></div>

	<form action="" method="POST">

		<?php wp_nonce_field( 'toolbelt_settings' ); ?>

		<table class="wp-list-table widefat fixed striped">

<?php

	$modules = tb_get_modules();

	foreach ( $modules as $slug => $module ) {
		tb_field(
			array(
				'key' => $slug,
				'name' => $module['name'],
				'description' => $module['description'],
				'docs' => $module['docs'],
			)
		);
	}

?>

		</table>

		<?php submit_button( esc_html__( 'Save Settings', 'toolbelt' ) ); ?>

	</form>

</div>
