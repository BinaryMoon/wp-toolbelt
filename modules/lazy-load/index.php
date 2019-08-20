<?php
/**
 * Use ative lazy loading.
 *
 * @package toolbelt
 */

/**
 * Add 'loading="lazy" to all images in 'the_content'.
 *
 * @param string $content The post content.
 * @return string
 */
function toolbelt_lazy_load( $content ) {

	return preg_replace(
		'/<img /',
		'<img loading="lazy" ',
		$content
	);

	return preg_replace(
		'/(< [^>]*?)(\ssrc=)(.*?\/?>)/',
		'\1 loading="lazy" src=\3',
		$content
	);

}

add_filter( 'the_content', 'toolbelt_lazy_load', 100 );
