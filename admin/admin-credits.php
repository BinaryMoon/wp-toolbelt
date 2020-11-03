<?php
/**
 * Display credits on the footer of each admin page.
 *
 * @package toolbelt
 */

?>

<style>
	.toolbelt-ratings {
		margin: 30px 0;
		padding: 1px 15px;
		background: rgba( 255,255,200, 0.5 );
		border-radius: 5px;
	}
	.toolbelt-ratings p { font-size: 14px; }
	.toolbelt-links [role=separator] {
		margin: 0 0.5em;
		opacity: 0.5;
	}
</style>

<div class="toolbelt-ratings">
	<p><?php esc_html_e( 'Toolbelt is a free plugin. If you find it useful then a review on wordpress.org would be most appreciated!', 'wp-toolbelt' ); ?></p>
	<p><a href="https://wordpress.org/support/plugin/wp-toolbelt/reviews/"><?php esc_html_e( 'Leave a review &rsaquo;', 'wp-toolbelt' ); ?></a></p>
</div>

<nav class="toolbelt-links">
	<a href="https://github.com/BinaryMoon/wp-toolbelt"><?php esc_html_e( 'Join us on Github', 'wp-toolbelt' ); ?></a>
	<span role="separator">|</span>
	<a href="https://github.com/BinaryMoon/wp-toolbelt/wiki"><?php esc_html_e( 'Read the docs', 'wp-toolbelt' ); ?></a>
</nav>
