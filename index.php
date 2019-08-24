<?php
/**
 * Plugin Name: WP Toolbelt
 * Description: More features, fast.
 * Author: Ben Gillbanks
 * Version: 1.1.2
 * Author URI: https://prothemedesign.com
 *
 * @package toolbelt
 */

define( 'TOOLBELT_VERSION', '1.1.2' );
define( 'TOOLBELT_PATH', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'TOOLBELT_DISABLE_ADMIN' ) && is_admin() ) {

	if ( current_user_can( 'manage_options' ) ) {

		require TOOLBELT_PATH . 'admin/index.php';

	}
}


/**
 * Load the enabled modules.
 */
function toolbelt_load_modules() {

	$modules = toolbelt_get_modules();
	$options = get_option( 'toolbelt_options' );

	foreach ( $modules as $slug => $module ) {

		// if module has been enabled then load it.
		if ( ! empty( $options[ $slug ] ) && 'on' === $options[ $slug ] ) {

			require TOOLBELT_PATH . 'modules/' . $slug . '/index.php';

		}
	}

}

add_action( 'after_setup_theme', 'toolbelt_load_modules' );


/**
 * Get the list of available Toolbelt modules.
 */
function toolbelt_get_modules() {

	return array(
		'cookie-banner' => array(
			'name' => esc_html__( 'EU Cookie Banner', 'wp-toolbelt' ),
			'description' => esc_html( 'Display a simple banner with a link to your Privacy Policy.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Cookie-Banner',
			'weight' => esc_html__( '1.2kb of inline JS and CSS.', 'wp-toolbelt' ),
		),
		'social-sharing' => array(
			'name' => esc_html__( 'Static Social Sharing', 'wp-toolbelt' ),
			'description' => esc_html( 'Add social sharing links that use the platforms native sharing system.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Static-Social-Sharing',
			'weight' => esc_html__( '4.1kb of inline SVG icons, and 0.7kb of inline CSS.', 'wp-toolbelt' ),
		),
		'projects' => array(
			'name' => esc_html__( 'Portfolio', 'wp-toolbelt' ),
			'description' => esc_html( 'A portfolio custom post type.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Portfolio',
		),
		'cleanup' => array(
			'name' => esc_html__( 'Header Cleanup', 'wp-toolbelt' ),
			'description' => esc_html( 'Remove unnecessary HTML from the site header.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Optimization',
			'weight' => esc_html__( 'Minus 5kb of HTML from the page head.', 'wp-toolbelt' ),
		),
		'breadcrumbs' => array(
			'name' => esc_html__( 'Breadcrumbs', 'wp-toolbelt' ),
			'description' => esc_html( 'Simple, fast, breadcrumbs. Requires support from the theme to display. See docs for more info.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Breadcrumbs',
			'weight' => esc_html__( '1 or 2kb of HTML.', 'wp-toolbelt' ),
		),
		'related-posts' => array(
			'name' => esc_html__( 'Related Posts', 'wp-toolbelt' ),
			'description' => esc_html( 'Speedy related posts.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Related-Posts',
			'weight' => esc_html__( '0.3kb of inline CSS, plus the HTML and images.', 'wp-toolbelt' ),
		),
		'lazy-load' => array(
			'name' => esc_html__( 'Lazy Load images', 'wp-toolbelt' ),
			'description' => esc_html( 'Add native browser lazy loading to all images on your website. Currently this only works in Chrome, but hopefully it will be added to all browsers.', 'wp-toolbelt' ),
			'docs' => esc_html__( 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Lazy-Loading', 'wp-toolbelt' ),
		),
		'social-menu' => array(
			'name' => esc_html__( 'Social Menu', 'wp-toolbelt' ),
			'description' => esc_html( 'Add a social icons menu. This must be integrated into the theme.', 'wp-toolbelt' ),
			'docs' => esc_html__( 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Social-Menu', 'wp-toolbelt' ),
			'weight' => esc_html__( '0.2kb of inline CSS, plus the SVGs needed for the icons' ),
		),
	);

}
