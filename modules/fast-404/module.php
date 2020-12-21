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
 *
 * @return void
 */
function toolbelt_404_response() {

	if ( ! is_404() ) {
		return;
	}

	global $wp;

	if ( ! empty( $wp->request ) ) {

		toolbelt_404_redirect( $wp->request );

		$file_extension = strtolower( pathinfo( $wp->request, PATHINFO_EXTENSION ) );

	}

	if ( ! isset( $file_extension ) ) {

		return;

	}

	$bad_file_types = array(
		'css',
		'txt',
		'md',
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

add_action( 'wp', 'toolbelt_404_response' );


/**
 * Check for file redirects.
 *
 * @param string $term The term to search for.
 * @return void
 */
function toolbelt_404_redirect( $term = '' ) {

	$term = trim( strtolower( $term ) );

	if ( ! $term ) {
		return;
	}

	$redirects = apply_filters( 'toolbelt_404_redirect', array() );

	if ( ! empty( $redirects ) ) {

		foreach ( $redirects as $r ) {

			if ( $term === $r['term'] ) {

				wp_safe_redirect( $r['url'] );
				exit;

			}

		}

	}

}
