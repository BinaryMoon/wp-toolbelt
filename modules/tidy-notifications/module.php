<?php
/**
 * Tidy plugin and theme notifications away into a sidebar that is hidden by default.
 *
 * @package toolbelt
 */

/**
 * Load styles in header.
 *
 * @return void
 */
function toolbelt_notifications_scripts_head() {

	if ( ! is_user_logged_in() ) {
		return;
	}

	toolbelt_styles( 'tidy-notifications' );
	toolbelt_global_styles( 'admin-bar-height' );

}

add_filter( 'admin_head', 'toolbelt_notifications_scripts_head' );


/**
 * Load notification scripts.
 *
 * @return void
 */
function toolbelt_notifications_scripts_footer() {

	if ( ! is_user_logged_in() ) {
		return;
	}

	toolbelt_scripts( 'tidy-notifications' );

}

add_filter( 'admin_footer', 'toolbelt_notifications_scripts_footer' );


/**
 * Add notifications menu to admin bar.
 *
 * @return void
 */
function toolbelt_notifications_menu() {

	if ( ! is_admin() ) {
		return;
	}

	global $wp_admin_bar;

	$title = sprintf(
		'<span class="ab-icon" aria-hidden="true"></span>
		<span class="ab-label" aria-hidden="true"></span>
		<span class="screen-reader-text comments-in-moderation-text">%1$s</span>',
		esc_html__( 'Display Notifications', 'toolbelt' )
	);

	$wp_admin_bar->add_node(
		array(
			'parent' => 'top-secondary',
			'id' => 'toolbelt-notifications-menu',
			'title' => $title,
			'href' => '#',
		)
	);

}

add_action( 'admin_bar_menu', 'toolbelt_notifications_menu', 999 );
