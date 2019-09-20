<?php
/**
 * Stats.
 *
 * @package toolbelt
 */

/**
 * Work out which stats module to load.
 *
 * @return void
 */
function toolbelt_stats() {

	$settings = get_option( 'toolbelt_settings', array() );

	/**
	 * Quit if no provider is set.
	 */
	if ( empty( $settings['stats-provider'] ) ) {

		return;

	}

	/**
	 * Get the file path for the relevant module.
	 *
	 * I'm escaping the path name to ensure nothing bad has been included. It's
	 * not actually output anywhere but I'd rather be safe than sorry.
	 */
	$path = plugin_dir_path( __FILE__ ) . 'module-' . esc_attr( $settings['stats-provider'] ) . '.php';

	// Make sure it's a valid provider.
	if ( file_exists( $path ) ) {

		require_once $path;

	}

}

toolbelt_stats();


/**
 * Should we track the current user/ page?
 *
 * @return bool
 */
function toolbelt_stats_track() {

	/**
	 * Don't track the admin.
	 */
	if ( is_admin() ) {

		return false;

	}

	/**
	 * Allow users to filter the display of the stats.
	 */
	if ( ! apply_filters( 'toolbelt_stats_track', true ) ) {

		return false;

	}

	return true;

}


/**
 * Add a link in the Admin Bar to the stats dashboard.
 *
 * In the future I would like to add a bar graph to the admin bar like the one
 * in Jetpack.
 *
 * @param WP_Admin_Bar $wp_admin_bar A reference to the admin bar object.
 * @return void
 */
function toolbelt_stats_toolbar_link( $wp_admin_bar ) {

	$settings = get_option( 'toolbelt_settings' );

	// Quit if no provider set.
	if ( empty( $settings['stats-provider'] ) ) {

		return;

	}

	// Quit if no dashboard has been specified.
	if ( empty( $settings['stats-dashboard-url'] ) ) {

		return;

	}

	/**
	 * Add the admin bar node.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_admin_bar/add_node/
	 */
	$wp_admin_bar->add_node(
		array(
			'id' => 'toolbelt-stats',
			'title' => esc_html__( 'Site Stats', 'wp-toolbelt' ),
			'href' => esc_url( $settings['stats-dashboard-url'] ),
			'meta' => array(
				'class' => 'toolbelt-stats',
				'target' => '_blank',
			),
		)
	);

}

add_action( 'admin_bar_menu', 'toolbelt_stats_toolbar_link', 999 );
