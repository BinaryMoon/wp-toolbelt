<?php
/**
 * Content of the Toolbelt settings page.
 *
 * @package toolbelt
 */

/**
 * Run module settings specific actions.
 */
do_action( 'toolbelt_module_settings' );

?>

<style>
	.column-weight { width: 25%; }
	p.search-box { float: none; }
	.search-box input[name="s"] { width: 100%; font-size: 18px; height: 40px; margin-bottom: 30px; }
	td p.doc-link { margin-bottom: 0; }
	td p.doc-link a + a { margin: 0 0.5em; }
	.wrap { max-width: 600px; margin: 0 auto; }
	.experimental { color: red; }
	p.gdpr-hard-mode { color: grey; font-weight: bold; }
	p.warning { color: red; }
	p.warning strong { background: red; color: white; border-radius: 2px; padding: 0.1em 0.4em; margin-inline-end: 0.4em; }
</style>

<script>
function toolbeltFilterModules() {

	// Declare variables
	var input = document.getElementById( 'toolbelt-search-input' );
	var filter = input.value.toUpperCase();
	var tr = document.querySelectorAll( '#toolbelt-modules-table tbody tr' );
	var txtValue = '';

	// Loop through all table rows, and hide those that don't match the search query
	for ( var row = 0; row < tr.length; row ++ ) {

		txtValue = '';

		var paragraphlist = tr[row].getElementsByTagName( 'td' )[0].getElementsByTagName( 'p' );

		for ( var paragraph = 0; paragraph < paragraphlist.length; paragraph ++ ) {
			txtValue += ' ' + ( paragraphlist[paragraph].textContent || paragraphlist[paragraph].innerText );
		}

		if ( txtValue ) {
			if ( txtValue.toUpperCase().indexOf( filter ) > -1 ) {
				tr[row].style.display = '';
			} else {
				tr[row].style.display = 'none';
			}
		}
	}
}
</script>

<div class="wrap">

	<h1 class="wp-heading-inline"><?php esc_html_e( 'Toolbelt Modules', 'wp-toolbelt' ); ?></h1>

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->

	<form action="" method="POST">

		<p class="search-box">
			<label class="screen-reader-text" for="toolbelt-search-input"><?php esc_html_e( 'Search for Modules', 'wp-toolbelt' ); ?></label>
			<input type="search" id="toolbelt-search-input" onkeyup="toolbeltFilterModules()" class="wp-filter-search" name="s" value="" placeholder="<?php esc_attr_e( 'Search for Modules...', 'wp-toolbelt' ); ?>" />
		</p>

		<?php wp_nonce_field( 'toolbelt_modules' ); ?>
		<?php submit_button( esc_html__( 'Save Modules', 'wp-toolbelt' ) ); ?>

		<table class="wp-list-table widefat fixed striped" id="toolbelt-modules-table">
			<thead>
				<tr>
					<td class="manage-column column-cb check-column">
						<input type="checkbox" name="check_all" <?php checked( toolbelt_admin_all_modules_enabled() ); ?> />
					</td>
					<th class="column-title column-primary">
						<?php esc_html_e( 'Module', 'wp-toolbelt' ); ?>
					</th>
					<th class="column-weight">
						<?php esc_html_e( 'Page Impact', 'wp-toolbelt' ); ?>
					</th>
				</tr>
			</thead>

<?php

	$modules = toolbelt_get_modules();

	foreach ( $modules as $slug => $module ) {
		toolbelt_field(
			$slug,
			$module
		);
	}

?>

		</table>

		<?php submit_button( esc_html__( 'Save Modules', 'wp-toolbelt' ) ); ?>

	</form>

	<?php require 'admin-credits.php'; ?>

</div>
