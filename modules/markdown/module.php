<?php
/**
 * Markdown block.
 *
 * @package toolbelt
 */

/**
 * Register a Markdown block.
 */
function toolbelt_markdown_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';

	wp_register_script(
		'marked',
		toolbelt_plugins_url( 'assets/js/marked.min.js' ),
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'toolbelt-markdown-block',
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
		'toolbelt/markdown',
		array(
			'editor_script' => 'toolbelt-markdown-block',
		)
	);

}

add_action( 'init', 'toolbelt_markdown_register_block' );

toolbelt_register_block_category();
