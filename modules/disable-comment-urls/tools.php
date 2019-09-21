<?php
/**
 * Tool to remove comment urls.
 *
 * @package toolbelt
 */

/**
 * Display the Disable Comment Url forms.
 */
function toolbelt_comment_url_tools() {

?>

	<script>
		function toolbelt_confirm_comment_author() {
			return confirm( '<?php esc_attr_e( 'Are you sure? This will delete all author urls and can not be reversed.', 'wp-toolbelt' ); ?>' );
		}
	</script>

	<section id="toolbelt-disable-comment-urls">

		<h2><?php esc_html_e( 'Disable Comment URLs', 'wp-toolbelt' ); ?></h2>

		<form action="" method="POST" onsubmit="return toolbelt_confirm_comment_author();">

			<h3><?php esc_html_e( 'Delete Comment Author URLs from the database.', 'wp-toolbelt' ); ?></h3>
			<input type="hidden" name="action" value="delete_comment_urls" />
			<p><?php esc_html_e( 'Removes all comment author urls from the database. This is not reversible so be sure you want to do it.', 'wp-toolbelt' ); ?></p>
			<?php wp_nonce_field( 'toolbelt_delete_comment_urls' ); ?>
			<?php submit_button( esc_html__( 'Delete All Comment Urls', 'wp-toolbelt' ) ); ?>

		</form>

	</section>

<?php

}

add_action( 'toolbelt_module_tools', 'toolbelt_comment_url_tools' );


/**
 * Delete comment author urls.
 *
 * @param string $action The action to perform.
 * @return void
 */
function toolbelt_comment_url_delete( $action ) {

	if ( 'delete_comment_urls' !== $action ) {
		return;
	}

	global $wpdb;
	$wpdb->query( "UPDATE `$wpdb->comments` SET comment_author_url=''" );

	toolbelt_tools_message( '<p>' . esc_html__( 'Comment Author URLs deleted.', 'wp-toolbelt' ) . '</p>' );

}

add_action( 'toolbelt_tool_actions', 'toolbelt_comment_url_delete' );
