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
			esc_url( add_query_arg( array( 'page' => 'toolbelt-modules' ), admin_url( 'admin.php' ) ) )
		);

		if ( has_action( 'toolbelt_module_tools' ) ) {

			$new_actions['toolbelt_tools'] = sprintf(
				'<a href="%2$s">%1$s</a>',
				esc_html__( 'Tools', 'wp-toolbelt' ),
				esc_url( add_query_arg( array( 'page' => 'toolbelt-tools' ), admin_url( 'admin.php' ) ) )
			);

		}

		if ( has_action( 'toolbelt_module_settings' ) ) {

			$new_actions['toolbelt_settings'] = sprintf(
				'<a href="%2$s">%1$s</a>',
				esc_html__( 'Settings', 'wp-toolbelt' ),
				esc_url( add_query_arg( array( 'page' => 'toolbelt-settings' ), admin_url( 'admin.php' ) ) )
			);

		}
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

	$icon = file_get_contents( TOOLBELT_PATH . 'assets/menu-icon.svg' );

	/**
	 * Generate the base64 encoded icon string.
	 */
	$icon_data = '';
	if ( is_string( $icon ) ) {
		$icon_data = 'data:image/svg+xml;base64,' . base64_encode( $icon );
	}

	// Add module selection page.
	add_menu_page(
		'Toolbelt',
		'Toolbelt',
		'manage_options',
		'toolbelt-modules',
		'toolbelt_admin_page',
		$icon_data
	);

	// Add settings page.
	if ( has_action( 'toolbelt_module_settings_fields' ) ) {

		add_submenu_page(
			'toolbelt-modules',
			'Toolbelt Settings',
			'Settings',
			'manage_options', // Author capability.
			'toolbelt-settings', // Slug.
			'toolbelt_settings_page'
		);

	}

	// Add tools page.
	if ( has_action( 'toolbelt_module_tools' ) ) {

		add_submenu_page(
			'toolbelt-modules',
			'Toolbelt Tools',
			'Tools',
			'manage_options', // Author capability.
			'toolbelt-tools', // Slug.
			'toolbelt_tools_page'
		);

	}
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
			<p class="doc-link">
				<a href="<?php echo esc_url( $module['docs'] ); ?>"><?php esc_html_e( 'Documentation', 'wp-toolbelt' ); ?></a>
				<?php if ( $checked && isset( $module['supports'] ) && in_array( 'settings', $module['supports'], true ) ) { ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'toolbelt-settings' ), admin_url( 'admin.php' ) ) ); ?>"><?php esc_html_e( 'Settings', 'wp-toolbelt' ); ?></a>
				<?php } ?>
				<?php if ( $checked && isset( $module['supports'] ) && in_array( 'tools', $module['supports'], true ) ) { ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'toolbelt-tools' ), admin_url( 'admin.php' ) ) ); ?>"><?php esc_html_e( 'Tools', 'wp-toolbelt' ); ?></a>
				<?php } ?>
			</p>
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

	toolbelt_save_modules();

	require TOOLBELT_PATH . 'admin/screen-modules.php';

}


/**
 * Display the tools page.
 */
function toolbelt_tools_page() {

	toolbelt_tools_actions();

	require TOOLBELT_PATH . 'admin/screen-tools.php';

}


/**
 * Display the tools page.
 */
function toolbelt_settings_page() {

	toolbelt_save_settings();

	require TOOLBELT_PATH . 'admin/screen-settings.php';

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

	do_action( 'toolbelt_tool_actions', $action );

}


/**
 * Save Toolbelt settings.
 */
function toolbelt_save_modules() {

	// Use the nonce value to check to see if the form has been submitted.
	if ( null === filter_input( INPUT_POST, '_wpnonce' ) ) {
		return;
	}

	/**
	 * Check the admin referer.
	 * Quit automatically if the nonce is missing/ wrong.
	 */
	check_admin_referer( 'toolbelt_modules' );

	// Get the options and filter them.
	$options = filter_input( INPUT_POST, 'toolbelt_options', FILTER_DEFAULT, FILTER_FORCE_ARRAY );
	// Save the options.
	update_option( 'toolbelt_options', $options, true );

	/**
	 * Flush rewrite rules.
	 * Mostly covers us when the Portfolio CPT is enabled/ disabled.
	 */
	flush_rewrite_rules();

	echo '<div class="notice notice-success"><p>' . esc_html__( 'Settings Saved', 'wp-toolbelt' ) . '</p></div>';

}


/**
 * Save individual module settings.
 */
function toolbelt_save_settings() {

	// Use the nonce value to check to see if the form has been submitted.
	if ( null === filter_input( INPUT_POST, '_wpnonce' ) ) {
		return;
	}

	/**
	 * Check the admin referer.
	 * Quit automatically if the nonce is missing/ wrong.
	 */
	check_admin_referer( 'toolbelt_settings' );

	$options = get_option( 'toolbelt_settings', array() );
	$options = apply_filters( 'toolbelt_save_settings', $options );

	update_option( 'toolbelt_settings', $options, true );

	toolbelt_tools_message( '<p>' . esc_html__( 'Toolbelt settings saved.', 'wp-toolbelt' ) . '</p>' );

}


/**
 * Display a message after tools run.
 * Defaults to a success message.
 *
 * @param string $message The success message to display. Should be a collection of list items.
 * @param string $type The type of message to display.
 */
function toolbelt_tools_message( $message, $type = 'success' ) {

	$types = array(
		'success' => esc_html__( 'Success', 'wp-toolbelt' ),
		'error' => esc_html__( 'Error', 'wp-toolbelt' ),
	);

	// Add the message title if appropriate.
	if ( ! empty( $types[ $type ] ) ) {
		$message = '<p><strong>' . $types[ $type ] . '</strong></p>' . $message;
	}

	/**
	 * Output any messages.
	 * Sanitization of the message is ignored since the properties should be
	 * sanitized when the $message variable is set.
	 */
	echo '<div class="notice notice-' . esc_attr( $type ) . '">' . $message . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

