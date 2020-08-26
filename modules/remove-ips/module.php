<?php
/**
 * Remove/ hide commenters IP addresses (for privacy).
 *
 * @package toolbelt
 */

/**
 * Change comment author IP addresses to 127.0.0.1.
 *
 * @return string
 */
function toolbelt_remove_ip() {

	return '127.0.0.1';

}

/**
 * Remove IPs on new comments when they are saved.
 */
add_filter( 'get_comment_author_IP', 'toolbelt_remove_ip' );

/**
 * Hide IPs on existing comments.
 */
add_filter( 'pre_comment_user_ip', 'toolbelt_remove_ip' );
