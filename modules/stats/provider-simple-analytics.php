<?php
/**
 * Simple Analytics
 *
 * @see https://simpleanalytics.com/
 * @package toolbelt
 */

/**
 * Display the Simple Analytics tracking code.
 *
 * @see https://docs.simpleanalytics.com/script
 *
 * @return void
 */
function toolbelt_stats_simple_analytics() {

	if ( ! toolbelt_stats_track() ) {

		return;

	}

?>

<!-- Simple Analytics -->
<script async defer src="https://cdn.simpleanalytics.io/hello.js"></script> <?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript ?>
<noscript><img src="https://api.simpleanalytics.io/hello.gif" alt=""></noscript>

<?php

}

add_action( 'wp_footer', 'toolbelt_stats_simple_analytics' );


/**
 * Output prefetch info for Plausible.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for, e.g. 'preconnect' or 'prerender'.
 * @return array<string>
 */
function toolbelt_stats_simple_analytics_resource_hints( $urls, $relation_type ) {

	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://api.simpleanalytics.io';
		$urls[] = 'https://cdn.simpleanalytics.io';
	}

	return $urls;

}

add_filter( 'wp_resource_hints', 'toolbelt_stats_simple_analytics_resource_hints', 10, 2 );
