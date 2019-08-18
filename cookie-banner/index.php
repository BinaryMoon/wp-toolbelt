<?php
/**
 * Cookie Banner
 */

// Don't display in the WordPress admin.
if ( is_admin() ) {
	return;
}

function toolbelt_cookie_footer() {

	$path = plugin_dir_path( __FILE__ );

	$message = esc_html__( 'By using this website, you agree to our cookie policy', 'toolbelt' );

	$template = sprintf(
		'<section class="tb_cookie_wrapper"><strong>%s</strong><button class="tp_cookie_close">&times;</button></section>',
		$message
	);

	echo $template;

	echo '<script>';
	require $path . 'script.min.js';
	echo '</script>';

	echo '<style>';
	require $path . 'style.min.css';
	echo '</style>';

}

add_filter( 'wp_footer', 'toolbelt_cookie_footer' );
