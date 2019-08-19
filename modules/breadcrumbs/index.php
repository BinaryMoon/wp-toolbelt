<?php
/**
 * Site Breadcrumbs.
 *
 * @package toolbelt
 */

/**
 * A function to display breadcrumbs on a category or single post/ page.
 * Should work for all post types.
 *
 * This module must be
 * a) enabled in the plugin settings
 * b) have the function below added to the theme. It won't work without this
 * function.
 */
function tb_breadcrumbs() {

	// Quit on the homepage.
	if ( is_front_page() ) {
		return;
	}

	$breadcrumb_type = tb_breadcrumb_type();

	// Quit if the content is a top level item.
	if ( ! $breadcrumb_type ) {
		return;
	}

	if ( 'post' === $breadcrumb_type[0] ) {
		$breadcrumb = tb_breadcrumb_post_hierarchical();
	}

	if ( 'taxonomy' === $breadcrumb_type[0] ) {
		$breadcrumb = tb_breadcrumb_tax_hierarchical( $breadcrumb_type[1] );
	}

	$home = sprintf(
		'<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="%1$s" class="home-link" itemprop="item" rel="home"><span itemprop="name">%2$s</span></a></span>',
		esc_url( home_url( '/' ) ),
		esc_html__( 'Home', 'wp-toolbelt' )
	);

	echo '<nav class="entry-breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">' . $home . $breadcrumb . '</nav>';

}


/**
 * Get the type of breadcrumb trail to generate.
 *
 * This works out if it's a post or taxonomy trail.
 *
 * @return false|array Item 0 = breadcrumb type (taxonomy or post), Item 1 = type of breadcrumb type. Eg, archive or tag.
 */
function tb_breadcrumb_type() {

	// Single post/ page breadcrumbs.
	$post_type = 'page';
	if ( ! is_page() ) {
		$post_type = get_query_var( 'post_type' );
	}

	if ( is_post_type_hierarchical( $post_type ) ) {
		return array(
			'post',
			$post_type,
		);
	}

	// Taxonomy archive.
	$taxonomy = 'category';
	if ( ! is_category() ) {
		$taxonomy = get_query_var( 'taxonomy' );
	}

	if ( is_taxonomy_hierarchical( $taxonomy ) ) {
		return array(
			'taxonomy',
			$taxonomy,
		);
	}

	// No idea, so let's quit.
	return false;

}


/**
 * Generate a hierarchical breadcrumb trail.
 *
 * @param string $taxonomy The taxonomy type for the archive.
 * @return string
 */
function tb_breadcrumb_tax_hierarchical( $taxonomy ) {

	$current = get_term( get_queried_object_id(), $taxonomy );
	$breadcrumb = '';

	if ( is_wp_error( $current ) ) {
		return;
	}

	if ( $current->parent ) {
		$breadcrumb = tb_get_term_parents( $current->parent, $taxonomy );
	}

	$breadcrumb .= sprintf(
		'<span class="current-category" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">%s</span></span>',
		esc_html( $current->name )
	);

	return $breadcrumb;

}


/**
 * Generate a post breadcrumb trail.
 *
 * By post I am referring to any single post type that supports a hierarchy.
 * This includes pages, and custom post types that can have a parent child
 * relationships.
 *
 * @return string
 */
function tb_breadcrumb_post_hierarchical() {

	$post_id = get_queried_object_id();
	$ancestors = array_reverse( get_post_ancestors( $post_id ) );
	$breadcrumb = '';

	if ( $ancestors ) {
		foreach ( $ancestors as $ancestor ) {
			$breadcrumb .= sprintf(
				'<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a></span>',
				esc_url( get_permalink( $ancestor ) ),
				esc_html( get_the_title( $ancestor ) )
			);
		}
	}

	$breadcrumb .= sprintf(
		'<span class="current-page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">%s</span></span>',
		esc_html( get_the_title( $post_id ) )
	);

	return $breadcrumb;

}


/**
 * Return the parents for a given taxonomy term ID.
 *
 * @param int    $term Taxonomy term whose parents will be returned.
 * @param string $taxonomy Taxonomy name that the term belongs to.
 * @param array  $visited Terms already added to prevent duplicates.
 *
 * @return string A list of links to the term parents.
 */
function tb_get_term_parents( $term, $taxonomy, $visited = array() ) {

	$parent = get_term( $term, $taxonomy );

	if ( is_wp_error( $parent ) ) {
		return $parent;
	}

	$chain = '';

	if ( $parent->parent && ( $parent->parent !== $parent->term_id ) && ! in_array( $parent->parent, $visited, true ) ) {
		$visited[] = $parent->parent;
		$chain .= jetpack_get_term_parents( $parent->parent, $taxonomy, $visited );
	}

	$chain .= sprintf(
		'<a href="%1$s">%2$s</a>',
		esc_url( get_category_link( $parent->term_id ) ),
		esc_html( $parent->name )
	);

	return $chain;

}
