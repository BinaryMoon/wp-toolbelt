<?php
/**
 * Custom Post Type for contact form.
 *
 * @package toolbelt
 */

define( 'TOOLBELT_CONTACT_POST_META', 'toolbelt-contact-post-meta' );

/**
 * Setup the contact form CPT.
 *
 * @return void
 */
function toolbelt_contact_cpt() {

	// Custom post type we'll use to keep copies of the feedback items.
	register_post_type(
		'feedback',
		array(
			'labels' => array(
				'name' => esc_html__( 'Feedback', 'wp-toolbelt' ),
				'singular_name' => esc_html__( 'Feedback', 'wp-toolbelt' ),
				'search_items' => esc_html__( 'Search Feedback', 'wp-toolbelt' ),
				'not_found' => esc_html__( 'No feedback found', 'wp-toolbelt' ),
				'not_found_in_trash' => esc_html__( 'No feedback found', 'wp-toolbelt' ),
			),
			// Material Ballot icon.
			'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M13 7.5h5v2h-5zm0 7h5v2h-5zM19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM11 6H6v5h5V6zm-1 4H7V7h3v3zm1 3H6v5h5v-5zm-1 4H7v-3h3v3z"/></svg>' ),
			'show_ui' => true,
			'show_in_admin_bar' => false,
			'public' => false,
			'rewrite' => false,
			'query_var' => false,
			'capability_type' => 'page',
			'show_in_rest' => false,
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
				'publish_posts' => 'publish_pages',
				'edit_posts' => 'edit_pages',
				'edit_others_posts' => 'edit_others_pages',
				'delete_posts' => 'delete_pages',
				'delete_others_posts' => 'delete_others_pages',
				'read_private_posts' => 'read_private_pages',
				'edit_post' => 'edit_page',
				'delete_post' => 'delete_page',
				'read_post' => 'read_page',
			),
			'map_meta_cap' => true,
		)
	);

	// Add to REST API post type whitelist.
	add_filter(
		'rest_api_allowed_post_types',
		function( $post_types ) {
			$post_types[] = 'feedback';
			return $post_types;
		}
	);

	// Add "spam" as a post status.
	register_post_status(
		'spam',
		array(
			'label' => esc_html__( 'Spam', 'wp-toolbelt' ),
			'public' => false,
			'exclude_from_search' => true,
			'show_in_admin_all_list' => false,
			// translators: %s = The post count.
			'label_count' => _n_noop( 'Spam <span class="count">(%s)</span>', 'Spam <span class="count">(%s)</span>', 'wp-toolbelt' ),
			'protected' => true,
			'_builtin' => false,
		)
	);

}

toolbelt_contact_cpt();


/**
 * Save a feedback submission.
 *
 * @param string       $to_email The email address to send the feedback to.
 * @param string       $subject The email subject.
 * @param string       $message The email message.
 * @param bool         $is_spam Is this email spam or not?.
 * @param int          $post_parent The post that holds the contact form.
 * @param array<mixed> $fields A list of the fields that have been submitted.
 * @return void
 */
function toolbelt_contact_save_feedback( $to_email, $subject, $message, $is_spam, $post_parent, $fields ) {

	$feedback_title = $subject;

	$feedback_status = 'publish';
	if ( $is_spam ) {
		$feedback_status = 'spam';
	}

	$post_id = wp_insert_post(
		array(
			'post_type' => 'feedback',
			'post_status' => addslashes( $feedback_status ),
			'post_title' => addslashes( esc_html( $feedback_title ) ),
			'post_content' => addslashes( wp_kses_post( $message ) ),
			'post_parent' => (int) $post_parent,
		)
	);

	if ( is_wp_error( $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, TOOLBELT_CONTACT_POST_META, $fields );

}


/**
 * The post list table column headings.
 *
 * @param array<string> $cols List of table columns.
 * @return array<string>
 */
function toolbelt_contact_post_type_columns_filter( $cols ) {

	return array(
		'cb' => '<input type="checkbox" />',
		'feedback_message' => esc_html__( 'Message', 'wp-toolbelt' ),
		'feedback_from' => esc_html__( 'From', 'wp-toolbelt' ),
		'date' => esc_html__( 'Date', 'wp-toolbelt' ),
	);

}

add_action( 'manage_feedback_posts_columns', 'toolbelt_contact_post_type_columns_filter' );


/**
 * Output the content of the feedback columns.
 *
 * This function takes care of the message and the from columns. The date column
 * is generated automatically by WordPress.
 *
 * @param string $col The column we are displaying.
 * @param int    $post_id The post id we are displaying.
 * @return void
 */
function toolbelt_contact_manage_post_columns( $col, $post_id ) {

	global $post;

	/**
	 * Display the from column.
	 *
	 * This is the info about who sent the message.
	 */
	if ( 'feedback_from' === $col ) {

		$meta = get_post_meta( $post_id, TOOLBELT_CONTACT_POST_META, true );

		$author_name = toolbelt_contact_get_field( $meta, 'name', '' );
		$author_email = toolbelt_contact_get_field( $meta, 'email', '' );

		// Display the author name.
		if ( ! empty( $author_name ) ) {
			printf(
				'<strong>%s</strong><br />',
				esc_html( $author_name )
			);
		}

		// Display the author email address.
		if ( ! empty( $author_email ) ) {
			printf(
				'<a href="%1$s" target="_blank">%2$s</a><br />',
				esc_url( 'mailto:' . $author_email ),
				esc_html( $author_email )
			);
		}

		// Display the page that the contact form was submitted from.
		if ( isset( $post->post_parent ) && $post->post_parent > 0 ) {
			$form_url = get_permalink( $post->post_parent );
			if ( $form_url ) {
				echo '<a href="' . esc_url( $form_url ) . '">' . esc_html( $form_url ) . '</a>';
			}
		}
	}

	/**
	 * Display the message column.
	 */
	if ( 'feedback_message' === $col ) {

		the_title( '<h2 style="margin:2px 0 0.4em 0;">', '</h2>' );
		echo '<div class="toolbelt-excerpt" style="margin-bottom: 4px;">';
		the_content();
		echo '</div>';
		echo '<button class="toolbelt-excerpt-expand button action" style="display: none; margin-bottom: 8px;">' . esc_html__( 'Show All', 'wp-toolbelt' ) . '</button>';

	}

}

add_action( 'manage_posts_custom_column', 'toolbelt_contact_manage_post_columns', 10, 2 );


/**
 * Add feedback manipulation links to posts.
 *
 * Allows users to easily spam and unspam posts.
 *
 * @param array<string> $actions List of actions.
 * @param WP_Post       $post Post info.
 * @return array<string>
 */
function toolbelt_contact_row_actions( $actions, $post ) {

	// Only add the spam option to the feedback post type.
	if ( 'feedback' !== $post->post_type ) {
		return $actions;
	}

	switch ( $post->post_status ) {

		case 'trash':

			break;

		case 'draft':
		case 'publish':

			// Mark as spam.
			$actions[] = sprintf(
				'<span class="spam feedback-spam"><a data-id="%1$d" data-verify="%5$s" title="%2$s" href="%3$s">%4$s</a></span>',
				(int) $post->ID,
				esc_html__( 'Mark this message as spam', 'wp-toolbelt' ),
				wp_nonce_url( admin_url( 'admin-ajax.php?post_id=' . (int) $post->ID . '&amp;action=spam' ), 'spam-feedback_' . $post->ID ),
				esc_html__( 'Spam', 'wp-toolbelt' ),
				wp_create_nonce( 'toolbelt-spam-' . (int) $post->ID )
			);

			break;

		case 'spam':

			// Mark as NOT spam.
			$actions[] = sprintf(
				'<span class="unspam unapprove feedback-ham"><a data-id="%1$d" data-verify="%4$s" title="%2$s" href="">%3$s</a></span>',
				(int) $post->ID,
				esc_html__( 'Mark this message as NOT spam', 'wp-toolbelt' ),
				esc_html__( 'Not Spam', 'wp-toolbelt' ),
				wp_create_nonce( 'toolbelt-publish-' . (int) $post->ID )
			);

			break;

	}

	return $actions;

}

add_filter( 'post_row_actions', 'toolbelt_contact_row_actions', 10, 2 );


/**
 * Add a custom script for managing the feedback post type.
 *
 * @return void
 */
function toolbelt_contact_admin_script() {

	$screen = get_current_screen();

	if ( isset( $screen->id ) && 'edit-feedback' !== $screen->id ) {
		return;
	}

	wp_enqueue_script( 'toolbelt-cpt-actions', plugins_url( 'admin.min.js', __FILE__ ), array(), TOOLBELT_VERSION, true );

}

add_action( 'admin_enqueue_scripts', 'toolbelt_contact_admin_script' );
