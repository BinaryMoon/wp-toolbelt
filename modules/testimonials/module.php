<?php
/**
 * Testimonials
 *
 * @package toolbelt
 */

/**
 * Define the taxonomy name.
 *
 * Note that this is on the limit of post type name length.
 * Post type names should be between 1 and 20 characters. This is exactly 20
 * characters long.
 *
 * I wanted to use `toolbelt-testimonials` but it was 1 character too long and
 * stopped the entire thing from displaying. I learn something new every day!
 */
define( 'TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE', 'toolbelt-testimonial' );

/**
 * Register Portfolio post type and associated taxonomies.
 */
function toolbelt_testimonials_register_post_type() {

	// Quit if the Jetpack testimonial post type exists so we don't duplicate
	// functionality.
	if ( post_type_exists( 'jetpack-testimonial' ) ) {
		return;
	}

	if ( post_type_exists( TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE ) ) {
		return;
	}

	// Portfolio post type.
	register_post_type(
		TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE,
		array(
			'description' => esc_html__( 'Customer Testimonials', 'wp-toolbelt' ),
			'labels' => array(
				'name'                  => esc_html__( 'Testimonials', 'wp-toolbelt' ),
				'singular_name'         => esc_html__( 'Testimonial', 'wp-toolbelt' ),
				'menu_name'             => esc_html__( 'Testimonials', 'wp-toolbelt' ),
				'all_items'             => esc_html__( 'All Testimonials', 'wp-toolbelt' ),
				'add_new'               => esc_html__( 'Add New', 'wp-toolbelt' ),
				'add_new_item'          => esc_html__( 'Add New Testimonial', 'wp-toolbelt' ),
				'edit_item'             => esc_html__( 'Edit Testimonial', 'wp-toolbelt' ),
				'new_item'              => esc_html__( 'New Testimonial', 'wp-toolbelt' ),
				'view_item'             => esc_html__( 'View Testimonial', 'wp-toolbelt' ),
				'search_items'          => esc_html__( 'Search Testimonials', 'wp-toolbelt' ),
				'not_found'             => esc_html__( 'No Testimonials found', 'wp-toolbelt' ),
				'not_found_in_trash'    => esc_html__( 'No Testimonials found in Trash', 'wp-toolbelt' ),
				'filter_items_list'     => esc_html__( 'Filter Testimonials list', 'wp-toolbelt' ),
				'items_list_navigation' => esc_html__( 'Testimonial list navigation', 'wp-toolbelt' ),
				'items_list'            => esc_html__( 'Testimonials list', 'wp-toolbelt' ),
			),
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'page-attributes',
				'revisions',
				'excerpt',
			),
			'rewrite' => array(
				'slug'       => 'testimonial',
				'with_front' => false,
				'feeds'      => false,
				'pages'      => true,
			),
			'public'          => true,
			'show_ui'         => true,
			'menu_position'   => 20,
			'menu_icon'       => 'dashicons-testimonial',
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'has_archive'     => true,
			'query_var'       => 'testimonial',
			'show_in_rest'    => true,
		)
	);

}

add_action( 'init', 'toolbelt_testimonials_register_post_type', 11 );


/**
 * Add the testimonial post type to the related post types.
 *
 * @param array $types The current list of post types.
 * @return array
 */
function toolbelt_testimonials_social_sharing_post_types( $types ) {

	$types[] = TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE;
	return $types;

}

add_filter( 'toolbelt_social_sharing_post_types', 'toolbelt_testimonials_social_sharing_post_types', 5 );


/**
 * Change ‘Title’ column label.
 * Add Featured Image column.
 *
 * @param array $columns A list of all the current columns.
 * @return array
 */
function toolbelt_testimonials_edit_admin_columns( $columns ) {

	// Change 'Title' to 'Customer Name'.
	$columns['title'] = esc_html__( 'Customer Name', 'wp-toolbelt' );

	return $columns;

}

add_filter(
	sprintf( 'manage_%s_posts_columns', TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE ),
	'toolbelt_testimonials_edit_admin_columns'
);


/**
 * Change the post title text in the post editor to make it clear what the title
 * is used for.
 *
 * @param string $title The current post title.
 * @return string
 */
function toolbelt_testimonials_change_title( $title ) {

	if ( TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE === get_post_type() ) {

		$title = esc_html__( 'Enter the customer name here', 'wp-toolbelt' );

	}

	return $title;

}

add_filter( 'enter_title_here', 'toolbelt_testimonials_change_title' );
