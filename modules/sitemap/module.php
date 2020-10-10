<?php
/**
 * Simple Sitemap block.
 *
 * @package toolbelt
 */

/**
 * Register a Sitemap block.
 *
 * @return void
 */
function toolbelt_sitemap_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';

	wp_register_script(
		'toolbelt-sitemap',
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
		'toolbelt/sitemap',
		array(
			'editor_script' => 'toolbelt-sitemap',
			'render_callback' => 'toolbelt_sitemap_render',
			'attributes' => array(
				'posts' => array(
					'default' => true,
					'type' => 'boolean',
				),
				'pages' => array(
					'default' => true,
					'type' => 'boolean',
				),
				'categories' => array(
					'default' => true,
					'type' => 'boolean',
				),
			),
		)
	);

}

add_action( 'init', 'toolbelt_sitemap_register_block' );


/**
 * Render the sitemap.
 *
 * @param array<mixed> $attrs The block attributes.
 * @return string
 */
function toolbelt_sitemap_render( $attrs ) {

	$html = '';

	// Categories.
	if ( isset( $attrs['categories'] ) && $attrs['categories'] ) {

		$html .= sprintf(
			'<h2 class="toolbelt-heading">%1$s</h2><ul class="toolbelt-sitemap-categories">%2$s</ul>',
			esc_html__( 'Categories', 'wp-toolbelt' ),
			wp_list_categories(
				array(
					'title_li' => null,
					'hide_title_if_empty' => true,
					'echo' => false,
				)
			)
		);

	}

	// Pages.
	if ( isset( $attrs['pages'] ) && $attrs['pages'] ) {

		$html .= sprintf(
			'<h2 class="toolbelt-heading">%1$s</h2><ul class="toolbelt-sitemap-pages">%2$s</ul>',
			esc_html__( 'Pages', 'wp-toolbelt' ),
			wp_list_pages(
				array(
					'title_li' => null,
					'exclude' => get_option( 'page_on_front' ),
					'echo' => false,
					'item_spacing' => 'discard',
				)
			)
		);

	}

	// Posts.
	if ( isset( $attrs['posts'] ) && $attrs['posts'] ) {

		$html .= sprintf(
			'<h2 class="toolbelt-heading">%1$s</h2><ul class="toolbelt-sitemap-posts">%2$s</ul>',
			esc_html__( 'Posts', 'wp-toolbelt' ),
			toolbelt_sitemap_posts()
		);

	}

	return $html;

}


/**
 * Get a list of the public blog posts.
 *
 * @return string
 */
function toolbelt_sitemap_posts() {

	$query = new WP_Query(
		array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page'=> -1,
		)
	);

	$html = '';

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {

			$query->the_post();

			$html .= sprintf(
				'<li><a href="%2$s">%1$s</a></li>',
				esc_html( get_the_title() ),
				esc_url( get_the_permalink() )
			);

		}

	} else {

		$html .= '<p>' . esc_html_e( 'No posts.', 'wp-toolbelt' ) . '</p>';

	}

	wp_reset_postdata();

	return $html;

}

toolbelt_register_block_category();
