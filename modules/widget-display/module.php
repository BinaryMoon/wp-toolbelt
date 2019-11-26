<?php
/**
 * Display Widgets conditionally.
 *
 * @package toolbelt
 */

if ( is_admin() ) {

	require 'module-admin.php';

} else {

	require 'module-frontend.php';

}


/**
 * Check if the widget should be displayed or not.
 *
 * @param string $logic Logic to check.
 * @return bool
 */
function toolbelt_widget_display( $logic ) {

	// Turn the logic properties into a list.
	$logic = trim( (string) $logic );

	// No logic rules to follow so quit.
	if ( empty( $logic ) ) {
		return true;
	}

	// Split the logic out into tokens that we can iterate over them.
	$logic = str_replace( ' ', '', $logic );
	$logic = strtolower( $logic );
	$logic_tokens = explode( ';', $logic );
	$results = array();

	foreach ( $logic_tokens as $token ) {
		$results[] = toolbelt_widget_display_check_token( $token );
	}

	/**
	 * If one result is true then display the widget, else hide it.
	 */
	if ( in_array( true, $results, true ) ) {
		return true;
	}

	/**
	 * Default to hiding the widget.
	 * Didn't match any tokens so return false, to hide the widget.
	 */
	return false;

}


/**
 * Check if the widget with the specified token should be visible.
 *
 * Returns true if the widget should be displayed, and false if it should be
 * hidden.
 *
 * @param string $token The token to check.
 * @return bool
 */
function toolbelt_widget_display_check_token( $token = '' ) {

	/**
	 * Key = the primary action.
	 * Properties = optional list of parameters that are related to the Key.
	 *
	 * Adds an extra : on the end of the token so that the $properties value
	 * does not create an error. If this means there's more than 2 properties
	 * the third will be ignored.
	 */
	list( $key, $properties ) = explode( ':', $token . ':' );
	if ( ! empty( $properties ) ) {
		$properties = explode( ',', $properties );
	}

	/**
	 * Set variables here to reduce code duplication.
	 */
	$test_id = (int) get_queried_object_id();
	if ( is_array( $properties ) ) {
		$properties = array_map( 'intval', $properties );
	}

	/**
	 * Check single posts.
	 * This uses is_singular(), so we're checking all post types including pages.
	 */
	if ( 'single' === $key ) {

		if ( is_singular() ) {

			if ( empty( $properties ) ) {
				return true;
			}

			if ( is_array( $properties ) ) {

				// Test for the id being included.
				if ( in_array( $test_id, $properties, true ) ) {
					return true;
				}
			}
		}

		return false;

	}

	/**
	 * Check is NOT single post type.
	 * This uses is_singular(), so we're checking all post types including pages.
	 */
	if ( '!single' === $key ) {

		if ( is_singular() ) {

			if ( empty( $properties ) ) {
				return false;
			}

			if ( is_array( $properties ) ) {

				if ( in_array( $test_id, $properties, true ) ) {
					return false;
				}
			}
		}

		/**
		 * It's not a singular post so let's show it.
		 */
		return true;

	}

	/**
	 * Check archives.
	 */
	if ( 'archive' === $key ) {

		if ( is_archive() ) {

			if ( empty( $properties ) ) {
				return true;
			}

			if ( is_array( $properties ) ) {

				// Test for the id being included.
				if ( in_array( $test_id, $properties, true ) ) {
					return true;
				}
			}
		}

		return false;

	}

	/**
	 * Check NOT archives.
	 */
	if ( '!archive' === $key ) {

		if ( is_archive() ) {

			if ( empty( $properties ) ) {
				return false;
			}

			if ( is_array( $properties ) ) {

				// Test for the id being included.
				if ( in_array( $test_id, $properties, true ) ) {
					return false;
				}
			}
		}

		return true;

	}

	/**
	 * Check homepage.
	 * Uses is_front_page() so only supports the actual homepage and not the
	 * blog page.
	 */
	if ( 'home' === $key ) {

		if ( is_front_page() ) {
			return true;
		}

		return false;

	}

	/**
	 * Check NOT homepage.
	 * Uses is_front_page() so only supports the actual homepage and not the
	 * blog page.
	 */
	if ( '!home' === $key ) {

		if ( is_front_page() ) {
			return false;
		}

		return true;

	}

	/**
	 * Check for post types.
	 * Will work for single posts and archives.
	 * Requires an array of properties or it will be ignored.
	 */
	if ( 'posttype' === $key && is_array( $properties ) ) {

		$type = get_post_type();

		// Include this post type.
		if ( in_array( $type, $properties, true ) ) {
			return true;
		}

		return false;

	}

	/**
	 * Check for post types.
	 * Will work for single posts and archives.
	 * Requires an array of properties or it will be ignored.
	 */
	if ( '!posttype' === $key && is_array( $properties ) ) {

		$type = get_post_type();

		// Include this post type.
		if ( in_array( $type, $properties, true ) ) {
			return false;
		}

		return true;

	}

	/**
	 * Check the post category.
	 * This includes post categories.
	 */
	if ( 'postcategory' === $key ) {

		if ( is_singular() && is_array( $properties ) && in_category( $properties ) ) {
			return true;
		}

		return false;

	}

	/**
	 * Check NOT the post category.
	 * This includes post categories.
	 */
	if ( '!postcategory' === $key ) {

		if ( is_singular() && is_array( $properties ) && in_category( $properties ) ) {
			return false;
		}

		return true;

	}

	/**
	 * Show on 404 page.
	 */
	if ( '404' === $key ) {

		if ( is_404() ) {
			return true;
		}

		return false;

	}

	/**
	 * Hide on 404 page.
	 */
	if ( '!404' === $key ) {

		if ( is_404() ) {
			return false;
		}

		return true;

	}

	/**
	 * Check the post taxonomy.
	 * This includes post categories, and tags, and whatever else there might
	 * be.
	 */
	if ( 'posttaxonomy' === $key ) {

		if ( is_singular() && is_array( $properties ) && count( $properties ) >= 1 ) {

			$taxonomy = (string) $properties[0];
			$terms = array_slice( $properties, 1 );

			if ( $test_id && has_term( $terms, $taxonomy, $post_id ) ) {
				return true;
			}
		}

		return false;

	}

	/**
	 * Check the post taxonomy.
	 * This includes post categories, and tags, and whatever else there might
	 * be.
	 */
	if ( '!posttaxonomy' === $key ) {

		if ( is_singular() && is_array( $properties ) && count( $properties ) >= 1 ) {

			$taxonomy = (string) $properties[0];
			$terms = array_slice( $properties, 1 );

			if ( $test_id && has_term( $terms, $taxonomy, $post_id ) ) {
				return false;
			}
		}

		return true;

	}

	return false;

}


/**
 * Get the widget logic property for the specified id.
 *
 * @param int $widget_id The id to get the information for.
 * @return string
 */
function toolbelt_widget_display_by_id( $widget_id ) {

	// Set the default values.
	$widget_base = $widget_id;
	$widget_number = null;

	// If the id is in the form 'string-##' (eg string-number).
	if ( preg_match( '/^(.+)-(\d+)$/', (string) $widget_id, $m ) ) {

		$widget_base = $m[1];
		$widget_number = $m[2];

	}

	// Load the option.
	$info = get_option( 'widget_' . $widget_base );

	/**
	 * If the number is the default then the option is stored in the old format
	 * so we need to grab the value in a different way.
	 */
	if ( null !== $widget_number ) {
		if ( ! empty( $info[ $widget_number ] ) ) {
			$info = $info[ $widget_number ];
		}
	}

	if ( isset( $info['toolbelt_widget_display'] ) ) {

		return $info['toolbelt_widget_display'];

	}

	return '';

}

