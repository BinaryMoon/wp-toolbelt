<?php
/**
 * Star Rating
 *
 * @package toolbelt
 */



/**
 * Register a Portfolio block.
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
					'enum' => array( '', 'wide', 'full' ),
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
add_action( 'init', 'toolbelt_star_rating_register_block', 12 );
