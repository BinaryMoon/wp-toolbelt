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
