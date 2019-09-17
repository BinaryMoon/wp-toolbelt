<?php
/**
 * Content of the Toolbelt tools page.
 *
 * @package toolbelt
 */

?>

<style>
.about-wrap h2 {
	text-align: left;
}
p.submit {
	margin-top: 0;
	padding: 0;
}
</style>

<div class="wrap about-wrap full-width-layout">

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->
	<h1><?php esc_html_e( 'Toolbelt Tools', 'wp-toolbelt' ); ?></h1>

<?php

	do_action( 'toolbelt_module_tools' );

?>

</div>
