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

	if ( basename( TOOLBELT_PATH ) . '/index.php' === $plugin_file ) {

		$new_actions['sc_settings'] = sprintf(
			'<a href="%2$s">%1$s</a>',
			esc_html__( 'Settings', 'wp-toolbelt' ),
			esc_url( add_query_arg( array( 'page' => 'toolbelt' ), admin_url( 'options-general.php' ) ) )
		);

	}

	return array_merge( $new_actions, $plugin_actions );

}

add_filter( 'plugin_action_links', 'toolbelt_admin_settings_link', 10, 2 );


/**
 * Add a Toolbelt admin menu item.
 */
function toolbelt_admin_menu() {

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
			<strong><?php echo esc_html( $module['name'] ); ?></strong>
		</td>
		<td>
			<p><?php echo esc_html( $module['description'] ); ?></p>
			<p class="doc-link"><a href="<?php echo esc_html( $module['docs'] ); ?>"><?php esc_html_e( 'Documentation', 'wp-toolbelt' ); ?></a></p>
		</td>
		<td class="column-weight">
			<?php echo esc_html( $weight ); ?>
		</td>
	</tr>

<?php

}


/**
 * Display the Toolbelt admin page.
 */
function toolbelt_admin_page() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	toolbelt_save_admin_settings();

	require TOOLBELT_PATH . 'admin/settings.php';

}


/**
 * Display the tools page.
 */
function toolbelt_tools_page() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

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

	toolbelt_tools_convert( $action );

}


/**
 * Convert toolbelt and related post types.
 *
 * @param string $action The action to perform.
 */
function toolbelt_tools_convert( $action ) {

	$nonce = 'toolbelt_' . $action;

	/**
	 * Check the admin referer.
	 * Quit automatically if the nonce is missing/ wrong.
	 */
	check_admin_referer( $nonce );

	$types = array(
		'jetpack' => array(
			'post' => 'jetpack-portfolio',
			'category' => 'jetpack-portfolio-type',
			'tag' => 'jetpack-portfolio-tag',
		),
		'toolbelt' => array(
			'post' => TOOLBELT_CUSTOM_POST_TYPE,
			'category' => TOOLBELT_CUSTOM_TAXONOMY_TYPE,
			'tag' => TOOLBELT_CUSTOM_TAXONOMY_TAG,
		),
	);

	switch ( $action ) {

		case 'convert_jetpack_portfolio':
			$from = 'jetpack';
			$to = 'toolbelt';

			break;

		case 'convert_toolbelt_portfolio':
			$from = 'toolbelt';
			$to = 'jetpack';

			break;

	}

	global $wpdb;
	$message = '';

	// Convert post types.
	$rows = $wpdb->update(
		$wpdb->posts,
		array( 'post_type' => $types[ $from ]['post'] ),
		array( 'post_type' => $types[ $to ]['post'] )
	);

	// translators: %d = numbers of posts.
	$message .= '<li>' . sprintf( esc_html__( '%d posts converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	// Convert post categories.
	$rows = $wpdb->update(
		$wpdb->term_taxonomy,
		array( 'taxonomy' => $types[ $from ]['category'] ),
		array( 'taxonomy' => $types[ $to ]['category'] )
	);

	// translators: %d = numbers of categories.
	$message .= '<li>' . sprintf( esc_html__( '%d categories converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	// Convert post tags.
	$rows = $wpdb->update(
		$wpdb->term_taxonomy,
		array( 'taxonomy' => $types[ $from ]['tag'] ),
		array( 'taxonomy' => $types[ $to ]['tag'] )
	);

	// translators: %d = numbers of tags.
	$message .= '<li>' . sprintf( esc_html__( '%d tags converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	echo '<div class="notice notice-success"><p><strong>' . esc_html__( 'Success', 'wp-toolbelt' ) . '</strong></p><ul>' . $message . '</ul></div>';

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

}
