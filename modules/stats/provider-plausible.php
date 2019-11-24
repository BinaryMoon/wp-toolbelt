<?php
/**
 * Plausible Analytics.
 *
 * @see https://plausible.io
 * @package toolbelt
 */

/**
 * Display the Plausible tracking code.
 */
function toolbelt_stats_plausible() {

	if ( ! toolbelt_stats_track() ) {

		return;

	}

?>

<!-- Plausible Analytics -->
<script>
	(function (w,d,s,o,f,js,fjs) {
		w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };
		js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];
		js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);
	}(window, document, 'script', 'plausible', 'https://plausible.io/js/p.js'));

	plausible('page')

	document.body.addEventListener(
		'toolbelt-is-load',
		function(event) {
			plausible('page')
		}
	);
</script>

<?php

}

add_action( 'wp_footer', 'toolbelt_stats_plausible' );


/**
 * Output prefetch info for Plausible.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for, e.g. 'preconnect' or 'prerender'.
 */
function toolbelt_stats_plausible_resource_hints( $urls, $relation_type ) {

	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://plausible.io';
	}

	return $urls;

}

add_filter( 'wp_resource_hints', 'toolbelt_stats_plausible_resource_hints', 10, 2 );
