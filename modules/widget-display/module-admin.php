<?php
/**
 * Widget Display Admin.
 *
 * @package toolbelt
 */

/**
 * @param array<string, mixed> $instance  <-- this needs to be here as PHP does not support this in typehints
 */
function toolbelt_widget_display_form( WP_Widget $widget, null $_, array $widget_settings ) : void { // <-- everything in here!

	$rules = '';

	if ( isset( $instance['toolbelt_widget_display'] ) ) {
		$rules = $instance['toolbelt_widget_display'];
	}

?>

		<p>

			<label for="<?php echo esc_attr( $widget->get_field_id( 'toolbelt_widget_display' ) ); ?>">
				<?php esc_html_e( 'Widget display rules:', 'wp-toolbelt' ); ?>
			</label>

			<?php
	        tag( // <-- What a readable code! No HTML.
				'textarea',
				array(
					'class' => 'widefat',
				    'name'  => $widget->get_field_name( 'toolbelt_widget_display' ),
					'id'    => $widget->get_field_id( 'toolbelt_widget_display' ),
				),
				esc_textarea( $rules )
			);
			?>

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
