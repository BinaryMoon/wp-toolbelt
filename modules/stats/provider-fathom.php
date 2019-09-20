<?php
/**
 * Fathom Analytics.
 *
 * @see https://usefathom.com/
 * @package toolbelt
 */

/**
 * Display the Fathom Analytics tracking code.
 */
function toolbelt_stats_fathom() {

	if ( ! toolbelt_stats_track() ) {

		return;

	}

	$settings = get_option( 'toolbelt_settings', array() );
	$site_id = '';

	if ( ! empty( $settings['stats-site-id'] ) ) {

		$code = $settings['stats-site-id'];

	}

	if ( empty( $site_id ) ) {

		return;

	}

?>

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
</script>

<?php
}

add_action( 'wp_footer', 'toolbelt_stats_fathom' );
