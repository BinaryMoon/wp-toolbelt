<?php
/**
 * Testimonials Tools.
 *
 * @package toolbelt
 */

/**
 * Display the Testimonial tool forms.
 */
function toolbelt_testimonials_tools() {

?>
	<section id="toolbelt-projects">

		<h2><?php esc_html_e( 'Testimonials', 'wp-toolbelt' ); ?></h2>

		<form action="" method="POST">

			<h3><?php esc_html_e( 'Convert Jetpack Testimonials to Toolbelt Testimonials', 'wp-toolbelt' ); ?></h3>
			<input type="hidden" name="action" value="convert_jetpack_testimonial" />
			<p><?php esc_html_e( 'Jetpack has its own Testimonial post type. This command converts the Jetpack posts to Toolbelt Testimonial posts.', 'wp-toolbelt' ); ?></p>
			<?php wp_nonce_field( 'toolbelt_convert_jetpack_testimonial' ); ?>
			<?php submit_button( esc_html__( 'Convert', 'wp-toolbelt' ) ); ?>

		</form>

		<form action="" method="POST">

			<h3><?php esc_html_e( 'Convert Toolbelt Testimonials to Jetpack Testimonials', 'wp-toolbelt' ); ?></h3>
			<input type="hidden" name="action" value="convert_toolbelt_testimonial" />
			<p><?php esc_html_e( 'Convert Toolbelt testimonial items so they will work with Jetpack.', 'wp-toolbelt' ); ?></p>
			<?php wp_nonce_field( 'toolbelt_convert_toolbelt_testimonial' ); ?>
			<?php submit_button( esc_html__( 'Convert', 'wp-toolbelt' ) ); ?>

		</form>

	</section>

<?php

}

add_action( 'toolbelt_module_tools', 'toolbelt_testimonials_tools' );


/**
 * Convert toolbelt and related post types.
 *
 * @param string $action The action to perform.
 * @return void
 */
function toolbelt_tools_convert_testimonials( $action ) {

	$actions = array( 'convert_toolbelt_testimonial', 'convert_jetpack_testimonial' );

	if ( ! in_array( $action, $actions, true ) ) {
		return;
	}

	$types = array(
		'jetpack' => 'jetpack-testimonial',
		'toolbelt' => 'toolbelt-testimonial',
	);

	switch ( $action ) {

		case 'convert_toolbelt_testimonial':
			$from = 'toolbelt';
			$to = 'jetpack';

			break;

		default:
		case 'convert_jetpack_testimonial':
			$from = 'jetpack';
			$to = 'toolbelt';

			break;

	}

	global $wpdb;
	$message = '';

	$rows = $wpdb->update(
		$wpdb->posts,
		array( 'post_type' => $types[ $to ] ),
		array( 'post_type' => $types[ $from ] )
	);

	// Clear rewrite rules, to ensure testimonials display properly.
	flush_rewrite_rules();

	// translators: %d = numbers of testimonials.
	$message .= '<li>' . sprintf( esc_html__( '%d testimonials converted', 'wp-toolbelt' ), (int) $rows ) . '</li>';

	toolbelt_tools_message( '<ul>' . $message . '</ul>' );

}

add_action( 'toolbelt_tool_actions', 'toolbelt_tools_convert_testimonials' );
