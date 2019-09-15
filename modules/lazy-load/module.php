<?php
/**
 * Use ative lazy loading.
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

	return (string) preg_replace(
		'/<iframe /',
		'<iframe loading="lazy" ',
		$content
	);

}

add_filter( 'the_content', 'toolbelt_lazy_load_image', 100 );
add_filter( 'the_content', 'toolbelt_lazy_load_iframe', 100 );
add_filter( 'get_avatar', 'toolbelt_lazy_load_image', 100 );
