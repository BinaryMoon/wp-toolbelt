<?php
/**
 * Admin Tweaks
 *
 * @package toolbelt
 */

/**
 * Display some custom css to tweak the WordPress admin.
 *
 * @return void
 */
function toolbelt_admin_tweaks() {

	if ( ! is_admin() ) {
		return;
	}

	toolbelt_styles( 'admin-tweaks' );

}

add_action( 'admin_head', 'toolbelt_admin_tweaks' );
add_action( 'customize_controls_print_styles', 'toolbelt_admin_tweaks' );
