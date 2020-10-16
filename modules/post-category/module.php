<?php
/**
 * A post category summary block.
 *
 * @package toolbelt
 */

/**
 * Register a the block.
 *
 * @return void
 */
function toolbelt_post_category_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_name = 'toolbelt-post-category';
	$block_js = dirname( __FILE__ ) . '/block.min.js';

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
	 * Only generate the categories in the admin. Technically we only need it on
	 * the post edit page.
	 */
	if ( is_admin() ) {

		wp_add_inline_script(
			$block_name,
			'var toolbelt_post_categories = ' . toolbelt_post_categories_list() . ';',
			'before'
		);

	}

	register_block_type(
		'toolbelt/post-category',
		array(
			'editor_script' => $block_name,
			'render_callback' => 'toolbelt_post_category_render',
			'attributes' => array(
				'category' => array(
					'default' => '',
					'type' => 'string',
				),
				'count' => array(
					'default' => 10,
					'type' => 'int',
				),
				'layout' => array(
					'default' => '1',
					'type' => 'string',
				),
				'layout_first' => array(
					'default' => '1',
					'type' => 'string',
				),
			),
		)
	);

}

add_action( 'init', 'toolbelt_post_category_register_block' );


/**
 * Render the block.
 *
 * @param array<mixed> $attrs The block attributes.
 * @return string
 */
function toolbelt_post_category_render( $attrs ) {

	toolbelt_styles( 'post-category' );

	// Load the posts as an array so that we can output them in different ways.
	$posts = toolbelt_post_category_get_posts( $attrs['category'], $attrs['count'] );

	if ( empty( $posts ) ) {
		return '';
	}

	$html = '';

	// Add heading.
	$html .= toolbelt_post_category_heading( $attrs['category'] );

	// Add intro post if applicable.
	if ( '1' !== $attrs['layout_first'] ) {
		$first_post = array_shift( $posts );
		$html .= toolbelt_post_category_layout_list( array( $first_post ), $attrs['layout_first'] );
	}

	// Add all the others.
	$html .= toolbelt_post_category_layout_list( $posts, $attrs['layout'] );

	return '<section>' . $html . '</section>';

}


/**
 * Generate the html for the specified posts.
 *
 * @param array<mixed> $posts List of post data to use.
 * @param string       $layout The layout id.
 * @return string
 */
function toolbelt_post_category_layout_list( $posts, $layout = '1' ) {

	$class = sprintf(
		'toolbelt-post-category-layout-%1$d',
		$layout
	);

	$html = '';

	switch ( $layout ) {

		// Large image.
		case '2':

			foreach ( $posts as $p ) {

				$html .= sprintf(
					'<article class="%1$s">%2$s<h3 class="has-normal-font-size"><a href="%3$s" rel="bookmark">%4$s</a></h3>%5$s<p>%6$s</p></article>',
					esc_attr( $class ),
					get_the_post_thumbnail( $p['id'], 'medium' ),
					esc_url( $p['url'] ),
					esc_html( $p['title'] ),
					toolbelt_post_category_post_meta( $p ),
					$p['excerpt']
				);

			}

			break;

		// Small image floated left.
		case '3':

			foreach ( $posts as $p ) {

				$html .= sprintf(
					'<article class="%1$s">%2$s<h3 class="has-normal-font-size"><a href="%3$s" rel="bookmark">%4$s</a></h3>%5$s<p>%6$s</p></article>',
					esc_attr( $class ),
					get_the_post_thumbnail( $p['id'], 'thumbnail' ),
					esc_url( $p['url'] ),
					esc_html( $p['title'] ),
					toolbelt_post_category_post_meta( $p ),
					$p['excerpt']
				);

			}

			break;

		// Title and excerpt.
		case '4':

			foreach ( $posts as $p ) {

				$html .= sprintf(
					'<article class="%1$s"><h3 class="has-normal-font-size"><a href="%2$s" rel="bookmark">%3$s</a></h3>%4$s<p>%5$s</p></article>',
					esc_attr( $class ),
					esc_url( $p['url'] ),
					esc_html( $p['title'] ),
					toolbelt_post_category_post_meta( $p ),
					$p['excerpt']
				);

			}

			break;

		// Default, also option 1.
		default:

			$html = '<ul>';

			foreach ( $posts as $p ) {

				$html .= sprintf(
					'<li><h3 class="has-normal-font-size"><a href="%1$s" rel="bookmark">%2$s</a></h3></li>',
					esc_url( $p['url'] ),
					esc_html( $p['title'] )
				);

			}

			$html .= '</ul>';

			break;

	}

	return $html;

}


/**
 * Generate post meta data (author and date) for the specified post.
 *
 * @param array<mixed> $post The post data.
 * @return string
 */
function toolbelt_post_category_post_meta( $post ) {

	// Author.
	$author = sprintf(
		'<span class="byline meta author v-card"><a class="url fn n p-name u-url" href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( $post['author_id'] ) ),
		esc_html( $post['author'] )
	);

	// Post date.
	$time_string = sprintf(
		'<time class="entry__date published updated dt-published" datetime="%1$s">%2$s</time>',
		esc_attr( (string) get_the_date( 'c', $post['id'] ) ),
		esc_attr( (string) get_the_date( '', $post['id'] ) )
	);

	$posted_on = '<a href="' . esc_url( (string) get_permalink() ) . '" class="u-url" rel="bookmark">' . $time_string . '</a>';

	/**
	 * $posted_on is not escaped because all of the html that makes up the
	 * string is escaped. The code is directly above this comment.
	 */
	$date = sprintf(
		'<span class="posted-on meta"><a href="%1$s" class="u-url" rel="bookmark">%2$s</a></span>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_url( (string) get_permalink() ),
		$time_string
	);

	return sprintf(
		'<p class="toolbelt-post-meta has-small-font-size">%1$s %2$s</p>',
		$author,
		$date
	);

}


/**
 * Get a list of the public portfolio projects.
 *
 * @param int $category_id The id to display.
 * @param int $count The number of posts to display.
 * @return array<mixed>
 */
function toolbelt_post_category_get_posts( $category_id, $count = 10 ) {

	$category_id = (int) $category_id;
	$posts = array();

	$count = (int) $count;
	$count = min( 19, $count );
	$count = max( 3, $count );

	$query = new WP_Query(
		array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => true,
			'cat' => $category_id,
		)
	);

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {

			$query->the_post();
			$posts[] = array(
				'id' => get_the_ID(),
				'url' => get_the_permalink(),
				'title' => get_the_title(),
				'excerpt' => get_the_excerpt(),
				'author' => get_the_author(),
				'author_id' => (int) get_the_author_meta( 'ID' ),
			);

		}

	}

	wp_reset_postdata();

	return $posts;

}


/**
 * Generate the HTML for the category heading.
 *
 * @param int $category_id The category id.
 * @return string
 */
function toolbelt_post_category_heading( $category_id ) {

	$html = '';

	$category_id = (int) $category_id;

	if ( $category_id <= 0 ) {
		return $html;
	}

	$category = get_term( $category_id );

	if ( is_wp_error( $category ) ) {
		return $html;
	}

	$html .= sprintf(
		'<h2 class="toolbelt-heading toolbelt-heading-post-category-h2 has-normal-font-size"><a href="%1$s">%2$s</a></h2>',
		esc_url( get_category_link( $category->term_id ) ),
		esc_html( $category->name )
	);

	return $html;

}


/**
 * Get a list of portfolio categories.
 *
 * @return string JSON encoded list of post categories.
 */
function toolbelt_post_categories_list() {

	$terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => true,
		)
	);

	// Make sure the term exists and has some results.
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return 'null';
	}

	$categories = array();

	$categories[] = array(
		'value' => '-1',
		'label' => esc_html__( 'All Categories', 'wp-toolbelt' )
	);

	if ( is_array( $terms ) ) {

		foreach ( $terms as $term ) {

			$categories[] = array(
				'value' => $term->term_id,
				'label' => $term->name,
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
