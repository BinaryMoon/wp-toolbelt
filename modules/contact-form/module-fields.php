<?php
/**
 * Code related to the individual form fields.
 *
 * @package toolbelt
 */

/**
 * Display an input field.
 *
 * @param string $type The field type to display.
 * @param array  $atts The field attributes.
 * @param array  $default_attrs The default field attributes.
 * @return string The field html to render.
 */
function toolbelt_contact_input_field( $type, $atts = array(), $default_attrs = array() ) {

	if ( empty( $type ) ) {
		$type = 'text';
	}

	/**
	 * Ensure the default attributes have a default value.
	 *
	 * Defaults for the defaults.
	 * Prevents errors when checking the attributes exist, and allows me to
	 * override the defaults per field type.
	 */
	$default_attrs = shortcode_atts(
		array(
			'label' => '',
			'placeholder' => '',
		),
		$default_attrs,
		'contact-form-defaults'
	);

	$atts = shortcode_atts(
		array(
			'label' => $default_attrs['label'],
			'value' => '',
			'description' => '',
			'className' => '',
			'placeholder' => $default_attrs['placeholder'],
			'required' => false,
		),
		$atts,
		'contact-form'
	);

	$id = toolbelt_contact_get_field_name( $atts['label'] );

	$html = sprintf(
		'<input type="%1$s" name="%2$s" id="%2$s" value="%3$s" class="%4$s" placeholder="%5$s" %6$s />',
		esc_attr( $type ),
		$id,
		esc_attr( $atts['value'] ),
		esc_attr( $atts['className'] ),
		esc_attr( $atts['placeholder'] ),
		( $atts['required'] ? 'required aria-required="true"' : '' )
	);

	return toolbelt_contact_field_wrap_label( $atts['label'], $id, $atts['required'], $atts['description'], $html );

}


/**
 * Display a textarea field.
 *
 * @param array  $atts The field attributes.
 * @param string $default_label The default label for the textarea.
 * @return string The field html.
 */
function toolbelt_contact_textarea_field( $atts, $default_label = '' ) {

	$atts = shortcode_atts(
		array(
			'label' => $default_label,
			'className' => '',
			'required' => false,
			'description' => '',
		),
		$atts,
		'contact-form'
	);

	$id = toolbelt_contact_get_field_name( $atts['label'] );

	$html = sprintf(
		'<textarea name="%1$s" id="%1$s" class="%2$s" %3$s /></textarea>',
		$id,
		esc_attr( $atts['className'] ),
		( $atts['required'] ? 'required aria-required="true"' : '' )
	);

	return toolbelt_contact_field_wrap_label( $atts['label'], $id, $atts['required'], $atts['description'], $html );

}


/**
 * Display checkbox field.
 *
 * @param array $atts Checkbox field attributes.
 * @return string Checkbox field html.
 */
function toolbelt_contact_checkbox_field( $atts ) {

	$atts = shortcode_atts(
		array(
			'label' => '',
			'className' => '',
			'required' => false,
			'description' => '',
		),
		$atts,
		'contact-form'
	);

	$id = toolbelt_contact_get_field_name( $atts['label'] );

	$description = toolbelt_contact_description( $atts['description'] );

	return sprintf(
		'<label for="%1$s"><input type="checkbox" name="%1$s" id="%1$s" class="%2$s" %3$s />%4$s%5$s</label>',
		$id,
		esc_attr( $atts['className'] ),
		( $atts['required'] ? 'required aria-required="true"' : '' ),
		esc_attr( $atts['label'] ),
		wp_kses_post( $description )
	);

}


/**
 * Display a multi field.
 * Supports radio and checkbox types.
 *
 * @param string $type The type of field to display.
 * @param array  $atts The field attributes.
 * @return string
 */
function toolbelt_contact_field_multi( $type, $atts ) {

	$atts = shortcode_atts(
		array(
			'label' => esc_html__( 'Select several', 'wp-toolbelt' ),
			'className' => '',
			'required' => false,
			'description' => '',
			'options' => null,
		),
		$atts,
		'contact-form'
	);

	if ( count( $atts['options'] ) <= 0 ) {
		return '';
	}

	$html = '';

	/**
	 * Generate the field name.
	 *
	 * If the post is a checkbox we want to pass the value as an array instead
	 * of a single value so we add the [].
	 */
	$id = toolbelt_contact_get_field_name( $atts['label'] );

	if ( 'checkbox' === $type ) {
		$id .= '[]';
	}

	foreach ( $atts['options'] as $option ) {

		$html .= sprintf(
			'<label><input type="%1$s" value="%2$s" name="%3$s" />%4$s</label>',
			esc_attr( $type ),
			sanitize_title( $option ),
			$id,
			esc_html( $option )
		);

	}

	return toolbelt_contact_field_wrap_fieldset( $atts['label'], $atts['required'], $atts['description'], $html );

}


/**
 * Format the field description.
 *
 * @param string $description The description to format.
 * @return string
 */
function toolbelt_contact_description( $description = '' ) {

	if ( ! empty( $description ) ) {
		$description = '<p class="toolbelt-description">' . $description . '</p>';
	}

	return $description;

}


/**
 * Display a multi select dropdown.
 *
 * @param array $atts The select field attributes.
 * @return string
 */
function toolbelt_contact_field_multi_select( $atts ) {

	$atts = shortcode_atts(
		array(
			'label' => esc_html__( 'Select one', 'wp-toolbelt' ),
			'className' => '',
			'required' => false,
			'options' => null,
			'description' => '',
		),
		$atts,
		'contact-form'
	);

	if ( count( $atts['options'] ) <= 0 ) {
		return '';
	}

	$html = '';
	$html_options = '';

	foreach ( $atts['options'] as $option ) {

		$html_options .= sprintf(
			'<option value="%1$s">%2$s</option>',
			sanitize_title( $option ),
			esc_html( $option )
		);

	}

	$html = sprintf(
		'<select name="%1$s">%2$s</select>',
		toolbelt_contact_get_field_name( $atts['label'] ),
		$html_options
	);

	$id = toolbelt_contact_get_field_name( $atts['label'] );

	return toolbelt_contact_field_wrap_label( $atts['label'], $id, $atts['required'], $atts['description'], $html );

}


/**
 * Wrap a label element around a field.
 *
 * @param string $label The field label.
 * @param string $id A unique id that refers to the field being wrapped (for the 'for' attribute).
 * @param bool   $required Is the field required or not.
 * @param string $description The field description.
 * @param string $content The actual field html.
 * @return string The final html with the field and label all bundled together.
 */
function toolbelt_contact_field_wrap_label( $label, $id, $required = true, $description = '', $content = '' ) {

	$required_html = '';
	if ( ! $required ) {
		$required_html = '<em class="toolbelt-required">(' . esc_html__( 'Optional', 'wp-toolbelt' ) . ')</em>';
	}

	$description = toolbelt_contact_description( $description );

	return sprintf(
		'<label for="%4$s"><span class="toolbelt-label">%1$s %2$s</span>%5$s%3$s</label>',
		esc_html( $label ),
		$required_html,
		$content,
		esc_attr( $id ),
		wp_kses_post( $description )
	);

}


/**
 * Wrap a label element around a field.
 *
 * @param string $label The field label.
 * @param bool   $required Is the field required or not.
 * @param string $description The field description.
 * @param string $content The actual field html.
 * @return string The final html with the field and label all bundled together.
 */
function toolbelt_contact_field_wrap_fieldset( $label, $required = true, $description = '', $content = '' ) {

	$required_html = '';
	$required_attr = 'required aria-required="true"';
	if ( ! $required ) {
		$required_html = '<em class="toolbelt-required">(' . esc_html__( 'Optional', 'wp-toolbelt' ) . ')</em>';
	}

	$description = toolbelt_contact_description( $description );

	return sprintf(
		'<fieldset class="toolbelt-fieldset"><legend class="toolbelt-field-label">%1$s %2$s</legend>%4$s%3$s</fieldset>',
		esc_html( $label ),
		$required_html,
		$content,
		wp_kses_post( $description )
	);

}


/**
 * Include the Contact form editor styles.
 */
function toolbelt_contact_editor_styles() {

	toolbelt_styles_editor( 'contact-form' );

}

add_action( 'enqueue_block_editor_assets', 'toolbelt_contact_editor_styles' );


/**
 * Display the form.
 *
 * @param array  $atts The form attributes.
 * @param string $content The inner content of the form (likely all the fields).
 * @return string The form html.
 */
function toolbelt_contact_form_html( $atts, $content ) {

	/**
	 * Set a default value for the submit button text.
	 */
	if ( empty( $atts['submitButtonText'] ) ) {

		$atts['submitButtonText'] = esc_html__( 'Submit', 'wp-toolbelt' );

	}

	/**
	 * Custom fields.
	 */
	$fields = apply_filters(
		'toolbelt_contact_fields',
		array(
			'<input type="hidden" name="toolbelt-form-hash" value="' . esc_attr( toolbelt_contact_hash( $atts ) ) . '" />',
			'<input type="hidden" name="toolbelt-post-id" value="' . (int) get_the_ID() . '" />',
			'<input type="submit" value="' . esc_attr( $atts['submitButtonText'] ) . '" />',
		)
	);

	return sprintf(
		'<form class="toolbelt-contact-form" method="POST">%1$s %2$s</form>',
		$content,
		implode( $fields )
	);

}


/**
 * Validate the form with js.
 *
 * We should also make sure to validate/ sanitize all the fields in php as well
 * so we can be sure everything is clean.
 */
function toolbelt_contact_form_validation() {

	/**
	 * Initialize the validation javascript and allow the text to be translated.
	 */
?>
<script id="toolbelt-contact-validation">
	var validate = new Bouncer(
		'.toolbelt-contact-form',
		{
			messages: {
				missingValue: {
					checkbox: '<?php esc_html_e( 'This field is required.', 'wp-toolbelt' ); ?>',
					radio: '<?php esc_html_e( 'Please select a value.', 'wp-toolbelt' ); ?>',
					select: '<?php esc_html_e( 'Please select a value.', 'wp-toolbelt' ); ?>',
					'select-multiple': '<?php esc_html_e( 'Please select at least one value.', 'wp-toolbelt' ); ?>',
					default: '<?php esc_html_e( 'Please fill out this field.', 'wp-toolbelt' ); ?>'
				},
				patternMismatch: {
					email: '<?php esc_html_e( 'Please enter a valid email address.', 'wp-toolbelt' ); ?>',
					url: '<?php esc_html_e( 'Please enter a URL.', 'wp-toolbelt' ); ?>',
					number: '<?php esc_html_e( 'Please enter a number', 'wp-toolbelt' ); ?>',
					color: '<?php esc_html_e( 'Please match the following format: #rrggbb', 'wp-toolbelt' ); ?>',
					date: '<?php esc_html_e( 'Please use the YYYY-MM-DD format', 'wp-toolbelt' ); ?>',
					time: '<?php esc_html_e( 'Please use the 24-hour time format. Ex. 23:00', 'wp-toolbelt' ); ?>',
					month: '<?php esc_html_e( 'Please use the YYYY-MM format', 'wp-toolbelt' ); ?>',
					default: '<?php esc_html_e( 'Please match the requested format.', 'wp-toolbelt' ); ?>'
				},
				outOfRange: {
					over: '<?php esc_html_e( 'Please select a value that is no more than {max}.', 'wp-toolbelt' ); ?>',
					under: '<?php esc_html_e( 'Please select a value that is no less than {min}.', 'wp-toolbelt' ); ?>'
				},
				wrongLength: {
					over: '<?php esc_html_e( 'Please shorten this text to no more than {maxLength} characters. You are currently using {length} characters.', 'wp-toolbelt' ); ?>',
					under: '<?php esc_html_e( 'Please lengthen this text to {minLength} characters or more. You are currently using {length} characters.', 'wp-toolbelt' ); ?>'
				}
			}
		}
	);
</script>
<?php

}

add_action( 'wp_footer', 'toolbelt_contact_form_validation' );


/**
 * Get the default field values.
 *
 * If a key is set and it exists then this will return an array of default
 * values.
 * If the key is set and does not exist it will return false.
 * If no key is set it will return all default values.
 *
 * @param string $key The defaults to return.
 * @return array|false
 */
function toolbelt_contact_field_defaults( $key = null ) {

	$defaults = array(
		'text' => array(
			'label' => esc_html__( 'Text', 'wp-toolbelt' ),
		),
		'name' => array(
			'label' => esc_html__( 'Name', 'wp-toolbelt' ),
		),
		'email' => array(
			'label' => esc_html__( 'Email', 'wp-toolbelt' ),
			'placeholder' => 'name@domain.com',
		),
		'url' => array(
			'label' => esc_html__( 'Website', 'wp-toolbelt' ),
			'placeholder' => 'https://domain.com',
		),
		'date' => array(
			'label' => esc_html__( 'Date', 'wp-toolbelt' ),
		),
		'telephone' => array(
			'label' => esc_html__( 'Phone Number', 'wp-toolbelt' ),
		),
		'textarea' => array(
			'label' => esc_html__( 'Message', 'wp-toolbelt' ),
		),
	);

	/**
	 * In a key is specified and a default exists for that key then return the
	 * value.
	 */
	if ( null !== $key && isset( $defaults[ $key ] ) ) {
		return $defaults[ $key ];
	}

	/**
	 * If a key is specified and a default does not exist then return false.
	 */
	if ( null !== $key ) {
		return false;
	}

	/**
	 * No key so return everything.
	 */
	return $defaults;

}


/**
 * Render a text field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_text( $atts ) {

	return toolbelt_contact_input_field( 'text', $atts, toolbelt_contact_field_defaults( 'text' ) );

}


/**
 * Render a name field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_name( $atts ) {

	return toolbelt_contact_input_field( 'text', $atts, toolbelt_contact_field_defaults( 'name' ) );

}


/**
 * Render an email field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_email( $atts ) {

	return toolbelt_contact_input_field( 'email', $atts, toolbelt_contact_field_defaults( 'email' ) );

}


/**
 * Render a url field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_url( $atts ) {

	return toolbelt_contact_input_field( 'url', $atts, toolbelt_contact_field_defaults( 'url' ) );

}


/**
 * Render a date field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_date( $atts ) {

	return toolbelt_contact_input_field( 'date', $atts, toolbelt_contact_field_defaults( 'date' ) );

}


/**
 * Render a telephone number field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_telephone( $atts ) {

	return toolbelt_contact_input_field( 'tel', $atts, toolbelt_contact_field_defaults( 'telephone' ) );

}


/**
 * Render a textarea on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_textarea( $atts ) {

	return toolbelt_contact_textarea_field( $atts, esc_html__( 'Message', 'wp-toolbelt' ) );

}


/**
 * Render a checkbox on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_checkbox( $atts ) {

	return toolbelt_contact_checkbox_field( $atts );

}


/**
 * Render a multi checkbox on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_checkbox_multi( $atts ) {

	return toolbelt_contact_field_multi( 'checkbox', $atts );

}


/**
 * Render a radio field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_radio( $atts ) {

	return toolbelt_contact_field_multi( 'radio', $atts );

}


/**
 * Render a select field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_select( $atts ) {

	return toolbelt_contact_field_multi_select( $atts );

}

