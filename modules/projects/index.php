<?php
/**
 * Projects
 *
 * @package toolbelt
 */

/**
 * Setup Portfolio custom post type.
 */
class Toolbelt_Portfolio {

	const CUSTOM_POST_TYPE       = 'toolbelt-portfolio';
	const CUSTOM_TAXONOMY_TYPE   = 'toolbelt-portfolio-type';
	const CUSTOM_TAXONOMY_TAG    = 'toolbelt-portfolio-tag';

	function __construct() {

		$this->register_post_types();

		add_filter( sprintf( 'manage_%s_posts_columns', self::CUSTOM_POST_TYPE ), array( $this, 'edit_admin_columns' ) );
		add_filter( sprintf( 'manage_%s_posts_custom_column', self::CUSTOM_POST_TYPE ), array( $this, 'image_column' ), 10, 2 );

	}

	static function init() {

		static $instance = false;

		if ( ! $instance ) {
			$instance = new Toolbelt_Portfolio();
		}

		return $instance;

	}

	/**
	 * Register Post Type
	 */
	static function register_post_types() {

		if ( post_type_exists( self::CUSTOM_POST_TYPE ) ) {
			return;
		}

		register_post_type(
			self::CUSTOM_POST_TYPE,
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
					'publicize',
					'wpcom-markdown',
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
				'taxonomies'      => array( self::CUSTOM_TAXONOMY_TYPE, self::CUSTOM_TAXONOMY_TAG ),
				'has_archive'     => true,
				'query_var'       => 'portfolio',
				'show_in_rest'    => true,
			)
		);

		register_taxonomy(
			self::CUSTOM_TAXONOMY_TYPE,
			self::CUSTOM_POST_TYPE,
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

		register_taxonomy(
			self::CUSTOM_TAXONOMY_TAG,
			self::CUSTOM_POST_TYPE,
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
	 * Change ‘Title’ column label
	 * Add Featured Image column
	 */
	static function edit_admin_columns( $columns ) {

		// Change 'Title' to 'Project'.
		$columns['title'] = __( 'Project', 'toolbelt' );

		if ( current_theme_supports( 'post-thumbnails' ) ) {

			// Add featured image before 'Project'.
			$columns = array_slice( $columns, 0, 1, true ) + array( 'thumbnail' => '' ) + array_slice( $columns, 1, null, true );

		}

		return $columns;

	}

	/**
	 * Add featured image to column
	 */
	static function image_column( $column, $post_id ) {

		global $post;

		if ( 'thumbnail' === $column ) {
			echo get_the_post_thumbnail( $post_id, 'small' );
		}

	}

	/**
	 * Adjust image column width
	 */
	static function enqueue_admin_styles( $hook ) {

		$screen = get_current_screen();

		if ( 'edit.php' === $hook && self::CUSTOM_POST_TYPE === $screen->post_type && current_theme_supports( 'post-thumbnails' ) ) {
			wp_add_inline_style( 'wp-admin', '.manage-column.column-thumbnail { width: 50px; } @media screen and (max-width: 360px) { .column-thumbnail{ display:none; } }' );
		}

	}

}

add_action( 'init', array( 'Toolbelt_Portfolio', 'init' ) );
