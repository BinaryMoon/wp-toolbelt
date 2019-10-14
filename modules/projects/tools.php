<?php
/**
 * Projects Tools.
 *
 * @package toolbelt
 */

/**
 * Display the Projects tool forms.
 */
function toolbelt_projects_tools() {

?>
	<section id="toolbelt-projects">

		<h2><?php esc_html_e( 'Projects', 'wp-toolbelt' ); ?></h2>

		<form action="" method="POST">

			<h3><?php esc_html_e( 'Convert Jetpack Portfolio to Toolbelt Portfolio', 'wp-toolbelt' ); ?></h3>
			<input type="hidden" name="action" value="convert_jetpack_portfolio" />
			<p><?php esc_html_e( 'Jetpack has its own Portfolio post type. This command converts the Jetpack posts to Toolbelt Portfolio posts.', 'wp-toolbelt' ); ?></p>
			<?php wp_nonce_field( 'toolbelt_convert_jetpack_portfolio' ); ?>
			<?php submit_button( esc_html__( 'Convert', 'wp-toolbelt' ) ); ?>

		</form>

		<form action="" method="POST">

			<h3><?php esc_html_e( 'Convert Toolbelt Portfolio to Jetpack Portfolio', 'wp-toolbelt' ); ?></h3>
			<input type="hidden" name="action" value="convert_toolbelt_portfolio" />
			<p><?php esc_html_e( 'Convert Toolbelt portfolio items so they will work with Jetpack.', 'wp-toolbelt' ); ?></p>
			<?php wp_nonce_field( 'toolbelt_convert_toolbelt_portfolio' ); ?>
			<?php submit_button( esc_html__( 'Convert', 'wp-toolbelt' ) ); ?>

		</form>

	</section>

<?php

}

add_action( 'toolbelt_module_tools', 'toolbelt_projects_tools' );


/**
 * Convert toolbelt and related post types.
 *
 * @param string $action The action to perform.
 * @return void
 */
function toolbelt_tools_convert_projects( $action ) {

	$actions = array( 'convert_toolbelt_portfolio', 'convert_jetpack_portfolio' );

	if ( ! in_array( $action, $actions, true ) ) {
		return;
	}

	$types = array(
		'jetpack' => array(
			'post' => 'jetpack-portfolio',
			'category' => 'jetpack-portfolio-type',
			'tag' => 'jetpack-portfolio-tag',
		),
		'toolbelt' => array(
			'post' => 'toolbelt-portfolio',
			'category' => 'toolbelt-portfolio-type',
			'tag' => 'toolbelt-portfolio-tag',
		),
	);

	switch ( $action ) {

		case 'convert_toolbelt_portfolio':
			$from = 'toolbelt';
			$to = 'jetpack';

			break;

		default:
		case 'convert_jetpack_portfolio':
			$from = 'jetpack';
			$to = 'toolbelt';

			break;

	}

	global $wpdb;
	$message = '';

	// Convert post types.
	$rows = $wpdb->update(
		$wpdb->posts,
		array( 'post_type' => $types[ $to ]['post'] ),
		array( 'post_type' => $types[ $from ]['post'] )
	);

	// translators: %d = numbers of projects.
	$message .= '<li>' . sprintf( esc_html__( '%d projects converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	// Convert post categories.
	$rows = $wpdb->update(
		$wpdb->term_taxonomy,
		array( 'taxonomy' => $types[ $to ]['category'] ),
		array( 'taxonomy' => $types[ $from ]['category'] )
	);

	// translators: %d = numbers of categories.
	$message .= '<li>' . sprintf( esc_html__( '%d categories converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	// Convert post tags.
	$rows = $wpdb->update(
		$wpdb->term_taxonomy,
		array( 'taxonomy' => $types[ $to ]['tag'] ),
		array( 'taxonomy' => $types[ $from ]['tag'] )
	);

	// translators: %d = numbers of tags.
	$message .= '<li>' . sprintf( esc_html__( '%d tags converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	toolbelt_tools_message( '<ul>' . $message . '</ul>' );

}

add_action( 'toolbelt_tool_actions', 'toolbelt_tools_convert_projects' );
