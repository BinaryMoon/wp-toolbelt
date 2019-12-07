<?php
/**
 * Fathom Analytics.
 *
 * @see https://usefathom.com/
 * @package toolbelt
 */

/**
 * Display the Fathom Analytics tracking code.
 *
 * @return void
 */
function toolbelt_stats_fathom() {

	if ( ! toolbelt_stats_track() ) {

		return;

	}

	$settings = get_option( 'toolbelt_settings', array() );
	$site_id = '';

	if ( ! empty( $settings['stats-site-id'] ) ) {

		$site_id = $settings['stats-site-id'];

	}

	if ( empty( $site_id ) ) {

		return;

	}

?>

<!-- Fathom Analytics -->
<script>
	(function(f, a, t, h, o, m){
		a[h]=a[h]||function(){
			(a[h].q=a[h].q||[]).push(arguments)
		};
		o=f.createElement('script'),
		m=f.getElementsByTagName('script')[0];
		o.async=1; o.src=t; o.id='fathom-script';
		m.parentNode.insertBefore(o,m)
	})(document, window, '//cdn.usefathom.com/tracker.js', 'fathom');

	fathom('set', 'siteId', '<?php echo esc_attr( $site_id ); ?>');
	fathom('trackPageview');

	document.body.addEventListener(
		'toolbelt-is-load',
		function(event) {
			fathom('trackPageview');
		}
	);
</script>

<?php
}

add_action( 'wp_footer', 'toolbelt_stats_fathom' );


/**
 * Output prefetch info for Fathom.
 *
 * @param array<string> $urls          URLs to print for resource hints.
 * @param string        $relation_type The relation type the URLs are printed for, e.g. 'preconnect' or 'prerender'.
 * @return array<string>
 */
function toolbelt_stats_fathom_resource_hints( $urls, $relation_type ) {

	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://cdn.usefathom.com';
	}

	return $urls;

}

add_filter( 'wp_resource_hints', 'toolbelt_stats_fathom_resource_hints', 10, 2 );
