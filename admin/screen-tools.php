<?php
/**
 * Content of the Toolbelt tools page.
 *
 * @package toolbelt
 */

?>

<style>
	.wrap { max-width: 600px; margin: 0 auto; }
	section { margin-bottom: 45px; }
	section h2 { font-size: 1.6em; font-weight: 600; }
	section p.submit { margin-top: 0; padding-top: 0; }
</style>

<div class="wrap">

	<h1><?php esc_html_e( 'Toolbelt Tools', 'wp-toolbelt' ); ?></h1>

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->

<?php

	do_action( 'toolbelt_module_tools' );

?>

</div>
