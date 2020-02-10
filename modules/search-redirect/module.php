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
