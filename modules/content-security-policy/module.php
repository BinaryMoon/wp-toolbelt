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

function toolbelt_csp_headers() {
	$_csp_cache = wp_cache_get( 'csp-cache', 'toolbelt' );

	$default_options = array(
		'default-src'               => array(
			'*',
		),
		'upgrade-insecure-requests' => true,
		'block-all-mixed-content'   => true,
		'report-only'               => true,
		'report-uri'                => '',
		'report-to'                 => '', // New for CSP level 3 https://www.w3.org/TR/CSP/#changes-from-level-2
	);

	$admin_policy = apply_filters( 'toolbelt_csp_policy', $default_options );

	if ( false == $_csp_cache ) { // Only rebuild if cache is empty
		if ( true == $admin_policy['report-only'] ) {
			// Testing for report only mode, or 'production mode'
			$csp_string = "Content-Security-Policy-Report-Only";
		} else {
			$csp_string = "Content-Security-Policy";
		}

		foreach ( $admin_policy as $rule => $setting ) {
			if ( is_array( $setting ) ) {
				// If we have a more complex rule, or one with multiple
				// properties, build it a piece at a time

				$csp_string .= $rule;
				foreach ( $setting as $option ) {
					// Add the property to the rule
					$csp_string .= " {$option}";
				}
			} else if ( true == $setting ) {
				// Boolean values don't have any properties
				$csp_string .= "${rule}";
			} else {
				// Simpler k=>v properties
				$csp_string .= "{$rule} {$setting}";
			}
			$csp_string .= "; "; // separator
		}

		$csp_string = trim( $csp_string );

		wp_cache_set(
			'csp-cache',
			$csp_string,
			'toolbelt',
			3600 // One hour
		);

		header( $csp_string );
	} else {
		header( $_csp_cache );
	}
}

add_filter( 'send_headers', 'toolbelt_csp_headers' );
