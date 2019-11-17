<?php
/**
 * Custom contact form
 *
 * @package toolbelt
 */

/**
 * Todo
 *
 * Range
 * Number (with min and max values?)
 * Hidden field
 * Star rating
 *
 *
 * Drag and drop items in multi field.
 */

/**
 * Register a Contact Form block.
 */
function toolbelt_contact_form_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = plugins_url( 'block.min.js', __FILE__ );
	if ( WP_DEBUG ) {
		$block_js = plugins_url( 'block.js', __FILE__ );
	}

	$block_name = 'toolbelt-contact-form-block';

	wp_register_script(
		$block_name,
		$block_js,
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
		'toolbelt/contact-form',
		array(
			'editor_script' => 'toolbelt-contact-form-block',
			'render_callback' => 'toolbelt_contact_form_html',
			'attributes' => array(
				'align' => array(
					'default' => '',
					'enum' => array( 'wide', 'full' ),
					'type' => 'string',
				),
			),
		)
	);

	// Field render methods.
	register_block_type(
		'toolbelt/field-text',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_text',
		)
	);

	// Name.
	register_block_type(
		'toolbelt/field-name',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_name',
		)
	);

	// Email.
	register_block_type(
		'toolbelt/field-email',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_email',
		)
	);

	// Url.
	register_block_type(
		'toolbelt/field-url',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_url',
		)
	);

	// Date.
	register_block_type(
		'toolbelt/field-date',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_date',
		)
	);

	// Telephone number.
	register_block_type(
		'toolbelt/field-telephone',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_telephone',
		)
	);

	// Textarea.
	register_block_type(
		'toolbelt/field-textarea',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_textarea',
		)
	);

	// Checkbox.
	register_block_type(
		'toolbelt/field-checkbox',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_checkbox',
		)
	);

	// Checkbox Multi.
	register_block_type(
		'toolbelt/field-checkbox-multiple',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_checkbox_multi',
		)
	);

	// Radio buttons.
	register_block_type(
		'toolbelt/field-radio',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_radio',
		)
	);

	// Select box.
	register_block_type(
		'toolbelt/field-select',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_select',
		)
	);

}


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

	/**
	 * Needs to support
	 * ---
	 * https://www.w3schools.com/html/html_form_input_types.asp
	 * input pattern
	 * use `:invalid` styles?
	 */

	$id = 'toolbelt-contact-' . sanitize_title( $atts['label'] );

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

	$id = 'toolbelt-contact-' . sanitize_title( $atts['label'] );

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

	$id = 'toolbelt-contact-' . sanitize_title( $atts['label'] );

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
			'label' => '',
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
	$name = sanitize_title( $atts['label'] );

	foreach ( $atts['options'] as $option ) {

		$html .= sprintf(
			'<label><input type="%1$s" value="%2$s" name="%3$s" />%4$s</label>',
			esc_attr( $type ),
			sanitize_title( $option ),
			$name,
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
			'label' => '',
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
	$name = sanitize_title( $atts['label'] );

	foreach ( $atts['options'] as $option ) {

		$html_options .= sprintf(
			'<option value="%1$s">%2$s</option>',
			sanitize_title( $option ),
			esc_html( $option )
		);

	}

	$html = sprintf(
		'<select name="%1$s">%2$s</select>',
		$name,
		$html_options
	);

	$id = 'toolbelt-contact-' . sanitize_title( $atts['label'] );

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

	$descriotion = toolbelt_contact_description( $description );

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

	$atts = shortcode_atts(
		array(
			'submitButtonText' => esc_html__( 'Submit', 'wp-toolbelt' ),
		),
		$atts,
		'contact-form'
	);

	return sprintf(
		'<form class="toolbelt-contact-form">%1$s<input type="submit" value="%2$s" /></form>',
		$content,
		$atts['submitButtonText']
	);

}


/**
 * Display the contact form styles on the front end.
 */
function toolbelt_contact_form_styles() {

	if ( has_block( 'toolbelt/contact-form' ) ) {
		toolbelt_styles( 'contact-form' );
	}

}

add_action( 'wp_print_styles', 'toolbelt_contact_form_styles' );


/**
 * Render a text field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_text( $atts ) {

	$defaults = array(
		'label' => esc_html__( 'Text', 'wp-toolbelt' ),
	);

	return toolbelt_contact_input_field( 'text', $atts, $defaults );

}


/**
 * Render a name field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_name( $atts ) {

	$defaults = array(
		'label' => esc_html__( 'Name', 'wp-toolbelt' ),
	);

	return toolbelt_contact_input_field( 'text', $atts, $defaults );

}


/**
 * Render an email field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_email( $atts ) {

	$defaults = array(
		'label' => esc_html__( 'Email', 'wp-toolbelt' ),
		'placeholder' => 'name@domain.com',
	);

	return toolbelt_contact_input_field( 'email', $atts, $defaults );

}


/**
 * Render a url field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_url( $atts ) {

	$defaults = array(
		'label' => esc_html__( 'Website', 'wp-toolbelt' ),
		'placeholder' => 'https://domain.com',
	);

	return toolbelt_contact_input_field( 'url', $atts, $defaults );

}


/**
 * Render a date field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_date( $atts ) {

	$defaults = array(
		'label' => esc_html__( 'Date', 'wp-toolbelt' ),
	);

	return toolbelt_contact_input_field( 'date', $atts, $defaults );

}


/**
 * Render a telephone number field on the frontend.
 *
 * @param array $atts Field attributes.
 * @return string
 */
function toolbelt_contact_field_telephone( $atts ) {

	$defaults = array(
		'label' => esc_html__( 'Phone Number', 'wp-toolbelt' ),
	);

	return toolbelt_contact_input_field( 'tel', $atts, $defaults );

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


/**
 * The post type is registered on init (priority 11) so this needs to be called
 * after since it tries to load the post taxonomies.
 */
add_action( 'init', 'toolbelt_contact_form_register_block', 12 );

toolbelt_register_block_category();
