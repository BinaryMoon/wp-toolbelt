<?php
/**
 * Spam Blocking.
 *
 * Uses the following methods.
 * 1. Url Honeypot (check for empty url).
 * 2. Comment blocklist (https://github.com/splorp/wordpress-comment-blacklist).
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
 *
 * @return void
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
 * @return array<string>
 */
function toolbelt_spam_form_fields( $fields ) {

	/**
	 * Hide the honeypot fields in public and display them on dev.
	 */
	$visibility = 'display: none;';

	/**
	 * Use the following filter to display the honeypot fields in a dev
	 * environment. Will also require enabling wp_debug.
	 * add_filter( 'toolbelt_spam_display_honeypot', '__return_true' );
	 */
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
	if ( null !== $toolbelt_key && TOOLBELT_SPAM_KEY !== $toolbelt_key ) {
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
add_filter( 'toolbelt_contact_form_spam', 'toolbelt_spam_check' );


/**
 * Check content against the blocklist.
 *
 * This is largely lifted from the comment blocklist checker.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_blacklist_check/
 *
 * @param string $content The content to check.
 * @return bool
 */
function toolbelt_spam_blocklist_check( $content ) {

	$mod_keys = trim( get_option( 'blacklist_keys' ) );
	if ( empty( $mod_keys ) ) {
		return false;
	}

	// Ensure HTML tags are not being used to bypass the blocklist.
	$comment_without_html = wp_strip_all_tags( $content );

	$words = explode( "\n", $mod_keys );

	/**
	 * Loop through all the blocklist words and check them against the content
	 * value.
	 */
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

add_filter( 'toolbelt_contact_form_spam_content', 'toolbelt_spam_blocklist_check' );


/**
 * Combine the plugin blocklist with the WordPress one.
 *
 * The blocklist is loaded from:
 *
 * @link https://github.com/splorp/wordpress-comment-blacklist
 *
 * @param string $blocklist Current option values.
 * @return string
 */
function toolbelt_spam_blocklist( $blocklist ) {

	/**
	 * Convert the built in blocklist into a big old list.
	 */
	if ( ! empty( $blocklist ) ) {
		$blocklist = explode( "\n", $blocklist );
	} else {
		// Ensure the blocklist is an array so that the rest works.
		$blocklist = array();
	}

	/**
	 * Get the local list of blocklist terms.
	 */
	$local = (array) file( plugin_dir_path( __FILE__ ) . 'blocklist.txt', FILE_IGNORE_NEW_LINES );

	// Merge both lists into a single array.
	$listmerge = array_merge( $local, $blocklist );

	// Filter out duplicates.
	$listunique = array_unique( $listmerge );

	// Implode it back to a list and return it.
	return implode( "\n", $listunique );

}

add_filter( 'option_blocklist_keys', 'toolbelt_spam_blocklist' );
