<?php
/**
 * Spam Blocking.
 *
 * Uses the following methods.
 * 1. Url Honeypot (check for empty url).
 * 2. Comment Blacklist (https://github.com/splorp/wordpress-comment-blacklist).
 * 3. Key Honeypot (check for altered key).
 * 4. Javascript checker (https://davidwalsh.name/wordpress-comment-spam).
 *
 * @package toolbelt
 */

/**
 * Inspiration
 *
 * WordPress Zero Spam is based on the ideas outlined in David Walshes spam blocker.
 *
 * @link https://github.com/bmarshall511/wordpress-zero-spam
 */

/**
 * Add a spam key. This will change with each plugin update.
 */
define( 'TOOLBELT_SPAM_KEY', md5( 'toolbelt-spam-key' . TOOLBELT_VERSION ) );


/**
 * Output the spam blocker javascript.
 */
function toolbelt_spam_scripts() {

	toolbelt_scripts( 'spam-blocker' );

}

add_action( 'wp_footer', 'toolbelt_spam_scripts' );


/**
 * Add Honeypot URL field.
 * This acts as a honeypot.
 *
 * @param array $fields List of form fields to display.
 * @return array
 */
function toolbelt_spam_form_fields( $fields ) {

	/**
	 * Hide the honeypot fields in public and display them on dev.
	 */
	$visibility = 'display: none;';

	if ( WP_DEBUG && apply_filters( 'toolbelt_spam_visible_honeypot', false ) ) {
		$visibility = '';
	}

	$fields['toolbelt-url'] = '<input type="url" value="" name="toolbelt-url" id="toolbelt-url" style="' . esc_attr( $visibility ) . '" />';
	$fields['toolbelt-junk'] = '<input type="text" value="' . esc_attr( TOOLBELT_SPAM_KEY ) . '" name="toolbelt-key" id="toolbelt-key" style="' . esc_attr( $visibility ) . '" />';

	return $fields;

}

add_filter( 'comment_form_default_fields', 'toolbelt_spam_form_fields', 11 );


/**
 * Check for comment spam.
 *
 * @param int|string $approved The current comment status.
 * @param array      $comment Information about the comment.
 * @return int|string
 */
function toolbelt_spam_check_comments( $approved, $comment ) {

	/**
	 * Ignore logged in users.
	 */
	if ( is_user_logged_in() ) {
		return $approved;
	}

	/**
	 * Ignore pingbacks and trackbacks.
	 */
	$type = $comment['comment_type'];
	if ( 'trackback' === $type || 'pingback' === $type ) {
		return $approved;
	}

	/**
	 * If the url field has been filled out then it must be spam.
	 */
	$toolbelt_url = filter_input( INPUT_POST, 'toolbelt-url' );
	if ( null !== $toolbelt_url && strlen( $toolbelt_url ) > 0 ) {
		$approved = 'spam';
	}

	/**
	 * If the key field has been changed then it must be spam.
	 */
	$toolbelt_key = filter_input( INPUT_POST, 'toolbelt-key' );
	if ( TOOLBELT_SPAM_KEY !== $toolbelt_key ) {
		$approved = 'spam';
	}

	/**
	 * If the check field does not exist then it's spam (or a user has javascript disabled).
	 */
	$toolbelt_check = filter_input( INPUT_POST, 'toolbelt-check' );
	if ( '1' !== $toolbelt_check ) {
		$approved = 'spam';
	}

	return $approved;

}

add_filter( 'pre_comment_approved', 'toolbelt_spam_check_comments', 10, 2 );


/**
 * Generic form spam check.
 * Only checks for the field added on submission,
 *
 * @return boolean
 */
function toolbelt_spam_check() {

	/**
	 * If the check field does not exist then it's spam (or a user has javascript disabled).
	 */
	$toolbelt_check = filter_input( INPUT_POST, 'toolbelt-check' );
	if ( '1' !== $toolbelt_check ) {
		// Return IS spam.
		return true;
	}

	// Return NOT spam.
	return false;

}

add_filter( 'jetpack_contact_form_is_spam', 'toolbelt_spam_check' );
add_filter( 'gform_entry_is_spam', 'toolbelt_spam_check' );


/**
 * Check content against the blacklist.
 *
 * This is largely lifted from the comment blacklist checker.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_blacklist_check/
 *
 * @param string $content The content to check.
 * @return bool
 */
function toolbelt_spam_blacklist_check( $content ) {

	$mod_keys = trim( get_option( 'blacklist_keys' ) );
	if ( empty( $mod_keys ) ) {
		return false;
	}

	// Ensure HTML tags are not being used to bypass the blacklist.
	$comment_without_html = wp_strip_all_tags( $content );

	$words = explode( "\n", $mod_keys );

	foreach ( (array) $words as $word ) {

		$word = trim( $word );

		// Skip empty lines.
		if ( empty( $word ) ) {
			continue;
		}

		// Do some escaping magic so that '#' chars in the
		// spam words don't break things.
		$word = preg_quote( $word, '#' );

		$pattern = "#$word#i";
		if ( preg_match( $pattern, $content ) ) {
			return true;
		}
	}

	return false;

}


/**
 * Combine the plugin blacklist with the WordPress one.
 *
 * The blacklist is loaded from:
 *
 * @link https://github.com/splorp/wordpress-comment-blacklist
 *
 * @param string $blacklist Current option values.
 * @return string
 */
function toolbelt_spam_blacklist( $blacklist ) {

	/**
	 * Convert the built in blacklist into a big old list.
	 */
	if ( ! empty( $blacklist ) ) {
		$blacklist = explode( "\n", $blacklist );
	} else {
		// Ensure the blacklist is an array so that the rest works.
		$blacklist = array();
	}

	/**
	 * Get the local list of blacklist terms.
	 */
	$local = (array) file( plugin_dir_path( __FILE__ ) . 'blacklist.txt', FILE_IGNORE_NEW_LINES );

	// Merge both lists into a single array.
	$listmerge = array_merge( $local, $blacklist );

	// Filter out duplicates.
	$listunique = array_unique( $listmerge );

	// Implode it back to a list and return it.
	return implode( "\n", $listunique );

}

add_filter( 'option_blacklist_keys', 'toolbelt_spam_blacklist' );
