<?php
/**
 * Projects
 *
 * @package toolbelt
 */

/**
 * Define the taxonomy names.
 */
define( 'TB_CUSTOM_POST_TYPE', 'toolbelt-portfolio' );
define( 'TB_CUSTOM_TAXONOMY_TYPE', 'toolbelt-portfolio-type' );
define( 'TB_CUSTOM_TAXONOMY_TAG', 'toolbelt-portfolio-tag' );

/**
 * Register Portfolio post type and associated taxonomies.
 */
function tb_portfolio_register_post_types() {

	if ( post_type_exists( TB_CUSTOM_POST_TYPE ) ) {
		return;
	}

	// Portfolio post type.
	register_post_type(
		TB_CUSTOM_POST_TYPE,
		array(
			'labels' => array(
				'name'                  => esc_html__( 'Projects', 'toolbelt' ),
				'singular_name'         => esc_html__( 'Project', 'toolbelt' ),
				'menu_name'             => esc_html__( 'Portfolio', 'toolbelt' ),
				'all_items'             => esc_html__( 'All Projects', 'toolbelt' ),
				'add_new'               => esc_html__( 'Add New', 'toolbelt' ),
				'add_new_item'          => esc_html__( 'Add New Project', 'toolbelt' ),
				'edit_item'             => esc_html__( 'Edit Project', 'toolbelt' ),
				'new_item'              => esc_html__( 'New Project', 'toolbelt' ),
				'view_item'             => esc_html__( 'View Project', 'toolbelt' ),
				'search_items'          => esc_html__( 'Search Projects', 'toolbelt' ),
				'not_found'             => esc_html__( 'No Projects found', 'toolbelt' ),
				'not_found_in_trash'    => esc_html__( 'No Projects found in Trash', 'toolbelt' ),
				'filter_items_list'     => esc_html__( 'Filter projects list', 'toolbelt' ),
				'items_list_navigation' => esc_html__( 'Project list navigation', 'toolbelt' ),
				'items_list'            => esc_html__( 'Projects list', 'toolbelt' ),
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
			'taxonomies'      => array( TB_CUSTOM_TAXONOMY_TYPE, TB_CUSTOM_TAXONOMY_TAG ),
			'has_archive'     => true,
			'query_var'       => 'portfolio',
			'show_in_rest'    => true,
		)
	);

	// Portfolio project types (categories).
	register_taxonomy(
		TB_CUSTOM_TAXONOMY_TYPE,
		TB_CUSTOM_POST_TYPE,
		array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'                  => esc_html__( 'Project Types', 'toolbelt' ),
				'singular_name'         => esc_html__( 'Project Type', 'toolbelt' ),
				'menu_name'             => esc_html__( 'Project Types', 'toolbelt' ),
				'all_items'             => esc_html__( 'All Project Types', 'toolbelt' ),
				'edit_item'             => esc_html__( 'Edit Project Type', 'toolbelt' ),
				'view_item'             => esc_html__( 'View Project Type', 'toolbelt' ),
				'update_item'           => esc_html__( 'Update Project Type', 'toolbelt' ),
				'add_new_item'          => esc_html__( 'Add New Project Type', 'toolbelt' ),
				'new_item_name'         => esc_html__( 'New Project Type Name', 'toolbelt' ),
				'parent_item'           => esc_html__( 'Parent Project Type', 'toolbelt' ),
				'parent_item_colon'     => esc_html__( 'Parent Project Type:', 'toolbelt' ),
				'search_items'          => esc_html__( 'Search Project Types', 'toolbelt' ),
				'items_list_navigation' => esc_html__( 'Project type list navigation', 'toolbelt' ),
				'items_list'            => esc_html__( 'Project type list', 'toolbelt' ),
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
		TB_CUSTOM_TAXONOMY_TAG,
		TB_CUSTOM_POST_TYPE,
		array(
			'hierarchical'      => false,
			'labels'            => array(
				'name'                       => esc_html__( 'Project Tags', 'toolbelt' ),
				'singular_name'              => esc_html__( 'Project Tag', 'toolbelt' ),
				'menu_name'                  => esc_html__( 'Project Tags', 'toolbelt' ),
				'all_items'                  => esc_html__( 'All Project Tags', 'toolbelt' ),
				'edit_item'                  => esc_html__( 'Edit Project Tag', 'toolbelt' ),
				'view_item'                  => esc_html__( 'View Project Tag', 'toolbelt' ),
				'update_item'                => esc_html__( 'Update Project Tag', 'toolbelt' ),
				'add_new_item'               => esc_html__( 'Add New Project Tag', 'toolbelt' ),
				'new_item_name'              => esc_html__( 'New Project Tag Name', 'toolbelt' ),
				'search_items'               => esc_html__( 'Search Project Tags', 'toolbelt' ),
				'popular_items'              => esc_html__( 'Popular Project Tags', 'toolbelt' ),
				'separate_items_with_commas' => esc_html__( 'Separate tags with commas', 'toolbelt' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove tags', 'toolbelt' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used tags', 'toolbelt' ),
				'not_found'                  => esc_html__( 'No tags found.', 'toolbelt' ),
				'items_list_navigation'      => esc_html__( 'Project tag list navigation', 'toolbelt' ),
				'items_list'                 => esc_html__( 'Project tag list', 'toolbelt' ),
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

/**
 * Normally I'd hook these into an action but since this file is included in
 * the init action I'm calling it directly.
 */
tb_portfolio_register_post_types();



/**
 * Change ‘Title’ column label.
 * Add Featured Image column.
 *
 * @param array $columns A list of all the current columns.
 * @return array
 */
function tb_portfolio_edit_admin_columns( $columns ) {

	// Change 'Title' to 'Project'.
	$columns['title'] = esc_html__( 'Project', 'toolbelt' );

	if ( current_theme_supports( 'post-thumbnails' ) ) {

		// Add featured image before 'Project'.
		$columns = array_slice( $columns, 0, 1, true ) + array( 'thumbnail' => '' ) + array_slice( $columns, 1, null, true );

	}

	return $columns;

}

add_filter( sprintf( 'manage_%s_posts_columns', TB_CUSTOM_POST_TYPE ), 'tb_portfolio_edit_admin_columns' );


/**
 * Add featured image to column.
 *
 * @param string $column The name of the coloumn being checked.
 * @param int    $post_id The id of the post for the current row.
 */
function tb_portfolio_image_column( $column, $post_id ) {

	global $post;

	if ( 'thumbnail' === $column ) {
		echo get_the_post_thumbnail( $post_id, 'small' );
	}

}

add_filter( sprintf( 'manage_%s_posts_custom_column', TB_CUSTOM_POST_TYPE ), 'tb_portfolio_image_column', 10, 2 );


/**
 * Adjust image column width.
 *
 * @param string $hook The id for the current page.
 */
function tb_portfolio_enqueue_admin_styles( $hook ) {

	$screen = get_current_screen();

	if ( 'edit.php' === $hook && TB_CUSTOM_POST_TYPE === $screen->post_type && current_theme_supports( 'post-thumbnails' ) ) {
		wp_add_inline_style( 'wp-admin', '.manage-column.column-thumbnail { width: 50px; } @media screen and (max-width: 360px) { .column-thumbnail{ display:none; } }' );
	}

}

add_action( 'admin_enqueue_scripts', 'tb_portfolio_enqueue_admin_styles' );
