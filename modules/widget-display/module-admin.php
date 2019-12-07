<?php
/**
 * Widget Display Admin.
 *
 * @package toolbelt
 */

/**
 * Display the widget display rules input.
 *
 * @param WP_Widget    $widget The widget instance.
 * @param null         $return Return null if new fields are added.
 * @param array<mixed> $instance The widgets settings.
 * @return void
 */
function toolbelt_widget_display_form( $widget, $return, $instance ) {

	$rules = '';

	if ( isset( $instance['toolbelt_widget_display'] ) ) {
		$rules = $instance['toolbelt_widget_display'];
	}

?>

		<p>

			<label for="<?php echo esc_attr( $widget->get_field_id( 'toolbelt_widget_display' ) ); ?>">
				<?php esc_html_e( 'Widget display rules:', 'wp-toolbelt' ); ?>
			</label>

			<textarea
				class="widefat"
				name="<?php echo esc_attr( $widget->get_field_name( 'toolbelt_widget_display' ) ); ?>"
				id="<?php echo esc_attr( $widget->get_field_id( 'toolbelt_widget_display' ) ); ?>"
				><?php echo esc_textarea( $rules ); ?></textarea>

			<span class="description"><a href="https://github.com/BinaryMoon/wp-toolbelt/wiki/Widget-Display#rules" target="_blank"><?php esc_html_e( 'How to write display rules.', 'wp-toolbelt' ); ?></a></span>

		</p>

<?php

}

add_filter( 'in_widget_form', 'toolbelt_widget_display_form', 10, 3 );


/**
 * Update the widget settings.
 *
 * @param array<string> $instance     The settings to save.
 * @param array<string> $new_instance The new settings that may have changed.
 * @return array<string>
 */
function toolbelt_widget_display_update_callback( $instance, $new_instance ) {

	if ( isset( $new_instance['toolbelt_widget_display'] ) ) {
		$instance['toolbelt_widget_display'] = esc_html( $new_instance['toolbelt_widget_display'] );
	}

	return $instance;

}

add_filter( 'widget_update_callback', 'toolbelt_widget_display_update_callback', 10, 2 );
