<?php
/**
 * Use native lazy loading.
 *
 * We will delete this once WordPress Core supports lazy loading natively.
 *
 * @see https://github.com/WordPress/wp-lazy-loading
 * @see https://wordpress.org/plugins/wp-lazy-loading/
 * @see https://make.wordpress.org/core/2020/01/29/lazy-loading-images-in-wordpress-core/
 *
 * @package toolbelt
 */

/**
 * Add 'loading="lazy" to images.
 *
 * @param string $content The content to check.
 * @return string
 */
function toolbelt_lazy_load_image( $content ) {

	/**
	 * Don't do anything if WordPress core lazy loading is available.
	 */
	if ( function_exists( 'wp_lazy_loading_enabled' ) ) {
		return $content;
	}

	return (string) preg_replace(
		'/<img /',
		'<img loading="lazy" ',
		$content
	);

}


/**
 * Add 'loading="lazy" to iframes.
 *
 * @param string $content The content to check.
 * @return string
 */
function toolbelt_lazy_load_iframe( $content ) {

	/**
	 * Don't do anything if WordPress core lazy loading is available.
	 */
	if ( function_exists( 'wp_lazy_loading_enabled' ) ) {
		return $content;
	}

	return (string) preg_replace(
		'/<iframe /',
		'<iframe loading="lazy" ',
		$content
	);

}

add_filter( 'the_content', 'toolbelt_lazy_load_image', 100 );
add_filter( 'the_content', 'toolbelt_lazy_load_iframe', 100 );
add_filter( 'get_avatar', 'toolbelt_lazy_load_image', 100 );
