<?php
/**
 * Content of the Toolbelt tools page.
 *
 * @package toolbelt
 */

?>

<div class="wrap">

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->
	<h1><?php esc_html_e( 'Toolbelt Tools', 'wp-toolbelt' ); ?></h1>

	<form action="" method="POST">

		<h2><?php esc_html_e( 'Convert Jetpack Portfolio to Toolbelt Portfolio', 'wp-toolbelt' ); ?></h2>
		<input type="hidden" name="action" value="convert_jetpack_portfolio" />
		<p><?php esc_html_e( 'Jetpack has its own Portfolio post type. This command converts the Jetpack posts to Toolbelt Portfolio posts.', 'wp-toolbelt' ); ?></p>
		<?php wp_nonce_field( 'toolbelt_convert_jetpack_portfolio' ); ?>
		<?php submit_button( esc_html__( 'Convert', 'wp-toolbelt' ) ); ?>

	</form>

	<form action="" method="POST">

		<h2><?php esc_html_e( 'Convert Toolbelt Portfolio to Jetpack Portfolio', 'wp-toolbelt' ); ?></h2>
		<input type="hidden" name="action" value="convert_toolbelt_portfolio" />
		<p><?php esc_html_e( 'Convert Toolbelt portfolio items so they will work with Jetpack.', 'wp-toolbelt' ); ?></p>
		<?php wp_nonce_field( 'toolbelt_convert_toolbelt_portfolio' ); ?>
		<?php submit_button( esc_html__( 'Convert', 'wp-toolbelt' ) ); ?>

	</form>

</div>
