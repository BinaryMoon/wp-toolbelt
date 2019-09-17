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

<?php

	do_action( 'toolbelt_module_tools' );

?>

</div>
