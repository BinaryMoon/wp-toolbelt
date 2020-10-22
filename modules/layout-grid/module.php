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

	if ( has_block( 'toolbelt/layout-grid' ) ) {
		toolbelt_styles( 'layout-grid' );
	}

	/**
	 * Grab a list of all the layout-grid blocks so that we can load their css.
	 *
	 * This saves us from having to put all of the css in a single file reducing
	 * the download size.
	 */
	$classes = preg_match_all( '/toolbelt-grid-layout-\d-\d/', get_the_content(), $matches );

	foreach ( $matches[0] as $layout ) {
		$file = sprintf(
			'layouts/layout-%1$s',
			str_replace( 'toolbelt-grid-layout-', '', $layout )
		);
		toolbelt_styles( 'layout-grid', $file );
	}

}

add_filter( 'wp_head', 'toolbelt_layout_head' );


toolbelt_register_block_category();
