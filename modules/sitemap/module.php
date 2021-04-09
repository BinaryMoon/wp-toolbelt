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
				'portfolio' => array(
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

		$categories = wp_list_categories(
			array(
				'title_li' => null,
				'hide_title_if_empty' => true,
				'echo' => false,
			)
		);

		if ( is_string( $categories ) ) {

			$html .= sprintf(
				'<h2 class="toolbelt-heading toolbelt-heading__sitemap">%1$s</h2><ul class="toolbelt-sitemap-categories">%2$s</ul>',
				esc_html__( 'Categories', 'wp-toolbelt' ),
				$categories
			);

		}

	}

	// Pages.
	if ( isset( $attrs['pages'] ) && $attrs['pages'] ) {

		$pages = wp_list_pages(
			array(
				'title_li' => null,
				'exclude' => get_option( 'page_on_front' ),
				'echo' => false,
				'item_spacing' => 'discard',
			)
		);

		if ( is_string( $pages ) ) {

			$html .= sprintf(
				'<h2 class="toolbelt-heading toolbelt-heading__sitemap">%1$s</h2><ul class="toolbelt-sitemap-pages">%2$s</ul>',
				esc_html__( 'Pages', 'wp-toolbelt' ),
				$pages
			);

		}

	}

	// Posts.
	if ( isset( $attrs['posts'] ) && $attrs['posts'] ) {

		$posts = toolbelt_sitemap_posts();

		if ( is_string( $posts ) ) {

			$html .= sprintf(
				'<h2 class="toolbelt-heading toolbelt-heading__sitemap">%1$s</h2>%2$s',
				esc_html__( 'Posts', 'wp-toolbelt' ),
				$posts
			);

		}

	}

	// Portfolio.
	if ( isset( $attrs['portfolio'] ) && $attrs['portfolio'] ) {

		$projects = toolbelt_sitemap_portfolio();

		if ( is_string( $projects ) ) {

			$html .= sprintf(
				'<h2 class="toolbelt-heading toolbelt-heading__sitemap">%1$s</h2>%2$s',
				esc_html__( 'Portfolio', 'wp-toolbelt' ),
				$projects
			);

		}

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
			'posts_per_page' => -1,
		)
	);

	$html = '';
	$prev_year = null;
	$this_year = null;

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {

			$query->the_post();

			$this_year = get_the_date( 'Y' );
			$post_title = get_the_title();
			$post_url = get_the_permalink();

			if ( $prev_year !== $this_year ) {

				// Year boundary.
				if ( ! is_null( $prev_year ) ) {
					// A list is already open, close it first.
					$html .= '</ul>';
				}

				$html .= sprintf(
					'<h3 class="toolbelt-heading toolbelt-heading__sitemap-year">%1$d</h3><ul>',
					$this_year
				);

			}

			if ( $post_title && $post_url ) {

				$html .= sprintf(
					'<li><a href="%2$s">%1$s</a></li>',
					esc_html( $post_title ),
					esc_url( $post_url )
				);

			}

			$prev_year = $this_year;

		}

		$html .= '</ul>';

	}

	wp_reset_postdata();

	return $html;

}


/**
 * Get a list of the public portfolio projects.
 *
 * @return string
 */
function toolbelt_sitemap_portfolio() {

	$query = new WP_Query(
		array(
			'post_type' => 'toolbelt-portfolio',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		)
	);

	$html = '';

	if ( $query->have_posts() ) {

		$html = '<ul>';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_title = get_the_title();
			$post_url = get_the_permalink();

			if ( $post_title && $post_url ) {

				$html .= sprintf(
					'<li><a href="%2$s">%1$s</a></li>',
					esc_html( $post_title ),
					esc_url( $post_url )
				);

			}

		}

		$html .= '</ul>';

	}

	wp_reset_postdata();

	return $html;

}

toolbelt_register_block_category();
