<?php
/**
 * Simple slider block.
 *
 * @package toolbelt
 */

/**
 * Register the Slider block.
 *
 * @return void
 */
function toolbelt_slider_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';

	wp_register_script(
		'toolbelt-slider-block',
		plugins_url( 'block.min.js', __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-components',
			'marked',
		),
		'1.0',
		true
	);

	register_block_type(
		'toolbelt/slider',
		array(
			'editor_script' => 'toolbelt-slider-block',
		)
	);

}

add_action( 'init', 'toolbelt_slider_register_block' );


/**
 * Display admin styles for editor block.
 *
 * @return void
 */
function toolbelt_slider_admin_styles() {

	toolbelt_styles_editor( 'slider' );

}

add_action( 'admin_head', 'toolbelt_slider_admin_styles' );


/**
 * Add Slider styles to header.
 *
 * @return void
 */
function toolbelt_slider_head() {

	if ( has_block( 'toolbelt/slider' ) ) {
		toolbelt_styles( 'slider' );
	}

}

add_filter( 'wp_head', 'toolbelt_slider_head' );


toolbelt_register_block_category();
