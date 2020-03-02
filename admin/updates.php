<?php
/**
 * Database and plugin updates.
 * And controls cron jobs.
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

	/**
	 * Deactivate all cron jobs.
	 */
	toolbelt_deactivate_cron();

	/**
	 * Enable crons for specific modules.
	 *
	 * Modules can share cron jobs. Just use the same duration.
	 */
	toolbelt_enable_cron( 'contact-form', 'daily' );
	toolbelt_enable_cron( 'spam-blocker', 'weekly' );

}

add_action( 'toolbelt_module_settings', 'toolbelt_contact_plugin_de_activation' );
add_action( 'upgrader_process_complete', 'toolbelt_contact_plugin_de_activation' );


/**
 * Enable WordPress cron for specific modules.
 *
 * @param string $module The module to load the cron for. If it's not active then quit.
 * @param string $cron_duration The duration of the cron job.
 * @return void
 */
function toolbelt_enable_cron( $module, $cron_duration = 'daily' ) {

	$options = toolbelt_get_options();
	$cron_key = 'toolbelt_cron_' . $cron_duration;

	// Quit if the module is not active.
	if ( ! isset( $options[ $module ] ) || 'on' !== $options[ $module ] ) {
		return;
	}

	// Enable the cron job if it hasn't been set up already.
	if ( ! wp_next_scheduled( $cron_key ) ) {
		wp_schedule_event( time(), $cron_duration, $cron_key );
	}

}


/**
 * Deactivate Toolbelt cron jobs.
 *
 * @return void
 */
function toolbelt_deactivate_cron() {

	wp_clear_scheduled_hook( 'toolbelt_cron_daily' );
	wp_clear_scheduled_hook( 'toolbelt_cron_weekly' );

}

add_filter( 'deactivate_wp-toolbelt', 'toolbelt_deactivate_cron' );
