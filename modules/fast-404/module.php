<?php
/**
 * Add simple 404 page for static files.
 *
 * Means that full page requests are not made if things like images or scripts
 * do not exist.
 *
 * @package toolbelt
 */

/**
 * Do a 404 response for the files that don't need to be accessed.
 */
function toolbelt_404_response() {

	if ( ! is_404() ) {
		return;
	}

	if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {

		global $wp;
		$file_extension = strtolower( pathinfo( $wp->request, PATHINFO_EXTENSION ) );

	}

	if ( ! isset( $file_extension ) ) {
		return;
	}

	$bad_file_types = array(
		'css',
		'txt',
		'jpg',
		'gif',
		'rar',
		'zip',
		'png',
		'bmp',
		'tar',
		'doc',
		'xml',
		'js',
		'docx',
		'xls',
		'xlsx',
		'svg',
		'webp',
	);

	// If it's a disallowed file extension then just quit.
	if ( in_array( $file_extension, $bad_file_types, true ) ) {

		header( 'HTTP/1.1 404 Not Found' );
		esc_html_e( '404 error - file does not exist', 'wp-toolbelt' );
		die();

	}

}

add_filter( 'template_redirect', 'toolbelt_404_response' );
