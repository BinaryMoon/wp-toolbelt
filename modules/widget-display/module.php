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

		if ( '!' === $token[0] ) {

			// If not then we want to invert the result.
			$token = ltrim( $token, '!' );
			$results[] = ! toolbelt_widget_display_check_token( $token );

		} else {

			$results[] = toolbelt_widget_display_check_token( $token );

		}
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
	/**
	 * Don't convert the properties to ints for 'posttype' key since we will
	 * have to compare with a string.
	 */
	if ( is_array( $properties ) && 'posttype' !== $key ) {
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
	 * Check for post types.
	 * Will work for single posts and archives.
	 * Requires an array of properties or it will be ignored.
	 */
	if ( 'posttype' === $key ) {

		$type = get_post_type();

		if ( is_array( $properties ) ) {

			// Include this post type.
			if ( in_array( $type, $properties, true ) ) {
				return true;
			}
		}

		return false;

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
	 * Show widget on posts or pages with the specified parent.
	 */
	if ( 'pagechild' === $key ) {

		if ( is_page() && is_array( $properties ) ) {

			foreach ( $properties as $parent ) {

				/**
				 * Display on any parent pages.
				 * No need to check anything else.
				 */
				if ( $test_id === $parent ) {
					return true;
				}

				/**
				 * Get the children for the current parent page.
				 */
				$children = toolbelt_widget_page_children( $parent );

				if ( in_array( $test_id, $children, true ) ) {
					return true;
				}
			}
		}

		return false;

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


/**
 * Get a posts children, and those posts children.
 *
 * This is a recursive function. It will keep calling itself until there are no
 * more children to load.
 *
 * Since each request makes a database call, this could be slow. In particular
 * on larger sites. I recommend using caching.
 *
 * @param int $parent The parent id.
 * @return array
 */
function toolbelt_widget_page_children( $parent ) {

	$children = array();

	// Grab the posts children.
	$posts = get_children( $parent );
	$posts = array_keys( $posts );

	// Now grab the grand children.
	foreach ( $posts as $child ) {

		// Recursion!! hurrah.
		$grand_children = toolbelt_widget_page_children( $child );

		// Merge the grand children into the children array.
		if ( ! empty( $grand_children ) ) {
			$children = array_merge( $children, $grand_children );
		}
	}

	// Merge in the direct descendants we found earlier.
	return array_merge( $children, $posts );

}
