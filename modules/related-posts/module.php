<?php
/**
 * Related Posts
 *
 * @package toolbelt
 */

/**
 * A unique string to use for the transient.
 * Cache gets invalidated when a new version of Toolbelt is published.
 * %d = the post id.
 */
define( 'TOOLBELT_RELATED_POST_TRANSIENT', 'toolbelt_related_post_' . TOOLBELT_VERSION . '_%d' );


/**
 * Add related posts to the end of the_content.
 *
 * @param string $content The post content that we will be appending.
 * @return string
 */
function toolbelt_related_posts( $content ) {

	// The content has a related posts block so no need to add this as well.
	if ( has_block( 'toolbelt/related-posts' ) ) {
		return $content;
	}

	/**
	 * An option to disable the automatic output of the related posts.
	 *
	 * Included directly since this file is included on the init hook.
	 *
	 * If you disable the related posts output you can still echo the
	 * toolbelt_related_posts_get() function directly within your theme.
	 */
	if ( ! apply_filters( 'toolbelt_related_posts', true ) ) {
		return $content;
	}

	if ( ! is_singular() ) {
		return $content;
	}

	if ( doing_filter( 'get_the_excerpt' ) ) {
		return $content;
	}

	return $content . toolbelt_related_posts_get();

}

add_filter( 'the_content', 'toolbelt_related_posts' );


/**
 * Get the related posts content.
 * With html formatting.
 *
 * @return string
 */
function toolbelt_related_posts_get() {

	/**
	 * If a password is required then don't display anything.
	 *
	 * This is added here, rather than in `toolbelt_related_posts` so that the
	 * function takes effect for people who call the function directly.
	 */
	if ( post_password_required() ) {
		return '';
	}

	$available_post_types = apply_filters(
		'toolbelt_related_post_types',
		array( 'post' => 'category' )
	);

	if ( ! $available_post_types ) {
		return '';
	}

	$current_post_type = get_post_type();

	// The post is not in the available post types.
	if ( ! in_array( $current_post_type, array_keys( $available_post_types ), true ) ) {
		return '';
	}

	$related_posts = toolbelt_related_posts_get_data( $current_post_type, $available_post_types[ $current_post_type ] );

	if ( empty( $related_posts ) ) {
		return '';
	}

	/**
	 * Juggle them and then reduce to just the related post count we want to use.
	 */
	shuffle( $related_posts );
	$related_posts = array_slice( $related_posts, 0, apply_filters( 'toolbelt_related_posts_count', 2 ) );

	return toolbelt_related_posts_html( $related_posts );

}


/**
 * Add post styles for related posts.
 *
 * @return void
 */
function toolbelt_related_styles() {

	if ( ! is_singular() && ! has_block( 'toolbelt/related-posts' ) ) {
		return;
	}

	toolbelt_global_styles( 'columns' );
	toolbelt_styles( 'related-posts' );

}

add_action( 'wp_print_styles', 'toolbelt_related_styles' );


/**
 * Display admin styles for editor block.
 *
 * @return void
 */
function toolbelt_related_admin_styles() {

	toolbelt_global_styles( 'columns' );
	toolbelt_styles( 'related-posts' );
	toolbelt_styles_editor( 'related-posts' );

}

add_action( 'admin_head', 'toolbelt_related_admin_styles' );


/**
 * Get the html for the related posts output.
 *
 * @param array<mixed> $related_posts A list of the related posts to output.
 * @return string
 */
function toolbelt_related_posts_html( $related_posts ) {

	$html = '<section class="toolbelt-related-posts">';
	$html .= '<h3 class="toolbelt-heading toolbelt-heading-related-posts">' . esc_html__( 'Related Posts', 'wp-toolbelt' ) . '</h3>';
	$html .= '<div class="toolbelt-cols-2">';

	foreach ( $related_posts as $related ) {

		$html .= sprintf(
			'<article>%2$s<h4 class="toolbelt-skip-anchor"><a href="%1$s">%3$s</a></h4></article>',
			esc_url( $related['url'] ),
			$related['image'],
			esc_html( $related['title'] )
		);

	}

	$html .= '</div></section>';

	return $html;

}


/**
 * Get a list of possible related posts.
 *
 * @param string $post_type The post type.
 * @param string $post_taxonomy The post taxonomy name.
 * @return array<mixed>
 */
function toolbelt_related_posts_get_data( $post_type, $post_taxonomy ) {

	$id = get_the_ID();

	if ( ! $id ) {
		return array();
	}

	$transient = sprintf( TOOLBELT_RELATED_POST_TRANSIENT, $id );

	$cache = get_transient( $transient );

	// We have some cache data so lets return it.
	if ( false !== $cache ) {
		return $cache;
	}

	/**
	 * Select 4 times the related posts so that we can cache a collection and
	 * then display a handful from the collection.
	 */
	$cache_target = apply_filters( 'toolbelt_related_posts_count', 2 ) * 4;

	/**
	 * Get the list of categories for the current post.
	 */
	$categories = get_the_terms( $id, $post_taxonomy );
	$category_ids = array();

	if ( $categories && ! is_wp_error( $categories ) ) {

		foreach ( $categories as $category ) {
			$category_ids[] = $category->term_id;
		}
	}

	/**
	 * Store a list of posts that should not be retrieved, so that we don't get
	 * the same post multiple times, and we don't refer to the parent post.
	 */
	$post_not_in = array( $id );

	/**
	 * We are searching for posts that have a thumbnail_id (ie a featured image).
	 */
	$related = new WP_Query(
		array(
			'post_type' => $post_type,
			'category__in' => $category_ids,
			'posts_per_page' => $cache_target,
			'post__not_in' => $post_not_in,
			'order_by' => 'rand',
			'meta_key' => '_thumbnail_id',
			'ignore_sticky_posts' => 1,
		)
	);

	$related_posts = array();

	if ( $related->have_posts() ) {

		while ( $related->have_posts() ) {
			$related->the_post();
			$related_posts[] = toolbelt_related_posts_add();
			$post_not_in[] = get_the_ID();
		}
	}

	wp_reset_postdata();

	/**
	 * If we haven't found enough posts with featured images then lets search
	 * for more that don't have an image.
	 */
	if ( count( $related_posts ) < $cache_target ) {

		$related = new WP_Query(
			array(
				'post_type' => $post_type,
				'category__in' => $category_ids,
				'posts_per_page' => $cache_target - count( $related_posts ),
				'post__not_in' => $post_not_in,
				'order_by' => 'rand',
				'ignore_sticky_posts' => 1,
			)
		);

		if ( $related->have_posts() ) {

			while ( $related->have_posts() ) {
				$related->the_post();
				$related_posts[] = toolbelt_related_posts_add();
			}
		}

		wp_reset_postdata();

	}

	set_transient( $transient, $related_posts, 5 * DAY_IN_SECONDS );

	return $related_posts;

}


/**
 * Return an array containing information about the current related post.
 *
 * @return array<mixed>
 */
function toolbelt_related_posts_add() {

	$thumbnail_size = apply_filters( 'toolbelt_related_posts_thumbnail_size', 'medium' );

	$post_info = array(
		'url' => get_permalink(),
		'title' => get_the_title(),
		'id' => get_the_ID(),
		'image' => '',
	);

	$post_id = (int) get_the_ID();

	if ( ! $post_id ) {
		return $post_info;
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$post_info['image'] = get_the_post_thumbnail( $post_id, $thumbnail_size );
	}

	return $post_info;

}


/**
 * Related posts block render callback.
 *
 * @param array<mixed> $attrs The block attributes.
 * @return string
 */
function toolbelt_related_render_block( $attrs ) {

	$html = toolbelt_related_posts_get();
	if ( toolbelt_is_rest_request() ) {
		$html = preg_replace( '/href="(.*?)"/i', '#', $html );
	}

	return $html;

}


/**
 * Register a Breadcrumbs block.
 *
 * @return void
 */
function toolbelt_related_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';
	$block_name = 'toolbelt-related-posts-block';

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
		'toolbelt/related-posts',
		array(
			'editor_script' => $block_name,
			'render_callback' => 'toolbelt_related_render_block',
			'attributes' => array(
				'align' => array(
					'default' => '',
					'enum' => array( '', 'wide', 'full' ),
					'type' => 'string',
				),
			),
		)
	);

}

add_action( 'init', 'toolbelt_related_register_block' );

toolbelt_register_block_category();

