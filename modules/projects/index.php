<?php
/**
 * Projects
 *
 * @package toolbelt
 */

/**
 * Define the taxonomy names.
 */
define( 'TOOLBELT_CUSTOM_POST_TYPE', 'toolbelt-portfolio' );
define( 'TOOLBELT_CUSTOM_TAXONOMY_TYPE', 'toolbelt-portfolio-type' );
define( 'TOOLBELT_CUSTOM_TAXONOMY_TAG', 'toolbelt-portfolio-tag' );

/**
 * Register Portfolio post type and associated taxonomies.
 */
function toolbelt_portfolio_register_post_types() {

	if ( post_type_exists( TOOLBELT_CUSTOM_POST_TYPE ) ) {
		return;
	}

	// Portfolio post type.
	register_post_type(
		TOOLBELT_CUSTOM_POST_TYPE,
		array(
			'labels' => array(
				'name'                  => esc_html__( 'Projects', 'wp-toolbelt' ),
				'singular_name'         => esc_html__( 'Project', 'wp-toolbelt' ),
				'menu_name'             => esc_html__( 'Portfolio', 'wp-toolbelt' ),
				'all_items'             => esc_html__( 'All Projects', 'wp-toolbelt' ),
				'add_new'               => esc_html__( 'Add New', 'wp-toolbelt' ),
				'add_new_item'          => esc_html__( 'Add New Project', 'wp-toolbelt' ),
				'edit_item'             => esc_html__( 'Edit Project', 'wp-toolbelt' ),
				'new_item'              => esc_html__( 'New Project', 'wp-toolbelt' ),
				'view_item'             => esc_html__( 'View Project', 'wp-toolbelt' ),
				'search_items'          => esc_html__( 'Search Projects', 'wp-toolbelt' ),
				'not_found'             => esc_html__( 'No Projects found', 'wp-toolbelt' ),
				'not_found_in_trash'    => esc_html__( 'No Projects found in Trash', 'wp-toolbelt' ),
				'filter_items_list'     => esc_html__( 'Filter projects list', 'wp-toolbelt' ),
				'items_list_navigation' => esc_html__( 'Project list navigation', 'wp-toolbelt' ),
				'items_list'            => esc_html__( 'Projects list', 'wp-toolbelt' ),
			),
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'author',
				'comments',
				'revisions',
				'excerpt',
			),
			'rewrite' => array(
				'slug'       => 'portfolio',
				'with_front' => false,
				'feeds'      => true,
				'pages'      => true,
			),
			'public'          => true,
			'show_ui'         => true,
			'menu_position'   => 20,                    // Below 'Pages'.
			'menu_icon'       => 'dashicons-portfolio', // 3.8+ dashicon option.
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'taxonomies'      => array( TOOLBELT_CUSTOM_TAXONOMY_TYPE, TOOLBELT_CUSTOM_TAXONOMY_TAG ),
			'has_archive'     => true,
			'query_var'       => 'portfolio',
			'show_in_rest'    => true,
		)
	);

	// Portfolio project types (categories).
	register_taxonomy(
		TOOLBELT_CUSTOM_TAXONOMY_TYPE,
		TOOLBELT_CUSTOM_POST_TYPE,
		array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'                  => esc_html__( 'Project Types', 'wp-toolbelt' ),
				'singular_name'         => esc_html__( 'Project Type', 'wp-toolbelt' ),
				'menu_name'             => esc_html__( 'Project Types', 'wp-toolbelt' ),
				'all_items'             => esc_html__( 'All Project Types', 'wp-toolbelt' ),
				'edit_item'             => esc_html__( 'Edit Project Type', 'wp-toolbelt' ),
				'view_item'             => esc_html__( 'View Project Type', 'wp-toolbelt' ),
				'update_item'           => esc_html__( 'Update Project Type', 'wp-toolbelt' ),
				'add_new_item'          => esc_html__( 'Add New Project Type', 'wp-toolbelt' ),
				'new_item_name'         => esc_html__( 'New Project Type Name', 'wp-toolbelt' ),
				'parent_item'           => esc_html__( 'Parent Project Type', 'wp-toolbelt' ),
				'parent_item_colon'     => esc_html__( 'Parent Project Type:', 'wp-toolbelt' ),
				'search_items'          => esc_html__( 'Search Project Types', 'wp-toolbelt' ),
				'items_list_navigation' => esc_html__( 'Project type list navigation', 'wp-toolbelt' ),
				'items_list'            => esc_html__( 'Project type list', 'wp-toolbelt' ),
			),
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'project-type' ),
		)
	);

	// Portfolio tags.
	register_taxonomy(
		TOOLBELT_CUSTOM_TAXONOMY_TAG,
		TOOLBELT_CUSTOM_POST_TYPE,
		array(
			'hierarchical'      => false,
			'labels'            => array(
				'name'                       => esc_html__( 'Project Tags', 'wp-toolbelt' ),
				'singular_name'              => esc_html__( 'Project Tag', 'wp-toolbelt' ),
				'menu_name'                  => esc_html__( 'Project Tags', 'wp-toolbelt' ),
				'all_items'                  => esc_html__( 'All Project Tags', 'wp-toolbelt' ),
				'edit_item'                  => esc_html__( 'Edit Project Tag', 'wp-toolbelt' ),
				'view_item'                  => esc_html__( 'View Project Tag', 'wp-toolbelt' ),
				'update_item'                => esc_html__( 'Update Project Tag', 'wp-toolbelt' ),
				'add_new_item'               => esc_html__( 'Add New Project Tag', 'wp-toolbelt' ),
				'new_item_name'              => esc_html__( 'New Project Tag Name', 'wp-toolbelt' ),
				'search_items'               => esc_html__( 'Search Project Tags', 'wp-toolbelt' ),
				'popular_items'              => esc_html__( 'Popular Project Tags', 'wp-toolbelt' ),
				'separate_items_with_commas' => esc_html__( 'Separate tags with commas', 'wp-toolbelt' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove tags', 'wp-toolbelt' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used tags', 'wp-toolbelt' ),
				'not_found'                  => esc_html__( 'No tags found.', 'wp-toolbelt' ),
				'items_list_navigation'      => esc_html__( 'Project tag list navigation', 'wp-toolbelt' ),
				'items_list'                 => esc_html__( 'Project tag list', 'wp-toolbelt' ),
			),
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'project-tag' ),
		)
	);

}

add_action( 'init', 'toolbelt_portfolio_register_post_types' );



/**
 * Change ‘Title’ column label.
 * Add Featured Image column.
 *
 * @param array $columns A list of all the current columns.
 * @return array
 */
function toolbelt_portfolio_edit_admin_columns( $columns ) {

	// Change 'Title' to 'Project'.
	$columns['title'] = esc_html__( 'Project', 'wp-toolbelt' );

	if ( current_theme_supports( 'post-thumbnails' ) ) {

		// Add featured image before 'Project'.
		$columns = array_slice( $columns, 0, 1, true ) + array( 'thumbnail' => '' ) + array_slice( $columns, 1, null, true );

	}

	return $columns;

}

add_filter( sprintf( 'manage_%s_posts_columns', TOOLBELT_CUSTOM_POST_TYPE ), 'toolbelt_portfolio_edit_admin_columns' );


/**
 * Add featured image to column.
 *
 * @param string $column The name of the coloumn being checked.
 * @param int    $post_id The id of the post for the current row.
 */
function toolbelt_portfolio_image_column( $column, $post_id ) {

	global $post;

	if ( 'thumbnail' === $column ) {
		echo get_the_post_thumbnail( $post_id, 'small' );
	}

}

add_filter( sprintf( 'manage_%s_posts_custom_column', TOOLBELT_CUSTOM_POST_TYPE ), 'toolbelt_portfolio_image_column', 10, 2 );


/**
 * Adjust image column width.
 *
 * @param string $hook The id for the current page.
 */
function toolbelt_portfolio_enqueue_admin_styles( $hook ) {

	$screen = get_current_screen();

	if ( 'edit.php' === $hook && TOOLBELT_CUSTOM_POST_TYPE === $screen->post_type && current_theme_supports( 'post-thumbnails' ) ) {
		wp_add_inline_style( 'wp-admin', '.manage-column.column-thumbnail { width: 50px; } @media screen and (max-width: 360px) { .column-thumbnail{ display:none; } }' );
	}

}

add_action( 'admin_enqueue_scripts', 'toolbelt_portfolio_enqueue_admin_styles' );
