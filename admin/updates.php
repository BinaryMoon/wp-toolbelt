<?php
/**
 * Database and plugin updates.
 *
 * @package toolbelt
 */

/**
 * Delete autoloading transients.
 *
 * @return void
 */
function toolbelt_related_posts_clear_transients() {

	global $wpdb;
	$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_toolbelt_related_post_%') AND autoload = 'yes'" );

}

add_action( 'toolbelt_module_settings', 'toolbelt_related_posts_clear_transients' );
