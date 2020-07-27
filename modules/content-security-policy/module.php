<?php
/**
 * Content Security Policy.
 *
 * @package toolbelt
 */

// Don't display in the WordPress admin.
if ( is_admin() ) {
	return;
}

/**
 * Output Content Security Policy Headers.
 *
 * @return void
 */
function toolbelt_csp_headers() {

	$default_options = array(
		'default-src'               => array(
			'*',
		),
		'upgrade-insecure-requests' => true,
		'block-all-mixed-content'   => true,
		'report-only'               => true,
		'report-uri'                => '',
		'report-to'                 => '', // New for CSP level 3 https://www.w3.org/TR/CSP/#changes-from-level-2.
	);

	$admin_policy = apply_filters( 'toolbelt_csp_policy', $default_options );

	$_csp_cache = wp_cache_get( 'toolbelt-csp-cache', 'toolbelt' );

	// Only rebuild if cache is empty.
	if ( false === $_csp_cache ) {

		if ( true === $admin_policy['report-only'] ) {
			// Testing mode.
			$csp_string = 'Content-Security-Policy-Report-Only';
		} else {
			// Enforce mode.
			$csp_string = 'Content-Security-Policy';
		}

		foreach ( $admin_policy as $rule => $setting ) {

			if ( is_array( $setting ) ) {

				/**
				 * If we have a more complex rule, or one with multiple
				 * properties, build it a piece at a time.
				 */
				$csp_string .= $rule;
				foreach ( $setting as $option ) {

					// Add the property to the rule.
					$csp_string .= " {$option}";

				}

			} elseif ( true === $setting ) {

				// Boolean values don't have any properties.
				$csp_string .= "${rule}";

			} else {

				// Simpler k=>v properties.
				$csp_string .= "{$rule} {$setting}";

			}

			// Separator.
			$csp_string .= '; ';

		}

		$csp_string = trim( $csp_string );

		// Stuff it into the cache.
		wp_cache_set(
			'toolbelt-csp-cache',
			$csp_string,
			'toolbelt',
			HOUR_IN_SECONDS
		);

		// Send the header.
		header( $csp_string );

	} else {

		// Send the cached header.
		header( $_csp_cache );

	}

}

add_filter( 'send_headers', 'toolbelt_csp_headers' );
