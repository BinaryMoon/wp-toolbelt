<?php
/**
 * Random Redirect
 *
 * @package toolbelt
 */

/**
 * Randomly redirect to a blog post.
 *
 * If the post url has ?random on it.
 */
function toolbelt_random_redirect() {

	if ( ! isset( $_GET['random'] ) ) {
		return;
	}

	// Ignore POST requests.
	if ( ! empty( $_POST ) ) {
		return;
	}

	// Persistent AppEngine abuse. ORDER BY RAND is expensive.
	if ( strstr( $_SERVER['HTTP_USER_AGENT'], 'AppEngine-Google' ) ) {
		return;
	}

	$permalink = toolbelt_random_get_post();

	if ( ! $permalink ) {
		return;
	}

	wp_safe_redirect( $permalink );

	die();

}

add_action( 'template_redirect', 'toolbelt_random_redirect' );


/**
 * Get the id of a random post that we can redirect to.
 */
function toolbelt_random_get_post() {

	$post_count = wp_count_posts()->publish;
	$random_post = wp_rand( 1, $post_count );

	$the_post = new WP_Query(
		array(
			'post_type' => 'post',
			'paged' => $random_post,
			'posts_per_page' => 1,
		)
	);

	$permalink = false;

	if ( $the_post->have_posts() ) {
		while ( $the_post->have_posts() ) {
			$the_post->the_post();
			$permalink = get_permalink();
		}
	}

	wp_reset_postdata();

	return $permalink;

}
