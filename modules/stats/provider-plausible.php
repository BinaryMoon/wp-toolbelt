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
