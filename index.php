<?php
/**
 * Plugin Name: WP Toolbelt
 * Description: More features, with a focus on privacy and speed.
 * Author: Ben Gillbanks
 * Version: 2.7
 * Author URI: https://prothemedesign.com
 * Text Domain: wp-toolbelt
 *
 * @package toolbelt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TOOLBELT_VERSION', '2.7' );
define( 'TOOLBELT_PATH', plugin_dir_path( __FILE__ ) );
define( 'TOOLBELT_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'TOOLBELT_DIR', basename( TOOLBELT_PATH ) );

if ( ! defined( 'TOOLBELT_DISABLE_ADMIN' ) && is_admin() ) {

	require TOOLBELT_PATH . 'admin/admin.php';
	require TOOLBELT_PATH . 'admin/updates.php';

}


/**
 * Load the enabled modules.
 *
 * @return void
 */
function toolbelt_load_modules() {

	$modules = toolbelt_get_modules();
	$options = toolbelt_get_options();
	$load_css_properties = false;

	foreach ( $modules as $slug => $module ) {

		if ( ! empty( $options[ $slug ] ) && 'on' === $options[ $slug ] ) {

			toolbelt_load_module( $slug, $module );

			if ( isset( $module['supports'] ) && in_array( 'css-properties', $module['supports'], true ) ) {
				$load_css_properties = true;
			}

		}
	}

	/**
	 * If there's at least one moduole active that supports the css custom
	 * properties then enqueue them.
	 */
	if ( $load_css_properties ) {

		add_filter( 'wp_print_styles', 'toolbelt_css_properties' );
		add_filter( 'admin_head', 'toolbelt_css_properties' );

	}

}

toolbelt_load_modules();


/**
 * Load the module and associated admin functionality.
 *
 * @param string        $slug The module slug. Used as the file path.
 * @param array<string> $module The module properties.
 * @return void
 */
function toolbelt_load_module( $slug, $module ) {

	// Load core module code.
	require_once TOOLBELT_PATH . 'modules/' . $slug . '/module.php';

	if ( ! is_admin() ) {

		return;

	}

	if ( ! isset( $module['supports'] ) ) {

		return;

	}

	// Load module tools.
	if ( in_array( 'tools', $module['supports'], true ) ) {

		require_once TOOLBELT_PATH . 'modules/' . $slug . '/tools.php';

	}

	// Load module settings.
	if ( in_array( 'settings', $module['supports'], true ) ) {

		require_once TOOLBELT_PATH . 'modules/' . $slug . '/settings.php';

	}

}


/**
 * Get the list of available Toolbelt modules.
 *
 * @return array<mixed>
 */
function toolbelt_get_modules() {

	return array(
		'admin-tweaks' => array(
			'name' => esc_html__( 'Admin Tweaks', 'wp-toolbelt' ),
			'description' => esc_html__( 'Tweak styles in the admin to make it more usable.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Admin-Tweaks',
		),
		'avatars' => array(
			'name' => esc_html__( 'Avatars', 'wp-toolbelt' ),
			'description' => esc_html__( 'A privacy focused replaced for Gravatar.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Avatars',
			'weight' => esc_html__( '5kb of Javascript, but it removes all Gravatar images so should be an improvement overall', 'wp-toolbelt' ),
			'supports' => array( 'experimental' ),
		),
		'breadcrumbs' => array(
			'name' => esc_html__( 'Breadcrumbs', 'wp-toolbelt' ),
			'description' => esc_html__( 'Simple, fast, breadcrumbs. Requires support from the theme to display. See docs for more info.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Breadcrumbs',
			'weight' => esc_html__( '1 or 2kb of HTML.', 'wp-toolbelt' ),
			'supports' => array( 'css-properties' ),
		),
		'cleanup' => array(
			'name' => esc_html__( 'Header Cleanup', 'wp-toolbelt' ),
			'description' => esc_html__( 'Remove unnecessary HTML from the site header.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Optimization',
			'weight' => esc_html__( 'Minus 5kb of HTML from the page head.', 'wp-toolbelt' ),
		),
		'contact-form' => array(
			'name' => esc_html__( 'Contact Form', 'wp-toolbelt' ),
			'description' => esc_html__( 'Create a contact form.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Contact-Form',
			'supports' => array( 'experimental', 'css-properties' ),
			'weight' => esc_html__( '1.2kb of inline CSS, and 12kb of inline JS.', 'wp-toolbelt' ),
		),
		'cookie-banner' => array(
			'name' => esc_html__( 'Cookie Banner', 'wp-toolbelt' ),
			'description' => esc_html__( 'Display a simple banner with a link to your Privacy Policy.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Cookie-Banner',
			'supports' => array( 'gdpr-hard-mode', 'css-properties' ),
			'weight' => esc_html__( '1.2kb of inline JS and CSS.', 'wp-toolbelt' ),
		),
		'content-security-policy' => array(
			'name' => esc_html__( 'Content Security Policy Headers', 'wp-toolbelt' ),
			'description' => esc_html__( 'Inject a content security policy header into your page responses', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/CSP-Header',
			'supports' => array( 'experimental', 'warning' ),
			'weight' => esc_html__( 'Roughly 1kb of header properties.', 'wp-toolbelt' ),
		),
		'disable-comment-urls' => array(
			'name' => esc_html__( 'Disable the Comment URL Field', 'wp-toolbelt' ),
			'description' => esc_html__( 'Remove the URL field from comment forms. This may only work on the core comment form, and not on custom ones added to themes.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Disable-Comment-Urls',
			'supports' => array( 'tools' ),
		),
		'fast-404' => array(
			'name' => esc_html__( 'Fast 404s', 'wp-toolbelt' ),
			'description' => esc_html__( 'Disable 404 pages for static files like images.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Fast-404',
		),
		'featured-attachment' => array(
			'name' => esc_html__( 'Featured Attachment', 'wp-toolbelt' ),
			'description' => esc_html__( 'If there is no featured image for a post then use the first image attachment instead.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Featured-Attachment',
		),
		'footnotes' => array(
			'name' => esc_html__( 'Footnotes', 'wp-toolbelt' ),
			'description' => esc_html__( 'Add footnotes to the bottom of the page.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Footnotes',
		),
		'gist' => array(
			'name' => esc_html__( 'Gist Embed Block', 'wp-toolbelt' ),
			'description' => esc_html__( 'Easily embed Github Gists onto your site.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Gist',
		),
		'heading-anchors' => array(
			'name' => esc_html__( 'Heading Anchors', 'wp-toolbelt' ),
			'description' => esc_html__( 'Allow site visitors to link to individual sections of the page. Adds unique ids to each heading.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Heading-Anchor',
			'weight' => esc_html__( '0.2kb of inline CSS.', 'wp-toolbelt' ),
		),
		'infinite-scroll' => array(
			'name' => esc_html__( 'Infinite Scroll', 'wp-toolbelt' ),
			'description' => esc_html__( 'Load new post content indefinitely. This may require some changes to your theme for it to work properly.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Infinite-Scroll',
			'weight' => esc_html__( '0.8kb of inline CSS and 1.3kb of inline JS.', 'wp-toolbelt' ),
			'supports' => array( 'css-properties' ),
		),
		'layout-grid' => array(
			'name' => esc_html__( 'Layout Grid', 'wp-toolbelt' ),
			'description' => esc_html__( 'Display content in carefully curated columns.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Layout-Grid',
		),
		'lazy-load' => array(
			'name' => esc_html__( 'Lazy Load images', 'wp-toolbelt' ),
			'description' => esc_html__( 'Add native browser lazy loading to all images on your website. Currently this only works in Chrome, but hopefully it will be added to all browsers.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Lazy-Loading',
		),
		'markdown' => array(
			'name' => esc_html__( 'Markdown', 'wp-toolbelt' ),
			'description' => esc_html__( 'Render Markdown. Uses Github flavor Markdown.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Markdown',
		),
		'monetization' => array(
			'name' => esc_html__( 'Web Monetization', 'wp-toolbelt' ),
			'description' => esc_html__( 'Adds the web monetization meta tag. This allows you to get paid for your content. See docs for more information.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Monetization',
			'supports' => array( 'settings' ),
		),
		'projects' => array(
			'name' => esc_html__( 'Portfolio', 'wp-toolbelt' ),
			'description' => esc_html__( 'A portfolio custom post type for your projects.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Portfolio',
			'supports' => array( 'tools', 'css-properties' ),
		),
		'random-redirect' => array(
			'name' => esc_html__( 'Random Redirect', 'wp-toolbelt' ),
			'description' => esc_html__( 'Randomly Redirect to a blog post.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Random-Redirect',
		),
		'related-posts' => array(
			'name' => esc_html__( 'Related Posts', 'wp-toolbelt' ),
			'description' => esc_html__( 'Speedy related posts.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Related-Posts',
			'weight' => esc_html__( '0.3kb of inline CSS, plus the HTML and images.', 'wp-toolbelt' ),
			'supports' => array( 'tools', 'css-properties' ),
		),
		'responsive-videos' => array(
			'name' => esc_html__( 'Responsive Videos', 'wp-toolbelt' ),
			'description' => esc_html__( 'Ensure embedded videos maintain a 16:9 aspect ratio on all screen sizes. Ignores blocks with responsive videos.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Responsive-Videos',
			'weight' => esc_html__( '0.2kb of inline CSS.', 'wp-toolbelt' ),
		),
		'search-redirect' => array(
			'name' => esc_html__( 'Search Redirect', 'wp-toolbelt' ),
			'description' => esc_html__( 'If there is a single search result then redirect to the result, rather than displaying a list of results.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Search-Redirect',
		),
		'slider' => array(
			'name' => esc_html__( 'Simple Slider', 'wp-toolbelt' ),
			'description' => esc_html__( 'An Accessible horizontal slider.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Simple-Slider',
		),
		'social-menu' => array(
			'name' => esc_html__( 'Social Menu', 'wp-toolbelt' ),
			'description' => esc_html__( 'Add a social icons menu. This must be integrated into the theme.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Social-Menu',
			'weight' => esc_html__( '0.2kb of inline CSS, plus the SVGs needed for the icons.', 'wp-toolbelt' ),
		),
		'social-sharing' => array(
			'name' => esc_html__( 'Static Social Sharing', 'wp-toolbelt' ),
			'description' => esc_html__( 'Add social sharing links that use the platforms native sharing system.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Static-Social-Sharing',
			'weight' => esc_html__( '4.1kb of inline SVG icons, and 0.7kb of inline CSS.', 'wp-toolbelt' ),
			'supports' => array( 'css-properties', 'settings' ),
		),
		'spam-blocker' => array(
			'name' => esc_html__( 'Spam Blocker', 'wp-toolbelt' ),
			'description' => esc_html__( 'Attempt to block spam.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Spam-Blocker',
			'weight' => esc_html__( '0.3kb of inline JS', 'wp-toolbelt' ),
			'supports' => array( 'experimental' ),
		),
		'star-rating' => array(
			'name' => esc_html__( 'Star Ratings', 'wp-toolbelt' ),
			'description' => esc_html__( 'Rate movies, books, videos, difficulty, whatever.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Star-Ratings',
		),
		'stats' => array(
			'name' => esc_html__( 'Stats', 'wp-toolbelt' ),
			'description' => esc_html__( 'Website statistics and analytics.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Stats',
			'supports' => array( 'settings' ),
		),
		'testimonials' => array(
			'name' => esc_html__( 'Testimonial', 'wp-toolbelt' ),
			'description' => esc_html__( 'A testimonials custom post type.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Testimonials',
			'weight' => esc_html__( '0.5kb of inline CSS.', 'wp-toolbelt' ),
			'supports' => array( 'tools', 'css-properties' ),
		),
		'widows' => array(
			'name' => esc_html__( 'Typographic Widows', 'wp-toolbelt' ),
			'description' => esc_html__( 'Fix typographic widows in titles and headings.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Typographic-Widows',
		),
		'widget-display' => array(
			'name' => esc_html__( 'Widget Display', 'wp-toolbelt' ),
			'description' => esc_html__( 'Control which pages widgets appear on.', 'wp-toolbelt' ),
			'docs' => 'https://github.com/BinaryMoon/wp-toolbelt/wiki/Widget-Display',
		),
	);

}


/**
 * Output custom css properties that are used by the plugin css.
 *
 * This can be used by themes to make the spacings match those used.
 *
 * @return void
 */
function toolbelt_css_properties() {

	if ( toolbelt_is_amp_page() ) {
		return;
	}

	$properties = array(
		'toolbelt-spacing' => '1rem',
		'toolbelt-scroll-margin-top' => '45px',
		'toolbelt-color-dark' => 'black',
		'toolbelt-color-mid' => 'lightgrey',
		'toolbelt-color-light' => 'white',
	);

	$properties = apply_filters(
		'toolbelt_css_properties',
		$properties
	);

	$css_properties = '';

	foreach ( $properties as $key => $value ) {
		$css_properties .= ' --' . $key . ':' . $value . ';';
	}

	echo '<style name="toolbelt-properties">:root {';
	echo esc_attr( $css_properties );
	echo '}</style>';

}


/**
 * Inline the module css.
 *
 * @param string $module The module slug.
 * @param string $file The file name for the style to include.
 * @return void
 */
function toolbelt_styles( $module, $file = 'style' ) {

	if ( defined( 'TOOLBELT_DISABLE_STYLES' ) ) {
		return;
	}

	if ( toolbelt_is_amp_page() ) {
		return;
	}

	$css_filter = sprintf( 'toolbelt_hide_%s_styles', $module );

	if ( apply_filters( $css_filter, false ) ) {
		return;
	}

	$path = TOOLBELT_PATH . 'modules/' . $module . '/' . $file . '.min.css';

	if ( in_array( $path, get_included_files(), true ) ) {
		return;
	}

	echo '<style name="toolbelt-style-' . esc_attr( $module ) . '">';
	require_once $path;
	echo '</style>';

}


/**
 * Load the block editor styles.
 *
 * @param string $module The module to load.
 * @param string $file The file to load. Defaults to block.css.
 * @return void|null
 */
function toolbelt_styles_editor( $module, $file = 'block' ) {

	$screen = get_current_screen();

	if ( ! $screen || 'post' !== $screen->base ) {
		return;
	}

	toolbelt_styles( $module, $file );

}


/**
 * Inline the module css.
 *
 * @param string $module The module slug.
 * @return void|null
 */
function toolbelt_global_styles( $module ) {

	if ( defined( 'TOOLBELT_DISABLE_STYLES' ) ) {
		return;
	}

	$css_filter = sprintf( 'toolbelt_hide_%s_styles', $module );

	if ( apply_filters( $css_filter, false ) ) {
		return;
	}

	$path = TOOLBELT_PATH . 'assets/css/' . $module . '.css';

	if ( in_array( $path, get_included_files(), true ) ) {
		return;
	}

	echo '<style name="toolbelt-global-style-' . esc_attr( $module ) . '">';
	require_once $path;
	echo '</style>';

}


/**
 * Inline the module script.
 *
 * @param string $module The module slug.
 * @param string $file Optional filename to include. Defaults to 'script'.
 * @return void|null
 */
function toolbelt_scripts( $module, $file = 'script' ) {

	// Output scripts.
	$path = TOOLBELT_PATH . 'modules/' . $module . '/' . $file . '.min.js';

	if ( in_array( $path, get_included_files(), true ) ) {
		return;
	}

	echo '<script name="toolbelt-script-' . esc_attr( $module ) . '">';
	require_once $path;
	echo '</script>';

}


/**
 * Inline the module script.
 *
 * @param string $script The module slug.
 * @return void|null
 */
function toolbelt_global_script( $script ) {

	// Output scripts.
	$path = TOOLBELT_PATH . 'assets/js/' . $script . '.js';

	if ( in_array( $path, get_included_files(), true ) ) {
		return;
	}

	echo '<script name="toolbelt-script-' . esc_attr( sanitize_title( $script ) ) . '">';
	require_once $path;
	echo '</script>';

}


/**
 * Load the toolbelt options.
 *
 * @return array<string>
 */
function toolbelt_get_options() {

	/**
	 * Add a filter that allows us to override the database options.
	 *
	 * If these options are set then they will be the only options used. The
	 * database will be ignored entirely.
	 *
	 * @see https://github.com/BinaryMoon/wp-toolbelt/wiki/Admin-Settings#toolbelt_options
	 */
	$options = apply_filters( 'toolbelt_options', null );

	if ( empty( $options ) ) {

		$options = get_option( 'toolbelt_options' );

	}

	return $options;

}


/**
 * Display the plugin url relative to the plugin root.
 *
 * @param string $path The path to load.
 * @return string
 */
function toolbelt_plugins_url( $path ) {

	return TOOLBELT_PLUGIN_URL . '/' . ltrim( $path, '/' );

}


/**
 * Add a block category for Toolbelt.
 *
 * @param array<mixed> $categories The current list of categories.
 * @param string       $post The post type for the current page.
 * @return array<mixed>
 */
function toolbelt_block_category( $categories, $post ) {

	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'wp-toolbelt',
				'title' => esc_html__( 'Toolbelt', 'toolbelt' ),
			),
		)
	);

}


/**
 * Register block categories.
 *
 * Call this directly from modules. It will only add the filter once.
 *
 * @return void
 */
function toolbelt_register_block_category() {

	if ( has_filter( 'block_categories', 'toolbelt_block_category' ) ) {
		return;
	}

	add_filter( 'block_categories', 'toolbelt_block_category', 10, 2 );

}


/**
 * If is AMP page.
 *
 * @return boolean
 */
function toolbelt_is_amp_page() {

	if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
		return true;
	}

	return false;

}
