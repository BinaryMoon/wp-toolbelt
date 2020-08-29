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
 * @param array<string> $plugin_actions The current links for the plugin being checked.
 * @param string        $plugin_file The filepath for the plugin being checked.
 * @return array<string>
 */
function toolbelt_admin_settings_link( array $plugin_actions, $plugin_file ) {

	$new_actions = array();

	if ( TOOLBELT_DIR . '/index.php' === $plugin_file ) {

		$new_actions['toolbelt_modules'] = sprintf(
			'<a href="%2$s">%1$s</a>',
			esc_html__( 'Modules', 'wp-toolbelt' ),
			esc_url( add_query_arg( array( 'page' => 'toolbelt-modules' ), admin_url( 'admin.php' ) ) )
		);

		if ( has_action( 'toolbelt_module_settings_fields' ) ) {

			$new_actions['toolbelt_settings'] = sprintf(
				'<a href="%2$s">%1$s</a>',
				esc_html__( 'Settings', 'wp-toolbelt' ),
				esc_url( add_query_arg( array( 'page' => 'toolbelt-settings' ), admin_url( 'admin.php' ) ) )
			);

		}

		if ( has_action( 'toolbelt_module_tools' ) ) {

			$new_actions['toolbelt_tools'] = sprintf(
				'<a href="%2$s">%1$s</a>',
				esc_html__( 'Processes', 'wp-toolbelt' ),
				esc_url( add_query_arg( array( 'page' => 'toolbelt-tools' ), admin_url( 'admin.php' ) ) )
			);

		}
	}

	return array_merge( $new_actions, $plugin_actions );

}

add_filter( 'plugin_action_links', 'toolbelt_admin_settings_link', 10, 2 );


/**
 * Add a Toolbelt admin menu item.
 *
 * @return void
 */
function toolbelt_admin_menu() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Add top level Toolbelt menu.
	add_menu_page(
		/* translators: plugin name */
		esc_html__( 'Toolbelt', 'wp-toolbelt' ),
		esc_html__( 'Toolbelt', 'wp-toolbelt' ),
		'manage_options',
		'toolbelt-modules',
		'toolbelt_admin_page',
		'dashicons-hammer'
	);

	// Replace default Modules page with a different title.
	add_submenu_page(
		'toolbelt-modules',
		esc_html__( 'Toolbelt Modules', 'wp-toolbelt' ),
		esc_html__( 'Modules', 'wp-toolbelt' ),
		'manage_options',
		'toolbelt-modules',
		'toolbelt_admin_page'
	);

	// Add settings page.
	if ( has_action( 'toolbelt_module_settings_fields' ) ) {

		add_submenu_page(
			'toolbelt-modules',
			esc_html__( 'Toolbelt Settings', 'wp-toolbelt' ),
			esc_html__( 'Settings', 'wp-toolbelt' ),
			'manage_options',
			'toolbelt-settings',
			'toolbelt_settings_page'
		);

	}

	// Add tools page.
	if ( has_action( 'toolbelt_module_tools' ) ) {

		add_submenu_page(
			'toolbelt-modules',
			esc_html__( 'Toolbelt Processes', 'wp-toolbelt' ),
			esc_html__( 'Processes', 'wp-toolbelt' ),
			'manage_options',
			'toolbelt-tools',
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
 * @param string               $slug The module slug.
 * @param array<string, mixed> $module The module parameters.
 * @return void
 */
function toolbelt_field( $slug, array $module ) {

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
		<td class="column-primary" data-colname="<?php esc_attr_e( 'Module', 'wp-toolbelt' ); ?>">

			<p>
				<label for="<?php echo esc_attr( $slug ); ?>">
					<strong><?php echo esc_html( $module['name'] ); ?></strong>
					<?php if ( isset( $module['supports'] ) && in_array( 'experimental', $module['supports'], true ) ) { ?>
					<em class="experimental"><?php esc_html_e( 'Experimental', 'wp-toolbelt' ); ?></em>
					<?php } ?>
				</label>
			</p>

			<p><?php echo esc_html( $module['description'] ); ?></p>

<?php
	if ( isset( $module['supports'] ) ) {

		if ( in_array( 'gdpr-hard-mode', $module['supports'], true ) ) {
			echo '<p class="gdpr-hard-mode">' . esc_html__( 'Full GDPR support requires developer integration. See documentation for more details.', 'wp-toolbelt' ) . '</p>';
		}

		if ( in_array( 'warning', $module['supports'], true ) ) {
			echo '<p class="warning"><strong>' . esc_html__( 'Warning' ) . '</strong>' . esc_html__( 'This module could break things. Only enable it if you know what you are doing. See documentation for more details.', 'wp-toolbelt' ) . '</p>';
		}

	}
?>

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
 *
 * @return void
 */
function toolbelt_admin_page() {

	toolbelt_save_modules();

	require TOOLBELT_PATH . 'admin/screen-modules.php';

}


/**
 * Display the tools page.
 *
 * @return void
 */
function toolbelt_tools_page() {

	toolbelt_tools_actions();

	require TOOLBELT_PATH . 'admin/screen-tools.php';

}


/**
 * Display the tools page.
 *
 * @return void
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
 *
 * @return void
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
 *
 * @return void
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
 *
 * @return void
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
 * @return void
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

