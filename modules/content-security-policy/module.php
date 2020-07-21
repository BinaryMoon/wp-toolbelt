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

	if ( false == $_csp_cache ) {
		if ( true == $admin_policy['report-only'] ) {
			$csp_string = "Content-Security-Policy-Report-Only";
		} else {
			$csp_string = "Content-Security-Policy";
		}

		foreach ( $admin_policy as $rule => $setting ) {
			if ( is_array( $setting ) ) {
				$csp_string .= $rule;
				foreach ( $setting as $option ) {
					$csp_string .= " {$item}";
				}
			} else {
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
