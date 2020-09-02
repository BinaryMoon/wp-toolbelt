<?php
/**
 * Layout block.
 *
 * @package toolbelt
 */

/**
 * Register the Layout block.
 *
 * @return void
 */
function toolbelt_layout_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';

	wp_enqueue_script(
		'toolbelt-layout-grid',
		plugins_url( 'block.min.js', __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-components',
		),
		'1.0',
		true
	);

}

add_action( 'enqueue_block_editor_assets', 'toolbelt_layout_register_block' );


/**
 * Display admin styles for editor block.
 *
 * @return void
 */
function toolbelt_layout_admin_styles() {

	toolbelt_styles_editor( 'layout-grid' );

}

add_action( 'admin_head', 'toolbelt_layout_admin_styles' );


/**
 * Add layout grid styles to header.
 *
 * @return void
 */
function toolbelt_layout_head() {

	if ( ! is_single() ) {
		return;
	}

	toolbelt_styles( 'layout-grid' );

}

add_filter( 'wp_head', 'toolbelt_layout_head' );


toolbelt_register_block_category();
