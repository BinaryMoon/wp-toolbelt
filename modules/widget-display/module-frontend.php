<?php
/**
 * Frontend settings for widgets.
 *
 * @package toolbelt
 */

/**
 * Set or unset the widgets.
 *
 * @param array<mixed> $sidebar_widgets List of widgets to check.
 * @return array<mixed>
 */
function toolbelt_widget_display_filter_sidebars_widgets( $sidebar_widgets ) {

	if ( is_customize_preview() ) {
		return $sidebar_widgets;
	}

	/**
	 * Reset any database queries done now that we're about to make decisions
	 * based on the context given in the WP query for the page.
	 */
	wp_reset_postdata();

	/**
	 * Loop through every widget in every sidebar
	 * (barring 'wp_inactive_widgets') checking display settings for each one.
	 */
	foreach ( $sidebar_widgets as $widget_area => $widget_list ) {

		if ( 'wp_inactive_widgets' === $widget_area ) {
			continue;
		}

		if ( empty( $widget_list ) ) {
			continue;
		}

		foreach ( $widget_list as $pos => $widget_id ) {

			$rules = toolbelt_widget_display_by_id( $widget_id );

			if ( ! toolbelt_widget_display( $rules ) ) {
				unset( $sidebar_widgets[ $widget_area ][ $pos ] );
			}
		}
	}

	return $sidebar_widgets;

}

add_filter( 'sidebars_widgets', 'toolbelt_widget_display_filter_sidebars_widgets', 10 );


/**
 * Add the widget settings to the customizer.
 */
function toolbelt_widget_display_customizer() {

	add_action( 'dynamic_sidebar', 'toolbelt_widget_display_dynamic_sidebar' );

}

add_action( 'customize_preview_init', 'toolbelt_widget_display_customizer' );


/**
 * Display sidebar widgets, fading out the widgets that should be hidden on the
 * current page.
 *
 * @param array<mixed> $widget The widget properties.
 */
function toolbelt_widget_display_dynamic_sidebar( $widget ) {

	$widget_id = $widget['id'];

	if ( ! preg_match( '/^(.+)-(\d+)$/', $widget_id ) ) {
		return;
	}

	$rules = toolbelt_widget_display_by_id( $widget_id );

	if ( ! toolbelt_widget_display( $rules ) ) {
?>
<style>
	<?php echo '#' . esc_attr( $widget_id ); ?> { opacity: 0.25; }
</style>
<?php
	}

}
