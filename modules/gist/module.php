<?php
/**
 * Github Gist Block.
 *
 * @package toolbelt
 */

/**
 * Register a Github Gist block.
 *
 * @return void
 */
function toolbelt_gist_register_block() {

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$block_js = dirname( __FILE__ ) . '/block.min.js';

	wp_register_script(
		'toolbelt-github-gist',
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

	register_block_type(
		'toolbelt/gist',
		array(
			'editor_script' => 'toolbelt-github-gist',
			'render_callback' => 'toolbelt_gist_render',
			'attributes' => array(
				'url' => array(
					'default' => '',
					'type' => 'string',
				),
				'align' => array(
					'default' => '',
					'enum' => array( '', 'wide', 'full' ),
					'type' => 'string',
				),
			),
		)
	);

}

add_action( 'init', 'toolbelt_gist_register_block' );


/**
 * Display admin styles for editor block.
 *
 * @return void
 */
function toolbelt_gist_admin_styles() {

	toolbelt_global_styles( 'blocks' );

}

add_action( 'admin_head', 'toolbelt_gist_admin_styles' );


/**
 * Render the Github Gist.
 *
 * @param array<mixed> $attrs The block attributes.
 * @return string
 */
function toolbelt_gist_render( $attrs ) {

	$attrs = shortcode_atts(
		array(
			'url' => '',
			'align' => '',
		),
		$attrs,
		'toolbelt-gist'
	);

	if ( empty( $attrs['url'] ) ) {
		return '';
	}

	$class_name = array( 'toolbelt-gist' );
	if ( ! empty( $attrs['align'] ) ) {
		$class_name[] = 'align' . $attrs['align'];
	}

	/**
	 * Work out the embed url.
	 */
	$url = $attrs['url'];
	if ( false !== strpos( $url, '#file-' ) ) {

		/**
		 * The following code works out the embed code for a Gist that contains
		 * multiple files, and links to a single file.
		 *
		 * Eg https://gist.github.com/BinaryMoon/edb39e27ec0327d01f63d8b9bc55e071#file-gulpfile-header-js
		 *
		 * If
		 */
		$url = str_replace( '#file-', '.js?file=', $url );

		$pos = strrpos( $url, '-' );
		if ( false !== $pos ) {
			$url = substr_replace( $url, '.', $pos, 1 );
		}

	} else {

		/**
		 * This assumes the entire url is the embed path.
		 *
		 * Potentially there are instances where this won't work. I will have to address them as they arise.
		 */
		$url = $url . '.js';

	}

	return sprintf(
		'<div class="%2$s"><script src="%1$s"></script></div>', // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
		esc_url( $url ),
		esc_attr( implode( ' ', $class_name ) )
	);

}

toolbelt_register_block_category();
