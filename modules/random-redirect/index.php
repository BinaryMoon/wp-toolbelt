<?php
/**
 * Random Redirect
 *
 * @package toolbelt
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

	$random_id = toolbelt_random_get_post();

	if ( ! $random_id ) {
		return;
	}

	$permalink = get_permalink( $random_id );
	wp_safe_redirect( $permalink );

	die();

}

add_action( 'template_redirect', 'toolbelt_random_redirect' );


function toolbelt_random_get_post() {

	$post_count = wp_count_posts()->publish;
	$random_post = wp_rand( 1, $post_count );

	$the_post = new WP_Query(
		array(
			'p' => $random_post,
		)
	);

	$id = false;

	if ( $the_post->have_posts() ) {
		while ( $the_post->have_posts() ) {
			$the_post->the_post();
			$id = get_the_ID();
		}
	}

	wp_reset_postdata();

	return $id;

}
