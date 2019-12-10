<?php
/**
 * Database and plugin updates.
 *
 * @package toolbelt
 */

/**
 * Delete autoloading related posts transients.
 *
 * @return void
 */
function toolbelt_related_posts_clear_transients() {

	global $wpdb;

	$wpdb->query(
		"DELETE FROM `$wpdb->options`
			WHERE `option_name`
			LIKE ('_transient_toolbelt_related_post_%') AND autoload = 'yes'"
	);

}

add_action( 'toolbelt_module_settings', 'toolbelt_related_posts_clear_transients' );
add_action( 'upgrader_process_complete', 'toolbelt_related_posts_clear_transients' );


/**
 * Enable/ Disable the contact form cron job.
 *
 * @return void
 */
function toolbelt_contact_plugin_de_activation() {

	$options = toolbelt_get_options();
	$module_active = isset( $options['contact-form'] ) && ( 'on' === $options['contact-form'] );
	$cron_key = 'toolbelt_contact_cron';

	// Enable the cron job if it hasn't been set up already.
	if ( $module_active ) {

		if ( ! wp_next_scheduled( $cron_key ) ) {
			wp_schedule_event( time(), 'daily', $cron_key );
		}
	}

	// Disable the cron job if it is currently running.
	if ( ! $module_active ) {

		wp_clear_scheduled_hook( $cron_key );

	}

}

add_action( 'toolbelt_module_settings', 'toolbelt_contact_plugin_de_activation' );
add_action( 'upgrader_process_complete', 'toolbelt_contact_plugin_de_activation' );
