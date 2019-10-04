<?php
/**
 * Display credits on the footer of each admin page.
 *
 * @package toolbelt
 */

?>

<style>
	.toolbelt-ratings { margin: 30px 0; }
	.toolbelt-ratings p { font-size: 16px; }
</style>

<div class="toolbelt-ratings">
	<p><?php esc_html_e( 'Toolbelt is a free plugin. If you find it useful then a review on wordpress.org would be most appreciated!', 'wp-toolbelt' ); ?></p>
	<p><a href="https://wordpress.org/support/plugin/wp-toolbelt/reviews/"><?php esc_html_e( 'Leave a review &rsaquo;', 'wp-toolbelt' ); ?></a></p>
</div>
