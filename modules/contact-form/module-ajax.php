<?php
/**
 * Ajax methods for custom post type modifications.
 *
 * @package toolbelt
 */

/**
 * Change the feedback to 'spam' status.
 */
function toolbelt_contact_ajax_spam() {

	toolbelt_contact_feedback_status( 'spam' );
	echo toolbelt_contact_cpt_post_type_nav(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	die();

}

add_action( 'wp_ajax_toolbelt_ajax_spam', 'toolbelt_contact_ajax_spam' );


/**
 * Change the feedback to 'publish' status.
 */
function toolbelt_contact_ajax_ham() {

	toolbelt_contact_feedback_status( 'publish' );
	echo toolbelt_contact_cpt_post_type_nav(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	die();

}

add_action( 'wp_ajax_toolbelt_ajax_ham', 'toolbelt_contact_ajax_ham' );


/**
 * Update the status of a feedback post.
 *
 * @param string $status The status to change the post to.
 */
function toolbelt_contact_feedback_status( $status ) {

	global $wpdb;

	$id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

	$wpdb->update(
		$wpdb->posts,
		array(
			'post_status' => $status,
		),
		array(
			'ID' => (int) $id,
			'post_type' => 'feedback',
		)
	);

}


/**
 * Update the post status counts.
 *
 * @return string
 */
function toolbelt_contact_cpt_post_type_nav() {

	$status = toolbelt_contact_cpt_status();

	$li = array();
	$template = '<li class="%1$s"><a href="%2$s">%3$s <span class="count">(%4$s)</span></a> |</li>';

	/**
	 * Published and All.
	 * We don't actually need the 'All' option, but it's there by default so I'm
	 * keeping it for consistency.
	 */
	if ( ! empty( $status['publish'] ) ) {

		$li[] = sprintf(
			$template,
			'all',
			'edit.php?post_type=feedback',
			esc_html__( 'All', 'wp-toolbelt' ),
			$status['publish']
		);

		$li[] = sprintf(
			$template,
			'publish',
			'edit.php?post_type=feedback&post_status=publish',
			esc_html__( 'Published', 'wp-toolbelt' ),
			$status['publish']
		);

	}

	// Trash.
	if ( ! empty( $status['trash'] ) ) {

		$li[] = sprintf(
			$template,
			'publish',
			'edit.php?post_type=feedback&post_status=trash',
			esc_html__( 'Trash', 'wp-toolbelt' ),
			$status['trash']
		);

	}

	// Spam.
	if ( ! empty( $status['spam'] ) ) {

		$li[] = sprintf(
			$template,
			'publish',
			'edit.php?post_type=feedback&post_status=spam',
			esc_html__( 'Spam', 'wp-toolbelt' ),
			$status['spam']
		);

	}

	/**
	 * Join the links together, uses \n\t since it introduces a bit of
	 * whitespace into the navigation and stops the links from clumping together.
	 */
	$html = implode( "\n\t", $li );
	// Remove the last | from the nav.
	$html = rtrim( $html, '|</li>' );
	// Add back the li we removed above, without the |.
	$html = $html . '</li>';

	return $html;

}


/**
 * Get the number of feedback posts in each status type.
 *
 * @return array
 */
function toolbelt_contact_cpt_status() {

	global $wpdb;

	$feedback_status = (array) $wpdb->get_results(
		"SELECT `post_status`, COUNT( * ) AS `post_count`
		FROM `{$wpdb->posts}`
			WHERE `post_type` = 'feedback'
			GROUP BY `post_status`",
		ARRAY_A
	);

	return array_reduce(
		$feedback_status,
		function ( $status, $row ) {
			$status[ $row['post_status'] ] = $row['post_count'];
			return $status
		},
		array()
	);
}
