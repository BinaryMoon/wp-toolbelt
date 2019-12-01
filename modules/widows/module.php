<?php
/**
 * Fix typographic widows.
 *
 * @package wp-toolbelt
 */

/**
 * Add a non-breaking space between the last two words in a title.
 *
 * @param string $title The title to fix.
 * @return string
 */
function toolbelt_widows( $title = '' ) {

	/**
	 * Widont is a function found on wordpress.com and I imagine it's used on
	 * some themes elsewhere. So, just in case, I quit early if the function is
	 * in use,
	 */
	if ( function_exists( 'widont' ) ) {
		return $title;
	}

	$title = trim( $title );
	$space = strrpos( $title, ' ' );
	$count = substr_count( $title, ' ' );

	if ( $count <= 1 ) {
		return $title;
	}

	if ( false !== $space ) {
		$title = substr( $title, 0, $space ) . '&nbsp;' . substr( $title, $space + 1 );
	}

	return $title;

}

add_filter( 'the_title', 'toolbelt_widows' );
