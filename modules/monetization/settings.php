<?php
/**
 * Monetization settings.
 *
 * @package toolbelt
 */

/**
 * Display the Web Monetization settings.
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

		<p>
			<?php esc_html_e( 'Add Web Monetization so that you can get paid by your visitors for your content.', 'wp-toolbelt' ); ?>
			<a href="https://github.com/BinaryMoon/wp-toolbelt/wiki/Monetization" target="_blank"><?php esc_html_e( 'Web Monetization Docs.', 'wp-toolbelt' ); ?></a>
		</p>

		<table class="form-table" role="presentation">

			<tr>
				<th scope="row">
					<label for="toolbelt-monetization"><?php esc_html_e( 'Payment Pointer', 'wp-toolbelt' ); ?></label>
				</th>
				<td><input type="text" name="toolbelt-monetization" id="toolbelt-monetization" value="<?php echo esc_attr( $monetization ); ?>" /></td>
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
 * @return array
 */
function toolbelt_monetization_settings( $settings ) {

	$settings['monetization'] = filter_input( INPUT_POST, 'toolbelt-monetization', FILTER_SANITIZE_STRING );
	return $settings;

}

add_filter( 'toolbelt_save_settings', 'toolbelt_monetization_settings' );