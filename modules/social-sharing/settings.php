<?php
/**
 * Social sharing Settings.
 *
 * @package toolbelt
 */

/**
 * Display the Social Sharing settings.
 *
 * @return void
 */
function toolbelt_social_sharing_fields() {

	$settings = get_option( 'toolbelt_settings', array() );

	$enabled_networks = explode( '|', $settings['social-sharing'] );

	$networks = toolbelt_social_networks_get();

	foreach ( $networks as $key => $network ) {
		$networks[ $key ]['enabled'] = in_array( $key, $enabled_networks, true );
	}

?>

	<h2><?php esc_attr_e( 'Social Sharing', 'wp-toolbelt' ); ?></h2>

	<table class="form-table" role="presentation">

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Buttons', 'wp-toolbelt' ); ?>
			</th>
			<td>
				<fieldset id="toolbelt-social-sharing-networks">

<?php

	foreach ( $networks as $key => $network ) {

		$name = 'social-share-' . $key;

?>
		<label for="<?php echo esc_attr( $name ); ?>">
			<input
				name="toolbelt-social-sharing-networks[]"
				type="checkbox"
				id="<?php echo esc_attr( $name ); ?>"
				value="<?php echo esc_attr( $key ); ?>"
				<?php checked( $network['enabled'] ); ?>
			/>
			<?php echo esc_html( $network['title'] ); ?>
		</label>
		<br/>
<?php

	}

?>

					<p class="description">
						(<?php esc_html_e( 'Note: To hide all social buttons disable the module in the module settings.', 'wp-toolbelt' ); ?>)
					</p>
				</fieldset>
			</td>
		</tr>
	</table>

<?php

}

add_action( 'toolbelt_module_settings_fields', 'toolbelt_social_sharing_fields' );


/**
 * Filter the Social Sharing settings so that they can be saved.
 *
 * @param array<string> $settings The existing settings.
 * @return array<string>
 */
function toolbelt_social_sharing_settings( $settings ) {

	$values = filter_input( INPUT_POST, 'toolbelt-social-sharing-networks', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );

	$settings['social-sharing'] = implode( '|', $values );

	return $settings;

}

add_filter( 'toolbelt_save_settings', 'toolbelt_social_sharing_settings' );


/**
 * Set default social sharing options.
 *
 * @param array $value The default settings option.
 * @return array
 */
function toolbelt_social_sharing_default_settings( $value ) {

	if ( ! isset( $value['social-sharing']) ) {
		$value['social-sharing'] = implode(
			'|',
			array(
				'facebook',
				'twitter',
				'email',
			)
		);
	}

	return $value;

}

add_filter( 'option_toolbelt_settings', 'toolbelt_social_sharing_default_settings' );
