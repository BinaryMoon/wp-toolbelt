<?php
/**
 * Admin Tweaks
 *
 * @package toolbelt
 */

if ( ! is_admin() ) {
	return;
}


/**
 *
 */
function toolbelt_admin_tweaks() {

	if ( is_admin() ) {

		toolbelt_styles( 'admin-tweaks' );

	}

}

add_action( 'admin_head', 'toolbelt_admin_tweaks' );
