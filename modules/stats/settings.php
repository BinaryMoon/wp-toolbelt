<?php
/**
 * Stats Settings.
 *
 * @package toolbelt
 */

/**
 * Display the Stats settings.
 *
 * @return void
 */
function toolbelt_stats_fields() {

	$settings = get_option( 'toolbelt_settings', array() );

	$provider = '';
	if ( ! empty( $settings['stats-provider'] ) ) {
		$provider = $settings['stats-provider'];
	}

	$site_id = '';
	if ( ! empty( $settings['stats-site-id'] ) ) {
		$site_id = $settings['stats-site-id'];
	}

	$dashboard_url = '';
	if ( ! empty( $settings['stats-dashboard-url'] ) ) {
		$dashboard_url = $settings['stats-dashboard-url'];
	}

?>

<style>
.tb-stats-provider { display: none; }
</style>

	<fieldset id="toolbelt-stats">

		<h2><?php esc_attr_e( 'Stats', 'wp-toolbelt' ); ?></h2>

		<table class="form-table" role="presentation">

			<tr>
				<th scope="row">
					<label for="toolbelt-stats-provider"><?php esc_html_e( 'Analytics Service', 'wp-toolbelt' ); ?></label>
				</th>
				<td>
					<select name="toolbelt-stats-provider" id="toolbelt-stats-provider">
						<!-- Don't translate the brand names -->
						<option value="fathom" <?php selected( 'fathom', $provider ); ?>>Fathom Analytics</option>
						<option value="simple-analytics" <?php selected( 'simple-analytics', $provider ); ?>>Simple Analytics</option>
						<option value="plausible" <?php selected( 'plausible', $provider ); ?>>Plausible</option>
					</select>
					<p class="description">
						<a href="https://github.com/BinaryMoon/wp-toolbelt/wiki/Stats#stats-providers"><?php esc_html_e( 'More about the Stats Providers', 'wp-toolbelt' ); ?></a>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="toolbelt-stats-dashboard-url"><?php esc_html_e( 'Dashboard URL', 'wp-toolbelt' ); ?></label>
				</th>
				<td><input type="text" name="toolbelt-stats-dashboard-url" id="toolbelt-stats-dashboard-url" class="regular-text" value="<?php echo esc_attr( $dashboard_url ); ?>" /></td>
			</tr>
			<tr class="tb-stats-provider tb-fathom">
				<th scope="row">
					<label for="toolbelt-stats-site-id"><?php esc_html_e( 'Site ID', 'wp-toolbelt' ); ?></label>
				</th>
				<td><input type="text" name="toolbelt-stats-site-id" id="toolbelt-stats-site-id" class="regular-text" value="<?php echo esc_attr( $site_id ); ?>" /></td>
			</tr>

		</table>

	</fieldset>

<script>
(function( $ ) {

	var statsChange = function( e ) {
		$( '.tb-stats-provider' ).hide();
		var provider = $( '#toolbelt-stats-provider' ).find( ':selected' ).val();
		$( '.tb-stats-provider.tb-' + provider ).show();
	};

	$( document ).ready(
		function() {

			$( '#toolbelt-stats-provider' ).on(
				'change',
				statsChange
			);

			statsChange();

		}
	);

})(jQuery);
</script>

<?php

}

add_action( 'toolbelt_module_settings_fields', 'toolbelt_stats_fields' );


/**
 * Filter the monetization settings so that they can be saved.
 *
 * @param array<string> $settings The existing settings.
 * @return array<string>
 */
function toolbelt_stats_settings( $settings ) {

	$settings['stats-provider'] = filter_input( INPUT_POST, 'toolbelt-stats-provider', FILTER_SANITIZE_STRING );
	$settings['stats-dashboard-url'] = filter_input( INPUT_POST, 'toolbelt-stats-dashboard-url', FILTER_SANITIZE_URL );
	$settings['stats-site-id'] = filter_input( INPUT_POST, 'toolbelt-stats-site-id', FILTER_SANITIZE_STRING );

	return $settings;

}

add_filter( 'toolbelt_save_settings', 'toolbelt_stats_settings' );
