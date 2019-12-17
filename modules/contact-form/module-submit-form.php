<?php
/**
 * Submit form settings.
 *
 * @package wp-toolbelt
 */

/**
 * Submit the form and send an email.
 *
 * @return void
 */
function toolbelt_contact_submit() {

	/**
	 * Check for the nonce and the hash.
	 * Both have to exist for the contact form to submit.
	 */
	$hash = filter_input( INPUT_POST, 'toolbelt-form-hash' );
	$nonce = filter_input( INPUT_POST, 'toolbelt-token' );
	if ( $hash && ! wp_verify_nonce( $nonce, 'toolbelt_contact_form_token' ) ) {
		wp_die( esc_html__( 'Contact Form timed out', 'wp-toolbelt' ) );
	}

	if ( ! $hash ) {
		return;
	}

	$post_id = filter_input( INPUT_POST, 'toolbelt-post-id', FILTER_SANITIZE_NUMBER_INT );

	/**
	 * Quit because there's nothing to do here.
	 */
	if ( false === $post_id ) {
		return;
	}

	$contact_post = get_post( $post_id );

	/**
	 * Quit because there's no post with this id.
	 */
	if ( null === $contact_post ) {
		return;
	}

	/**
	 * Get the allowed blocks and fields.
	 */
	$blocks = toolbelt_contact_get_blocks( $contact_post->post_content, $hash );
	$fields = toolbelt_contact_get_fields( $blocks );

	/**
	 * Get block attributes from the block data so that we can send the email
	 * with the relevant info.
	 */
	$to = toolbelt_contact_get_block_attribute( $blocks, 'to', get_option( 'admin_email' ) );
	$subject = toolbelt_contact_get_block_attribute( $blocks, 'subject', $contact_post->post_title );
	$subject = apply_filters( 'toolbelt_contact_form_subject', get_option( 'blogname' ) . ': ' . $subject, $fields );

	/**
	 * Grab additional data from the fields list. This will use the first item
	 * of the specified type that is found. It's assumed these are more
	 * important than the ones lower down the form.
	 */
	$message = toolbelt_contact_create_message( $fields );
	$comment_author = toolbelt_contact_get_field( $fields, 'name' );
	$subject = toolbelt_contact_get_field( $fields, 'subject', $subject );
	$from_email_address = toolbelt_contact_get_field( $fields, 'email', get_option( 'admin_email' ) );

	if ( empty( $message ) ) {
		return;
	}

	$headers = array(
		'From: "' . $comment_author . '" <' . $to . '>',
		'Reply-To: "' . $comment_author . '" <' . $from_email_address . '>',
		'Content-Type: text/html; charset=UTF-8',
	);

	/**
	 * Check for spam.
	 *
	 * If the Toolbelt spam module is activated then it will use the internal
	 * spam checking system to ensure content is safe to post.
	 */
	$is_spam_inputs = apply_filters( 'toolbelt_contact_form_spam', false );
	$is_spam_content = apply_filters( 'toolbelt_contact_form_spam_content', implode( ' ', array( $message, $subject, $comment_author ) ) );
	$is_spam = $is_spam_inputs || $is_spam_content;

	/**
	 * If is spam then prepend a message on the front of the content subject
	 * line.
	 */
	if ( $is_spam ) {

		$subject = '**SPAM** ' . $subject;

	}

	/**
	 * Work out where to redirect the page to.
	 *
	 * Redirecting the page stops the message from being sent again if the page
	 * is refreshed.
	 *
	 * It also gives us the opportunity to add a 'message sent' parameter to the
	 * url so that we can display a message telling the user whst has happened.
	 */
	$return_url = add_query_arg(
		array(
			'toolbelt-message' => 'sent',
		),
		get_permalink( $contact_post )
	);

	/**
	 * If the post is spam, and the feedback form post type is enabled then we
	 * won't actually send the spam message. The message can be seen in the
	 * admin instead.
	 */
	$send_email = true;

	/**
	 * Save the email to the database.
	 */
	if ( function_exists( 'toolbelt_contact_save_feedback' ) ) {

		toolbelt_contact_save_feedback(
			$to,
			$subject,
			$message,
			$is_spam,
			$post_id,
			$fields
		);

		/**
		 * The email has been saved, and is spam, so let's not send anything.
		 * We still want to send none spam messages.
		 */
		if ( $is_spam ) {
			$send_email = false;
		}
	}

	/**
	 * Actually send the email.
	 */
	if ( $send_email ) {

		wp_mail(
			sanitize_email( $to ),
			esc_html( $subject ),
			wp_kses_post( $message ),
			$headers
		);

	}

	wp_safe_redirect( $return_url );

	die();

}

add_action( 'init', 'toolbelt_contact_submit' );


/**
 * Modify the subject line, inserting the values of fields into the subject.
 *
 * @param string       $subject The subject to modify.
 * @param array<mixed> $fields The submitted form fields.
 * @return string
 */
function toolbelt_contact_subject_modifiers( $subject, $fields ) {

	// Loop through fields and modify the subject accordingly.
	foreach ( $fields as $field ) {

		// Ignore the checkbox fields since they are only on/ off.
		if ( 'checkbox' === $field['type'] ) {
			continue;
		}

		// What are we searching for.
		$needle = '[' . $field['label'] . ']';
		// Case insensitive string search and replace.
		$subject = str_ireplace( $needle, toolbelt_contact_sanitize( $field ), $subject );

	}

	return $subject;

}

add_filter( 'toolbelt_contact_form_subject', 'toolbelt_contact_subject_modifiers', 10, 2 );


/**
 * Convert an arrazy of fields and values into a text string to send as an email
 * message.
 *
 * @param array<mixed> $fields The list of fields to search through.
 * @return string
 */
function toolbelt_contact_create_message( $fields ) {

	$email = array();

	/**
	 * Loop through the fields and compare to the POST data.
	 */
	foreach ( $fields as $field => $data ) {

		$email[] = '<strong>' . esc_html( $data['label'] ) . ' <em>(' . esc_html( $data['type'] ) . ')</em></strong>';
		$email[] = toolbelt_contact_sanitize( $data );
		// Add a blank line separating the different fields.
		$email[] = '';

	}

	return implode( '<br />' . "\r\n", $email );

}


/**
 * Get field value from list of fields.
 *
 * @param array<mixed> $fields List of fields to search through.
 * @param string       $key Field key to return.
 * @param mixed        $default The default value for the field.
 * @return mixed
 */
function toolbelt_contact_get_field( $fields, $key = '', $default = null ) {

	if ( ! $key ) {
		return '';
	}

	if ( ! is_array( $fields ) ) {
		return '';
	}

	$value = '';

	foreach ( $fields as $field ) {

		if ( $key === $field['type'] ) {

			$value = $field['value'];

		}
	}

	/**
	 * Ensure we have a default set before using it.
	 */
	if ( null !== $default && empty( $value ) ) {
		$value = $default;
	}

	return $value;

}


/**
 * Generate a contact form hash.
 *
 * This needs to be repeatable (a pure function) so that we can match form
 * properties between the front and backend.
 *
 * @param array<string|int> $atts The contact form attributes.
 * @return string
 */
function toolbelt_contact_hash( $atts ) {

	$atts = shortcode_atts(
		array(
			'subject' => '',
			'to' => '',
			'submitButtonText' => esc_html__( 'Submit', 'wp-toolbelt' ),
		),
		$atts,
		'contact-form-hash'
	);

	/**
	 * The WordPress json encode function can return false.
	 * This ensures it is always a string.
	 */
	$json_hash_string = wp_json_encode( $atts );
	if ( ! $json_hash_string ) {
		$json_hash_string = 'Toolbelt';
	}

	return sha1( $json_hash_string );

}


/**
 * Generate a unique, reusable, field name for the current field.
 *
 * @param string $label The label ised for the current field.
 * @return string
 */
function toolbelt_contact_get_field_name( $label ) {

	return 'tbc-' . sanitize_title( $label );

}


/**
 * Sanitize the data input before sending it.
 *
 * @param array<mixed> $data The data object for the sanitized value.
 * @return string
 */
function toolbelt_contact_sanitize( $data ) {

	$value = $data['value'];

	switch ( $data['type'] ) {

		case 'text':

			$value = wp_kses_post( $value );
			break;

		case 'url':

			$value = esc_url( $value );
			break;

		case 'checkbox':

			$value = esc_html( $value );

			if ( 'on' === $value ) {
				$value = esc_html__( 'Yes', 'wp-toolbelt' );
			} else {
				$value = esc_html__( 'No', 'wp-toolbelt' );
			}
			break;

		case 'textarea':

			$value = wp_kses_post( $value );
			$value = nl2br( $value );

			break;

		case 'checkbox-multiple':

			/**
			 * For the multiple checkbox list we will loop through all
			 * checkboxes and display whether they were selected or not.
			 */
			$html = array();
			foreach ( $data['options'] as $option ) {
				$html[] = sprintf(
					'<strong>%1$s:</strong> %2$s',
					esc_html( $option ),
					in_array( sanitize_title( $option ), $value, true ) ? esc_html__( 'Yes', 'wp-toolbelt' ) : esc_html__( 'No', 'wp-toolbelt' )
				);
			}

			$value = implode( '<br />', $html );

			break;

		case 'radio':
		case 'select':

			/**
			 * For select and radio options we need to loop through the
			 * available options to find the one that was selected.
			 */
			foreach ( $data['options'] as $option ) {
				if ( sanitize_title( $option ) === $value ) {
					$value = esc_html( $option );
				}
			}

			break;

		default:

			$value = esc_html( $value );
			break;

	}

	if ( empty( $value ) ) {
		$value = esc_html__( 'No value supplied', 'wp-toolbelt' );
	}

	return $value;

}

