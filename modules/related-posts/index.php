<?php
/**
 * Related Posts
 *
 * @package toolbelt
 */

define( 'TOOLBELT_RELATED_POST_TRANSIENT', 'toolbelt_related_post_' . TOOLBELT_VERSION . '_%d' );


/**
 * Add related posts to the end of the_content.
 *
 * @param string $content The post content that we will be appending.
 * @return string
 */
function toolbelt_related_posts( $content ) {


/**
 * An option to disable the automatic output of the related posts.
 *
 * Included directly since this file is included on the init hook.
 *
 * If you disable the related posts output you can still echo the
 * toolbelt_related_posts_get() function directly within your theme.
 */
if ( apply_filters( 'toolbelt_related_posts', true ) ) {
	add_filter( 'the_content', 'toolbelt_related_posts' );
}
	if ( ! is_singular() ) {
		return $content;
	}

	$related_posts = toolbelt_related_posts_get();

	if ( ! $related_posts ) {
		return $content;
	}

	/**
	 * Juggle them and then reduce to just the related post count we want to use.
	 */
	shuffle( $related_posts );
	$related_posts = array_slice( $related_posts, 0, apply_filters( 'toolbelt_related_posts_count', 2 ) );

	$path = plugin_dir_path( __FILE__ );

	// Output bar styles. Do this first so that the bar has styles instantly.
	echo '<style>';
	require $path . 'style.min.css';
	echo '</style>';

	return $content . toolbelt_related_posts_html( $related_posts );

}

add_filter( 'the_content', 'toolbelt_related_posts' );


/**
 * Get the html for the related posts output.
 *
 * @param array $related_posts A list of the related posts to output.
 * @return string
 */
function toolbelt_related_posts_html( $related_posts ) {

	$html = '<section class="toolbelt-related-posts">';
	$html .= '<h3>' . esc_html__( 'Related Posts', 'wp-toolbelt' ) . '</h3>';

	foreach ( $related_posts as $related ) {

		$html .= sprintf(
			'<a href="%1$s">%2$s<h4>%3$s</h4></a>',
			esc_url( $related['url'] ),
			$related['image'],
			esc_html( $related['title'] )
		);

	}

	$html .= '</section>';

	return $html;

}


/**
 * Get a list of possible related posts.
 *
 * @return array
 */
function toolbelt_related_posts_get() {

	$id = get_the_ID();
	$transient = sprintf( TOOLBELT_RELATED_POST_TRANSIENT, $id );

	$cache = get_transient( $transient );

	// We have some posts so lets quit.
	if ( ! empty( $cache ) ) {
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
	$categories = get_the_terms( $id, 'category' );
	$category_ids = array();

	foreach ( $categories as $category ) {
		$category_ids[] = $category->term_id;
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
			'category_in' => $category_ids,
			'posts_per_page' => $cache_target,
			'post__not_in' => $post_not_in,
			'order_by' => 'rand',
			'meta_key' => '_thumbnail_id',
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
				'category_in' => $category_ids,
				'posts_per_page' => $cache_target - count( $related_posts ),
				'post__not_in' => $post_not_in,
				'order_by' => 'rand',
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

	set_transient( $transient, $related_posts );

	return $related_posts;

}


/**
 * Return an array containing information about the current related post.
 *
 * @return array
 */
function toolbelt_related_posts_add() {

	$thumbnail_size = apply_filters( 'toolbelt_related_posts_thumbnail_size', 'medium' );

	$post_info = array(
		'url' => get_permalink(),
		'title' => get_the_title(),
		'id' => get_the_ID(),
		'image' => '',
	);

	if ( has_post_thumbnail( get_the_ID() ) ) {
		$post_info['image'] = get_the_post_thumbnail( get_the_ID(), $thumbnail_size );
	}

	return $post_info;

}
