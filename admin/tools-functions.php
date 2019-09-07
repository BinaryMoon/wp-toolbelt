<?php
/**
 * Functions called by the tools page.
 *
 * @package toolbelt
 */

/**
 * Convert toolbelt and related post types.
 *
 * @param string $action The action to perform.
 */
function toolbelt_tools_convert( $action ) {

	$types = array(
		'jetpack' => array(
			'post' => 'jetpack-portfolio',
			'category' => 'jetpack-portfolio-type',
			'tag' => 'jetpack-portfolio-tag',
		),
		'toolbelt' => array(
			'post' => 'toolbelt-portfolio',
			'category' => 'toolbelt-portfolio-type',
			'tag' => 'toolbelt-portfolio-tag',
		),
	);

	switch ( $action ) {

		case 'convert_toolbelt_portfolio':
			$from = 'toolbelt';
			$to = 'jetpack';

			break;

		default:
		case 'convert_jetpack_portfolio':
			$from = 'jetpack';
			$to = 'toolbelt';

			break;

	}

	global $wpdb;
	$message = '';

	// Convert post types.
	$rows = $wpdb->update(
		$wpdb->posts,
		array( 'post_type' => $types[ $to ]['post'] ),
		array( 'post_type' => $types[ $from ]['post'] )
	);

	// translators: %d = numbers of posts.
	$message .= '<li>' . sprintf( esc_html__( '%d posts converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	// Convert post categories.
	$rows = $wpdb->update(
		$wpdb->term_taxonomy,
		array( 'taxonomy' => $types[ $to ]['category'] ),
		array( 'taxonomy' => $types[ $from ]['category'] )
	);

	// translators: %d = numbers of categories.
	$message .= '<li>' . sprintf( esc_html__( '%d categories converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	// Convert post tags.
	$rows = $wpdb->update(
		$wpdb->term_taxonomy,
		array( 'taxonomy' => $types[ $to ]['tag'] ),
		array( 'taxonomy' => $types[ $from ]['tag'] )
	);

	// translators: %d = numbers of tags.
	$message .= '<li>' . sprintf( esc_html__( '%d tags converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	toolbelt_tools_message( '<ul>' . $message . '</ul>' );

}


/**
 * Remove comment author urls from the site.
 *
 * This is not currently in use anywhere but may be added as a tool in the
 * future.
 */
function toolbelt_tools_remove_comment_links() {

	global $wpdb;
	$message = '';

	// Convert post types.
	$rows = $wpdb->update(
		$wpdb->comments,
		array( 'comment_author_url' => '' )
	);

	toolbelt_tools_message( '<p>' . esc_html__( 'Comment Author Urls Erased', 'wp-toolbelt' ) . '</p>' );

}


/**
 * Display a success message after tools run.
 *
 * @param string $message The success message to display. Should be a collection of list items.
 */
function toolbelt_tools_message( $message ) {

	/**
	 * Output any messages.
	 * Sanitization is ignored since the properties are sanitized when the
	 * $message variable is set.
	 */
	echo '<div class="notice notice-success"><p><strong>' . esc_html__( 'Success', 'wp-toolbelt' ) . '</strong></p>' . $message . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}
