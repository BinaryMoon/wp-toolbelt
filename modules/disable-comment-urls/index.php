<?php
/**
 * Disable author urls in comments.
 *
 * @package toolbelt
 */

/**
 * Disable comment author links.
 *
 * By default 'get_comment_author_link' returns a html link. This stips out the
 * html and leaves just the commenter name.
 *
 * @param type $author_link Author link to simplify.
 * @return string
 */
function toolbelt_disable_comment_author_links( $author_link ) {

	return wp_strip_all_tags( $author_link );

}

add_filter( 'get_comment_author_link', 'toolbelt_disable_comment_author_links' );


/**
 * Remove URL field from comments form.
 *
 * @param array $fields List of form fields to display.
 * @return string
 */
function toolbelt_comment_form_fields( $fields ) {

	$fields['url'] = '';
	return $fields;

}

add_filter( 'comment_form_default_fields', 'toolbelt_comment_form_fields' );
