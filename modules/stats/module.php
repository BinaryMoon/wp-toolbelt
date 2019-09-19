<?php
/**
 * Stats.
 *
 * @package toolbelt
 */

/**
 * Work out which stats module to load.
 */
function toolbelt_stats() {

	$settings = get_option( 'toolbelt_settings', array() );

	if ( isset( $settings['stats-provider'] ) ) {

		$path = plugin_dir_path( __FILE__ ) . 'module-' . $settings['stats-provider'] . '.php';

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}

}

toolbelt_stats();


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

	// Quit if no dashboard has been specified.
	if ( empty( $settings['stats-dashboard-url'] ) ) {
		return;
	}

	$args = array(
		'id' => 'toolbelt-stats',
		'title' => esc_html__( 'Site Stats', 'wp-toolbelt' ),
		'href' => esc_url( $settings['stats-dashboard-url'] ),
		'meta' => array(
			'class' => 'toolbelt-stats',
			'target' => '_blank',
		),
	);

	$wp_admin_bar->add_node( $args );

}

add_action( 'admin_bar_menu', 'toolbelt_stats_toolbar_link', 999 );
