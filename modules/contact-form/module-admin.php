<?php
/**
 * Editor settings for the contact form block.
 *
 * @package wp-toolbelt
 */

/**
 * Register a Contact Form block.
 *
 * @return void
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
			'wp-compose',
			'wp-block-editor',
		),
		'1.0',
		true
	);

	// The main contact form.
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

	// Subject.
	register_block_type(
		'toolbelt/field-subject',
		array(
			'parent' => array( 'toolbelt/contact-form' ),
			'render_callback' => 'toolbelt_contact_field_subject',
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
 * Get the Contact Form blocks from the post content.
 *
 * @param string $content The post content.
 * @param string $hash The contact form hash.
 * @return array<mixed>
 */
function toolbelt_contact_get_blocks( $content, $hash ) {

	if ( ! $content ) {
		return array();
	}

	$content_blocks = parse_blocks( $content );

	$blocks = array();

	foreach ( $content_blocks as $index => $block ) {

		// If this is a toolbelt contact form block.
		if ( 'toolbelt/contact-form' === $block['blockName'] ) {

			/**
			 * If it's this specific contact form block.
			 *
			 * The hash 'should' be unique, but may not always be. In the case
			 * that it's not unique settings will be taken from the first form
			 * found with the same hash value.
			 *
			 * Since the hash is the same the attributes will be the same as
			 * well, so this shouldn't be a problem.
			 */
			if ( toolbelt_contact_hash( $block['attrs'] ) === $hash ) {

				$blocks[] = $block;

			}
		}
	}

	return $blocks;

}


/**
 * Combine all of the contact form fields from the post blocks.
 *
 * @param array<mixed> $blocks The list of blocks to check.
 * @return array<mixed>
 */
function toolbelt_contact_get_fields( $blocks ) {

	$fields = array();

	foreach ( $blocks as $index => $block ) {

		$fields = array_merge( toolbelt_contact_parse_fields( $block ), $fields );

	}

	return $fields;

}


/**
 * Get a specific attribute for the current block.
 *
 * @param array<mixed> $blocks The blocks to get the attributes from.
 * @param string       $attribute The name of the attribute to search for.
 * @param mixed        $default The default value if none is set in the attribute.
 * @return mixed
 */
function toolbelt_contact_get_block_attribute( $blocks, $attribute = '', $default = null ) {

	$value = '';

	if ( isset( $blocks[0]['attrs'][ $attribute ] ) ) {
		$value = $blocks[0]['attrs'][ $attribute ];
	}

	if ( empty( $value ) && null !== $default ) {
		$value = $default;
	}

	return $value;

}


/**
 * The post type is registered on init (priority 11) so this needs to be called
 * after since it tries to load the post taxonomies.
 *
 * @return void
 */
add_action( 'init', 'toolbelt_contact_form_register_block', 12 );

toolbelt_register_block_category();


/**
 * Display the contact form styles on the front end.
 *
 * @return void
 */
function toolbelt_contact_form_styles() {

	if ( ! has_block( 'toolbelt/contact-form' ) ) {
		return;
	}

	toolbelt_styles( 'contact-form' );
	toolbelt_global_script( 'bouncer.polyfills.min' );

}

add_action( 'wp_print_styles', 'toolbelt_contact_form_styles' );


/**
 * Display the contact form script on the front end.
 *
 * @return void
 */
function toolbelt_contact_form_script() {

	if ( ! has_block( 'toolbelt/contact-form' ) ) {
		return;
	}

	toolbelt_scripts( 'contact-form' );

}

add_action( 'wp_footer', 'toolbelt_contact_form_script' );
