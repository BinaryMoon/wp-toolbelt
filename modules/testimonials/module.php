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


/**
 * Generate the testimonials shortcode.
 *
 * @param array $attrs Shortcode attributes.
 * @return string
 */
function toolbelt_testimonials_shortcode( $attrs ) {

	$attrs = shortcode_atts(
		array(
			'columns' => '2',
			'rows' => '2',
			'orderby' => 'date',
			'align' => '',
		),
		$attrs,
		'testimonials'
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

	$align = '';
	if ( ! empty( $attrs['align'] ) ) {
		$align = 'align' . $attrs['align'];
	}

	/**
	 * The number of testimonials to load.
	 *
	 * Rather than use a count attribute I'm calculating the number of
	 * testimonials so that the rows will (hopefully) always be full.
	 */
	$count = $columns * $rows;

	return sprintf(
		'<div class="toolbelt-testimonials toolbelt-cols-%1$d %2$s">%3$s</div>',
		(int) $columns,
		esc_attr( $align ),
		toolbelt_testimonials_get_html( $count, $order_by )
	);

}


/**
 * Step aside for Jetpack (or other) Testimonials shortcodes.
 */
if ( ! shortcode_exists( 'testimonials' ) ) {
	add_shortcode( 'testimonials', 'toolbelt_testimonials_shortcode' );
}


/**
 * Generate the html for the testimonials.
 *
 * @param int    $count The number of testimonials to try to load.
 * @param string $order_by The order method.
 * @return string
 */
function toolbelt_testimonials_get_html( $count = 2, $order_by = 'date' ) {

	/**
	 * Make sure something is loaded.
	 */
	if ( $count < 1 ) {
		$count = 2;
	}

	/**
	 * The html template for displaying a single testimonial.
	 */
	$html = '<div class="toolbelt-testimonial">
	<div class="toolbelt-entry">%1$s</div>
	<footer>
		<span class="avatar">%2$s</span>
		<span class="author">%3$s</span>
	</footer>
	</div>';

	$testimonials = new WP_Query(
		array(
			'post_type' => TOOLBELT_TESTIMONIALS_CUSTOM_POST_TYPE,
			'posts_per_page' => (int) $count,
			'orderby' => $order_by,
		)
	);

	$testimonials_list = array();

	if ( $testimonials->have_posts() ) {
		while ( $testimonials->have_posts() ) {

			$testimonials->the_post();

			$content = apply_filters( 'toolbelt_testimonial_content', trim( get_the_content() ) );

			/**
			 * Use null for `get_the_post_thumbnail` since this will use the
			 * global post object.
			 */
			$testimonials_list[] = sprintf(
				$html,
				$content,
				get_the_post_thumbnail( null, 'thumbnail' ),
				get_the_title()
			);

		}
	}

	wp_reset_postdata();

	return implode( '', $testimonials_list );

}

add_filter( 'toolbelt_testimonial_content', 'wptexturize' );
add_filter( 'toolbelt_testimonial_content', 'convert_chars' );
add_filter( 'toolbelt_testimonial_content', 'wpautop' );
add_filter( 'toolbelt_testimonial_content', 'shortcode_unautop' );


/**
 * Include the Testimonials styles if the current post uses the testimonials
 * shortcode.
 */
function toolbelt_testimonials_styles() {

	global $post;

	if ( is_singular() && has_shortcode( $post->post_content, 'testimonials' ) ) {
		toolbelt_global_styles( 'columns' );
		toolbelt_styles( 'testimonials' );
	}

}

add_action( 'wp_print_styles', 'toolbelt_testimonials_styles' );


/**
 * Include the Testimonials styles if the current post uses the testimonials
 * shortcode.
 */
function toolbelt_testimonials_editor_styles() {

	toolbelt_global_styles( 'columns' );
	toolbelt_styles( 'testimonials' );

}

add_action( 'enqueue_block_editor_assets', 'toolbelt_testimonials_editor_styles' );


/**
 * Register a Testimonials block.
 */
function toolbelt_testimonials_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';

	wp_register_script(
		'toolbelt-testimonials-block',
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

	register_block_type(
		'toolbelt/testimonials',
		array(
			'editor_script' => 'toolbelt-testimonials-block',
			'render_callback' => 'toolbelt_testimonials_shortcode',
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
					'type' => 'string',
				),
				'align' => array(
					'default' => '',
					'type' => 'string',
				),
			),
		)
	);

}

add_action( 'init', 'toolbelt_testimonials_register_block' );

