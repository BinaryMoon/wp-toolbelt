<?php
/**
 * Projects
 *
 * @package toolbelt
 */

/**
 * Define the taxonomy names.
 */
define( 'TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE', 'toolbelt-portfolio' );
define( 'TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TYPE', 'toolbelt-portfolio-type' );
define( 'TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TAG', 'toolbelt-portfolio-tag' );

/**
 * Register Portfolio post type and associated taxonomies.
 *
 * @return void
 */
function toolbelt_portfolio_register_post_types() {

	// Quit if the Jetpack portfolio post type exists so we don't duplicate
	// functionality.
	if ( post_type_exists( 'jetpack-portfolio' ) ) {
		return;
	}

	if ( post_type_exists( TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE ) ) {
		return;
	}

	// Portfolio post type.
	register_post_type(
		TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE,
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
			'taxonomies'      => array( TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TYPE, TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TAG ),
			'has_archive'     => true,
			'query_var'       => 'portfolio',
			'show_in_rest'    => true,
		)
	);

	// Portfolio project types (categories).
	register_taxonomy(
		TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TYPE,
		TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE,
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
		TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TAG,
		TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE,
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

add_action( 'init', 'toolbelt_portfolio_register_post_types', 11 );


/**
 * Add the portfolio post type to the related post types.
 *
 * @param array<string> $types The current list of post types.
 * @return array<string>
 */
function toolbelt_portfolio_related_posts_type( $types ) {

	$types[ TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE ] = TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TYPE;
	return $types;

}

add_filter( 'toolbelt_related_post_types', 'toolbelt_portfolio_related_posts_type' );


/**
 * Add the portfolio post type to the related post types.
 *
 * @param array<string> $types The current list of post types.
 * @return array<string>
 */
function toolbelt_portfolio_social_sharing_post_types( $types ) {

	$types[] = TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE;
	return $types;

}

add_filter( 'toolbelt_social_sharing_post_types', 'toolbelt_portfolio_social_sharing_post_types', 5 );


/**
 * Change ‘Title’ column label.
 * Add Featured Image column.
 *
 * @param array<string> $columns A list of all the current columns.
 * @return array<string>
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

add_filter(
	sprintf( 'manage_%s_posts_columns', TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE ),
	'toolbelt_portfolio_edit_admin_columns'
);


/**
 * Add featured image to column.
 *
 * @param string $column The name of the coloumn being checked.
 * @param int    $post_id The id of the post for the current row.
 * @return void
 */
function toolbelt_portfolio_image_column( $column, $post_id ) {

	global $post;

	if ( 'thumbnail' === $column ) {
		echo get_the_post_thumbnail( $post_id, 'small' );
	}

}

add_filter(
	sprintf( 'manage_%s_posts_custom_column', TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE ),
	'toolbelt_portfolio_image_column',
	10,
	2
);


/**
 * Adjust image column width.
 *
 * @param string $hook The id for the current page.
 * @return null
 */
function toolbelt_portfolio_enqueue_admin_styles( $hook ) {

	if ( 'edit.php' !== $hook ) {
		return;
	}

	if ( ! current_theme_supports( 'post-thumbnails' ) ) {
		return;
	}

	$screen = get_current_screen();

	if ( $screen instanceof WP_Screen && TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE === $screen->post_type ) {

		$styles = array(
			'.column-thumbnail { width: 50px; }',
			'.column-thumbnail img { max-width: 50px; height: auto; }',
			'@media screen and (max-width: 360px) { .column-thumbnail{ display:none; } }',
		);

		wp_add_inline_style( 'wp-admin', implode( $styles, ' ' ) );

	}

}

add_action( 'admin_enqueue_scripts', 'toolbelt_portfolio_enqueue_admin_styles' );


/**
 * Generate the portfolio shortcode.
 *
 * @param array<string|int> $attrs Shortcode attributes.
 * @return string
 */
function toolbelt_portfolio_shortcode( $attrs ) {

	$attrs = shortcode_atts(
		array(
			'columns' => '2',
			'rows' => '2',
			'orderby' => 'date',
			'categories' => array(),
			'align' => '',
			'showExcerpt' => true,
		),
		$attrs,
		'portfolio'
	);

	/**
	 * Restrict the number of columns to a number between 1 and 4.
	 *
	 * We have to do this to:
	 * a) ensure there are some columns.
	 * b) stop the columns from getting too narrow.
	 * c) ensure the custom css is setup for the number of columns chosen.
	 */
	$columns = (int) $attrs['columns'];
	if ( $columns < 1 ) {
		$columns = 1;
	}
	if ( $columns > 4 ) {
		$columns = 4;
	}

	/**
	 * Select the number of rows.
	 *
	 * Ensure there is at least 1 row selected.
	 */
	$rows = (int) $attrs['rows'];
	if ( $rows < 1 ) {
		$rows = 1;
	}

	/**
	 * Set the order_by parameter for the selection query.
	 *
	 * Allowed parameters are date and rand.
	 */
	$order_by = $attrs['orderby'];
	if ( ! in_array( $order_by, array( 'date', 'rand' ), true ) ) {
		$order_by = 'date';
	}

	/**
	 * Set block alignment.
	 */
	$align = '';
	if ( ! empty( $attrs['align'] ) ) {
		$align = 'align' . $attrs['align'];
	}

	/**
	 * Post categories.
	 */
	$categories = $attrs['categories'];
	if ( is_string( $categories ) && strlen( $categories ) > 1 ) {
		$categories = explode( ',', $categories );
	}

	/**
	 * Excerpt.
	 */
	$show_excerpt = (bool) $attrs['showExcerpt'];

	/**
	 * The number of portfolio to load.
	 *
	 * Rather than use a count attribute I'm calculating the number of
	 * portfolio so that the rows will (hopefully) always be full.
	 */
	$count = $columns * $rows;

	return sprintf(
		'<div class="wp-block-toolbelt-portfolio toolbelt-portfolio toolbelt-cols-%1$d %2$s">%3$s</div>',
		(int) $columns,
		esc_attr( $align ),
		toolbelt_portfolio_get_html( $count, $order_by, $categories, $show_excerpt )
	);

}


/**
 * Step aside for Jetpack (or other) portfolio shortcodes.
 */
if ( ! shortcode_exists( 'portfolio' ) ) {
	add_shortcode( 'portfolio', 'toolbelt_portfolio_shortcode' );
}


/**
 * Generate the html for the portfolios.
 *
 * @param int          $count The number of portfolios to try to load.
 * @param string       $order_by The order method.
 * @param array<mixed> $categories The categories to filter by.
 * @param bool         $show_excerpt Display or hide the excerpt.
 * @return string
 */
function toolbelt_portfolio_get_html( $count = 2, $order_by = 'date', $categories = array(), $show_excerpt = true ) {

	/**
	 * Make sure something is loaded.
	 */
	if ( (int) $count < 1 ) {
		$count = 1;
	}

	/**
	 * The html template for displaying a single testimonial.
	 */
	$html = '<div class="toolbelt-project">
	<a href="%2$s" class="thumbnail">%1$s</a>
	<h2 class="toolbelt-skip-anchor"><a href="%2$s">%3$s</a></h2>
	%4$s
	</div>';

	$properties = array(
		'post_type' => TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE,
		'posts_per_page' => (int) $count,
		'orderby' => $order_by,
	);

	if ( ! empty( $categories ) ) {
		$properties['tax_query'] = array(
			array(
				'taxonomy' => TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TYPE,
				'field' => 'term_id',
				'terms' => $categories,
			),
		);
	}

	$projects = new WP_Query( $properties );

	$projects_list = array();

	if ( $projects->have_posts() ) {
		while ( $projects->have_posts() ) {

			$projects->the_post();

			/**
			 * Must reset the excerpt no matter what.
			 * Otherwise we could end up displaying the wrong excerpt (from the
			 * previous project), or there could be an undefined variable error.
			 */
			$excerpt = '';
			if ( $show_excerpt ) {
				$excerpt = apply_filters( 'toolbelt_portfolio_excerpt', trim( get_the_excerpt() ) );
			}

			/**
			 * We add the div here instead of in the html template above since
			 * the excerpt could be hidden and we don't want an empty div on the
			 * page. That's just wrong.
			 */
			if ( ! empty( $excerpt ) ) {
				$excerpt = '<div class="toolbelt-entry">' . $excerpt . '</div>';
			}

			// Ensure there's a permalink.
			$permalink = get_permalink();
			if ( ! $permalink ) {
				$permalink = '';
			}

			/**
			 * Use null for `get_the_post_thumbnail` since this will use the
			 * global post object.
			 *
			 * 1. Thumbnail image.
			 * 2. Permalink.
			 * 3. Post title.
			 * 4. Excerpt.
			 */
			$projects_list[] = sprintf(
				$html,
				get_the_post_thumbnail( null, 'medium' ),
				esc_url( $permalink ),
				get_the_title(),
				$excerpt
			);

		}
	}

	wp_reset_postdata();

	return implode( '', $projects_list );

}


/**
 * Include the potfolio styles if the current post uses the portfolio shortcode.
 *
 * @return void
 */
function toolbelt_portfolio_styles() {

	global $post;

	if ( ! is_singular() ) {
		return;
	}

	if ( has_shortcode( $post->post_content, 'portfolio' ) || has_block( 'toolbelt/portfolio' ) ) {
		toolbelt_global_styles( 'columns' );
		toolbelt_styles( 'projects' );
	}

}

add_action( 'wp_print_styles', 'toolbelt_portfolio_styles' );


/**
 * Include the Portfolio styles in the editor.
 *
 * @return void
 */
function toolbelt_portfolio_editor_styles() {

	toolbelt_global_styles( 'columns' );
	toolbelt_styles( 'projects' );

}

add_action( 'admin_head', 'toolbelt_portfolio_editor_styles' );


/**
 * Register a Portfolio block.
 *
 * @return void
 */
function toolbelt_portfolio_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';
	$block_name = 'toolbelt-portfolio-block';

	wp_register_script(
		$block_name,
		plugins_url( 'block.min.js', __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-components',
		),
		'1.0',
		true
	);

	/**
	 * Only generate the classes in the admin. Technically we only need it on
	 * the post edit page.
	 */
	if ( is_admin() ) {

		wp_add_inline_script(
			$block_name,
			'var toolbelt_portfolio_categories = ' . toolbelt_portfolio_type_list() . ';',
			'before'
		);

	}

	register_block_type(
		'toolbelt/portfolio',
		array(
			'editor_script' => 'toolbelt-portfolio-block',
			'render_callback' => 'toolbelt_portfolio_shortcode',
			'attributes' => array(
				'rows' => array(
					'default' => 2,
					'type' => 'int',
				),
				'columns' => array(
					'default' => 2,
					'type' => 'int',
				),
				'orderby' => array(
					'default' => 'date',
					'enum' => array( 'date', 'rand' ),
					'type' => 'string',
				),
				'align' => array(
					'default' => '',
					'enum' => array( 'wide', 'full' ),
					'type' => 'string',
				),
				'categories' => array(
					'default' => array(),
					'type' => 'string',
				),
				'showExcerpt' => array(
					'default' => true,
					'type' => 'boolean',
				),
			),
		)
	);

}

/**
 * The post type is registered on init (priority 11) so this needs to be called
 * after since it tries to load the post taxonomies.
 */
add_action( 'init', 'toolbelt_portfolio_register_block', 12 );


/**
 * Get a list of portfolio categories.
 *
 * @return string JSON encoded list of post categories.
 */
function toolbelt_portfolio_type_list() {

	$terms = get_terms(
		array(
			'taxonomy' => TOOLBELT_PORTFOLIO_CUSTOM_TAXONOMY_TYPE,
			'post_type' => TOOLBELT_PORTFOLIO_CUSTOM_POST_TYPE,
			'hide_empty' => false,
		)
	);

	// Make sure the term exists and has some results.
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return 'null';
	}

	$categories = array();

	if ( is_array( $terms ) ) {

		foreach ( $terms as $term ) {

			$categories[] = array(
				'id' => $term->term_id,
				'name' => $term->name,
			);

		}
	}

	// Ensure the json is a string.
	$json = wp_json_encode( $categories );
	if ( ! $json ) {
		$json = '';
	}

	return $json;

}

toolbelt_register_block_category();

