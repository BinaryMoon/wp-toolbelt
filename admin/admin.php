<?php
/**
 * Toolbelt Admin Screen.
 *
 * @package toolbelt
 */

/**
 * Add a "settings" link to Toolbelt in the plugin list.
 *
 * This function gets called for all plugins, so we need to check which plugin
 * is being tested, and only add the settings for the relevant one.
 *
 * @param array  $plugin_actions The current links for the plugin being checked.
 * @param string $plugin_file The filepath for the plugin being checked.
 */
function toolbelt_admin_settings_link( $plugin_actions, $plugin_file ) {

	$new_actions = array();

	if ( TOOLBELT_DIR . '/index.php' === $plugin_file ) {

		$new_actions['toolbelt_settings'] = sprintf(
			'<a href="%2$s">%1$s</a>',
			esc_html__( 'Settings', 'wp-toolbelt' ),
			esc_url( add_query_arg( array( 'page' => 'toolbelt-settings' ), admin_url( 'options-general.php' ) ) )
		);

		$new_actions['toolbelt_tools'] = sprintf(
			'<a href="%2$s">%1$s</a>',
			esc_html__( 'Tools', 'wp-toolbelt' ),
			esc_url( add_query_arg( array( 'page' => 'toolbelt-tools' ), admin_url( 'tools.php' ) ) )
		);

	}

	return array_merge( $new_actions, $plugin_actions );

}

add_filter( 'plugin_action_links', 'toolbelt_admin_settings_link', 10, 2 );


/**
 * Add a Toolbelt admin menu item.
 */
function toolbelt_admin_menu() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Add settings page.
	add_options_page(
		'Toolbelt', // Page title.
		'Toolbelt', // Menu title.
		'manage_options', // Author capability.
		'toolbelt-settings', // Slug.
		'toolbelt_admin_page'
	);

	// Add tools pagre.
	add_management_page(
		'Toolbelt', // Page title.
		'Toolbelt', // Menu title.
		'manage_options', // Author capability.
		'toolbelt-tools', // Slug.
		'toolbelt_tools_page'
	);

}

add_action( 'admin_menu', 'toolbelt_admin_menu' );


/**
 * Display a module activation field.
 *
 * Displays a brief description and a link to the module docs.
 *
 * @param string $slug The module slug.
 * @param array  $module The module parameters.
 */
function toolbelt_field( $slug, $module ) {

	$options = get_option( 'toolbelt_options' );

	$checked = true;
	if ( empty( $options[ $slug ] ) ) {
		$checked = false;
	}

	$weight = ! empty( $module['weight'] ) ? $module['weight'] : '';

?>

	<tr>
		<th class="check-column" scope="row">
			<input
				id="<?php echo esc_attr( $slug ); ?>"
				name="toolbelt_options[<?php echo esc_attr( $slug ); ?>]"
				<?php checked( $checked ); ?>
				type="checkbox" />
		</th>
		<td class="column-title column-primary">
			<label for="<?php echo esc_attr( $slug ); ?>">
				<strong><?php echo esc_html( $module['name'] ); ?></strong>
			</label>

			<button type="button" class="toggle-row"><span class="screen-reader-text"><?php esc_html_e( 'Show more details', 'wp-toolbelt' ); ?></span></button>
		</td>
		<td data-colname="<?php esc_attr_e( 'Description', 'wp-toolbelt' ); ?>">
			<p><?php echo esc_html( $module['description'] ); ?></p>
			<p class="doc-link"><a href="<?php echo esc_html( $module['docs'] ); ?>"><?php esc_html_e( 'Documentation', 'wp-toolbelt' ); ?></a></p>
		</td>
		<td class="column-weight" data-colname="<?php esc_attr_e( 'Page Impact', 'wp-toolbelt' ); ?>">
			<?php echo esc_html( $weight ); ?>
		</td>
	</tr>

<?php

}


/**
 * Display the Toolbelt admin page.
 */
function toolbelt_admin_page() {

	toolbelt_save_admin_settings();

	require TOOLBELT_PATH . 'admin/settings.php';

}


/**
 * Display the tools page.
 */
function toolbelt_tools_page() {

	toolbelt_tools_actions();

	require TOOLBELT_PATH . 'admin/tools.php';

}


/**
 * Check if all the modules are enabled.
 *
 * @return boolean
 */
function toolbelt_admin_all_modules_enabled() {

	$options = get_option( 'toolbelt_options' );

	$modules = toolbelt_get_modules();
	$checked = 0;

	foreach ( $modules as $slug => $module ) {

		if ( ! empty( $options[ $slug ] ) ) {
			$checked ++;
		}
	}

	if ( count( $modules ) === $checked ) {
		return true;
	}

	return false;

}


/**
 * Do toolbelt form actions.
 */
function toolbelt_tools_actions() {

	// Use the nonce value to check to see if the form has been submitted.
	if ( null === filter_input( INPUT_POST, '_wpnonce' ) ) {
		return;
	}

	$action = filter_input( INPUT_POST, 'action' );

	/**
	 * Check the admin referer.
	 * Quit automatically if the nonce is missing/ wrong.
	 */
	check_admin_referer( 'toolbelt_' . esc_html( $action ) );

	/**
	 * Include functions that perform actions used by the tools.
	 */
	require_once 'tools-functions.php';

	switch ( $action ) {

		case 'convert_toolbelt_portfolio':
		case 'convert_jetpack_portfolio':
			toolbelt_tools_convert( $action );
			break;

		case 'remove_comment_links':
			toolbelt_tools_remove_comment_links();
			break;

	}

}


/**
 * Save Toolbelt settings.
 */
function toolbelt_save_admin_settings() {

	// Use the nonce value to check to see if the form has been submitted.
	if ( null === filter_input( INPUT_POST, '_wpnonce' ) ) {
		return;
	}

	/**
	 * Check the admin referer.
	 * Quit automatically if the nonce is missing/ wrong.
	 */
	check_admin_referer( 'toolbelt_settings' );

	// Get the options and filter them.
	$options = filter_input( INPUT_POST, 'toolbelt_options', FILTER_DEFAULT, FILTER_FORCE_ARRAY );
	// Save the options.
	update_option( 'toolbelt_options', $options );

	/**
	 * Flush rewrite rules.
	 * Mostly covers us when the Portfolio CPT is enabled/ disabled.
	 */
	flush_rewrite_rules();

	echo '<div class="notice notice-success"><p>' . esc_html__( 'Settings Saved', 'wp-toolbelt' ) . '</p></div>';

}
