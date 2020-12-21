<?php
/**
 * Search Results improvements.
 *
 * @package toolbelt
 */

/**
 * If there is only one search result then redirect the page to the resultant
 * page.
 *
 * @return void
 */
function toolbelt_search_single_result() {

	if ( is_search() ) {

		/**
		 * Use redirect array.
		 */
		$redirects = apply_filters( 'toolbelt_search_redirect', array() );

		if ( ! empty( $redirects ) ) {

			$search_query = trim( strtolower( get_search_query() ) );

			if ( $search_query ) {

				foreach ( $redirects as $r ) {

					if ( $search_query === $r['term'] ) {

						wp_safe_redirect( $r['url'] );
						exit;

					}

				}

			}

		}

		/**
		 * Use search results.
		 */
		global $wp_query;

		if ( 1 === $wp_query->post_count && 1 === $wp_query->max_num_pages ) {

			$permalink = get_permalink( $wp_query->posts[0]->ID );

			// Ensure there's actually somewhere to redirect to.
			if ( $permalink ) {
				wp_safe_redirect( $permalink );
				exit;
			}

		}

	}

}

add_action( 'template_redirect', 'toolbelt_search_single_result' );
