<?php
/**
 * Monetization settings.
 *
 * @package toolbelt
 */

/**
 * Display the Web Monetization settings.
 *
 * @return void
 */
function toolbelt_monetization_fields() {

	$settings = get_option( 'toolbelt_settings', array() );

	$monetization = '';
	if ( ! empty( $settings['monetization'] ) ) {
		$monetization = $settings['monetization'];
	}

?>

	<fieldset id="toolbelt-monetization">

		<h2><?php esc_attr_e( 'Monetization', 'wp-toolbelt' ); ?></h2>

		<table class="form-table" role="presentation">

			<tr>
				<th scope="row">
					<label for="toolbelt-monetization"><?php esc_html_e( 'Payment Pointer', 'wp-toolbelt' ); ?></label>
				</th>
				<td>
					<input type="text" name="toolbelt-monetization" id="toolbelt-monetization" class="regular-text" value="<?php echo esc_attr( $monetization ); ?>" />
					<p class="description"><a href="https://github.com/BinaryMoon/wp-toolbelt/wiki/Monetization" target="_blank"><?php esc_html_e( 'Web Monetization Documentation', 'wp-toolbelt' ); ?></a></p>
				</td>
			</tr>

		</table>

	</fieldset>

<?php

}

add_action( 'toolbelt_module_settings_fields', 'toolbelt_monetization_fields' );


/**
 * Filter the monetization settings so that they can be saved.
 *
 * @param array $settings The existing settings.
 * @return array<string>
 */
function toolbelt_monetization_settings( $settings ) {

	$settings['monetization'] = filter_input( INPUT_POST, 'toolbelt-monetization', FILTER_SANITIZE_STRING );
	return $settings;

}

add_filter( 'toolbelt_save_settings', 'toolbelt_monetization_settings' );
