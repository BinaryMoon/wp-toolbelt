<?php
/**
 * Star Rating
 *
 * @package toolbelt
 */

/**
 * Register a Star Rating block.
 *
 * @return void
 */
function toolbelt_star_rating_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';
	$block_name = 'toolbelt-star-rating';

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

	register_block_type(
		'toolbelt/star-rating',
		array(
			'render_callback' => 'toolbelt_star_rating_render_block',
			'editor_script' => 'toolbelt-star-rating',
			'attributes' => array(
				'rating'      => array(
					'type'    => 'number',
					'default' => 1,
				),
				'maxRating'   => array(
					'type'    => 'number',
					'default' => 5,
				),
				'color'       => array(
					'type' => 'string',
				),
				'ratingStyle' => array(
					'type'    => 'string',
					'default' => 'star',
				),
				'className'   => array(
					'type' => 'string',
				),
				'align'       => array(
					'type'    => 'string',
					'default' => 'left',
				),
			),
		)
	);

}

/**
 * The post type is registered on init (priority 11) so this needs to be called
 * after since it tries to load the post taxonomies.
 */
add_action( 'init', 'toolbelt_star_rating_register_block', 12 );


/**
 * Include the Star Rating form editor styles.
 *
 * @return void
 */
function toolbelt_star_rating_editor_styles() {

	toolbelt_styles_editor( 'star-rating' );

}

add_action( 'admin_head', 'toolbelt_star_rating_editor_styles' );


/**
 * Include the star rating styles if the current post uses the star rating block.
 *
 * @return void
 */
function toolbelt_star_rating_styles() {

	global $post;

	if ( ! is_singular() ) {
		return;
	}

	if ( has_block( 'toolbelt/star-rating' ) ) {
		toolbelt_styles( 'star-rating' );
	}

}

add_action( 'wp_print_styles', 'toolbelt_star_rating_styles' );


/**
 * Include the ratings renderer on the frontend only.
 * On the backend we use JS to render the stars.
 */
if ( ! is_admin() ) {
	require 'module-render.php';
}

