<?php
/**
 * Related Posts Tools.
 *
 * @package toolbelt
 */

/**
 * Display the Related Posts tool forms.
 */
function toolbelt_related_posts_tools() {

?>
	<section id="toolbelt-related-posts">

		<h2><?php esc_html_e( 'Related Posts', 'wp-toolbelt' ); ?></h2>

		<form action="" method="POST">

			<h3><?php esc_html_e( 'Clear the Related Posts Cache', 'wp-toolbelt' ); ?></h3>
			<input type="hidden" name="action" value="clear_related_posts" />
			<p><?php esc_html_e( 'Related Posts are cached per post. They get cleared automatically once a week. You can use this to clear them instantly.', 'wp-toolbelt' ); ?></p>
			<?php wp_nonce_field( 'toolbelt_clear_related_posts' ); ?>
			<?php submit_button( esc_html__( 'Clear', 'wp-toolbelt' ) ); ?>

		</form>

	</section>

<?php

}

add_action( 'toolbelt_module_tools', 'toolbelt_related_posts_tools' );


/**
 * Clear related post transients.
 *
 * @param string $action The action to perform.
 * @return void
 */
function toolbelt_related_posts_clear_tool( $action ) {

	$actions = array( 'convert_toolbelt_portfolio', 'convert_jetpack_portfolio' );

	if ( 'clear_related_posts' !== $action ) {
		return;
	}

	global $wpdb;
	$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_toolbelt_related_post_%')" );

	toolbelt_tools_message( '<p>' . esc_html__( 'Related Posts cache cleared.', 'wp-toolbelt' ) . '</p>' );

}

add_action( 'toolbelt_tool_actions', 'toolbelt_related_posts_clear_tool' );
