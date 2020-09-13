<?php
/**
 * Spam blocker Cron Jobs.
 *
 * @package toolbelt
 */

/**
 * Update the blocklist.txt file from Github.
 *
 * @return void
 */
function toolbelt_spam_blocker_update_blocklist() {

	// Load the blocklist.
	$response = wp_remote_get(
		'https://raw.githubusercontent.com/splorp/wordpress-comment-blacklist/master/blacklist.txt'
	);

	// Quit on error.
	if ( is_wp_error( $response ) ) {
		return;
	}

	// Check is valid response.
	if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return;
	}

	file_put_contents(
		'blocklist.txt',
		wp_remote_retrieve_body( $response ),
		FILE_USE_INCLUDE_PATH
	);

}

add_action( 'toolbelt_cron_weekly', 'toolbelt_spam_blocker_update_blocklist' );
