<?php
/**
 * Infinite Scroll.
 *
 * @package toolbelt
 */

// No infinite scroll in the admin so leave.
if ( is_admin() ) {
	return;
}


/**
 * Add infinite scroll scripts to footer.
 */
function toolbelt_is_footer() {

	if ( ! toolbelt_is_active() ) {
		return;
	}

	toolbelt_scripts( 'infinite-scroll' );

	$current_page = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

	/**
	 * Work out what the link structure should be.
	 * Are we using permalinks or not?
	 */
	$permalink = '/page/%d/';
	if ( ! get_option( 'permalink_structure' ) ) {
		$permalink = '/?page=%d';
	}

?>
<script>
toolbelt_is.permalink = '<?php echo esc_url( home_url( $permalink ) ); ?>';
toolbelt_is.route = '<?php echo esc_url( home_url( '/wp-json/wp-toolbelt/v1/infinite-scroll/' ) ); ?>';
toolbelt_is.page = <?php echo (int) $current_page; ?>;
</script>
<?php

}

add_filter( 'wp_footer', 'toolbelt_is_footer' );


/**
 * Add infinite scroll styles to header.
 *
 * Normally I include styles before they are needed, but this ensures they are
 * added before the pagination is displayed.
 */
function toolbelt_is_head() {

	if ( ! toolbelt_is_active() ) {
		return;
	}

	toolbelt_styles( 'infinite-scroll' );

}

add_filter( 'wp_head', 'toolbelt_is_head' );


/**
 * Initialize Infinite Scroll styles.
 */
function toolbelt_is_init() {

	if ( ! toolbelt_is_active() ) {
		return;
	}

	add_filter( 'navigation_markup_template', 'toolbelt_is_html', 10, 2 );
	add_filter( 'body_class', 'toolbelt_is_class' );

}

add_action( 'init', 'toolbelt_is_init' );


/**
 * Add the load more button to the template.
 *
 * @param string $template The navigation template to be modified.
 * @param string $class The type of navigation being generated.
 * @return string
 */
function toolbelt_is_html( $template, $class ) {

	if ( 'post-navigation' === $class ) {
		return $template;
	}

	return $template . toolbelt_is_button();

}


/**
 * Get the html for the 'load more' button.
 *
 * @return string The load more html.
 */
function toolbelt_is_button() {

	return sprintf(
		'<div class="toolbelt-infinite-scroll-wrapper"><div class="toolbelt-spinner"></div><button>%s</button></div>',
		esc_html__( 'Load More', 'wp-toolbelt' )
	);

}


/**
 * Add body class letting the world know Infinite scroll is enabled.
 *
 * @param array $classes List of current classes.
 * @return array
 */
function toolbelt_is_class( $classes ) {

	$classes[] = 'toolbelt-infinite-scroll';

	return $classes;

}


/**
 * Should we setup infinite scroll?
 *
 * @return bool
 */
function toolbelt_is_active() {

	if ( ! current_theme_supports( 'infinite-scroll' ) ) {
		return false;
	}

	/**
	 * Only works on front page of blog.
	 * Does not work on archives or other post types.
	 * Simplifies the code massively.
	 */
	if ( ! is_home() && ! is_main_query() ) {
		return false;
	}

	return true;

}


/**
 * Set REST routes for IS.
 */
function toolbelt_is_rest() {

	register_rest_route(
		'wp-toolbelt/v1',
		'/infinite-scroll/(?P<page>\d+)',
		array(
			'methods' => 'GET',
			'callback' => 'toolbelt_is_rest_response',
			'permissions_callback' => '__return_true',
		)
	);

}

add_action( 'rest_api_init', 'toolbelt_is_rest' );


/**
 * Fallback post renderer for when themes don't support Infinite Scroll.
 */
function toolbelt_is_render() {

	while ( have_posts() ) {

		the_post();
		get_template_part( 'content', (string) get_post_format() );

	}

}


/**
 * Display the REST posts.
 *
 * @param WP_REST_Request $data The REST response data.
 * @return array
 */
function toolbelt_is_rest_response( $data ) {

	$results = array(
		'html' => '',
	);
	$callback = 'toolbelt_is_render';
	$page = isset( $data['page'] ) ? (int) $data['page'] : 1;

	// Get Infinite Scroll properties.
	$settings = get_theme_support( 'infinite-scroll' );
	if ( isset( $settings[0]['render'] ) ) {
		$callback = $settings[0]['render'];
	}

	// Make sure the callback is actually a function.
	if ( ! is_callable( $callback ) ) {
		return $results;
	}

	/**
	 * Create the query.
	 *
	 * We assign the property to the wp_query globals so that we don't have to
	 * use the WP_Query object to refer to the have_posts method. This makes the callback much easier to track.
	 *
	 * Since this is done in the REST Endpoint it won't affect any other part of WordPress.
	 */
	$GLOBALS['wp_query'] = new WP_Query( // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		array(
			'paged' => $page,
		)
	);

	// Add page number before inserting posts.
	// translators: %d = page number.
	$results['html'] = '<h6 class="toolbelt-divider">' . sprintf( esc_html__( 'Page %d', 'wp-toolbelt' ), $page ) . '</h6>';

	/**
	 * Render the content.
	 *
	 * Since we use a callback that users can change we call the function as an
	 * action, which also gives us a bit more flexibility in terms of developers
	 * hooking into the renderer.
	 *
	 * Captured in output buffer so we can grab generated html easily.
	 */
	if ( have_posts() ) {

		ob_start();

		add_action( 'infinite_scroll_render', $callback );
		/**
		 * Fires when rendering Infinite Scroll posts.
		 *
		 * @module infinite-scroll
		 */
		do_action( 'infinite_scroll_render' );
		remove_action( 'infinite_scroll_render', $callback );

		$results['html'] .= ob_get_clean();

	}

	return $results;

}
