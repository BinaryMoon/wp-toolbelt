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
	.column-title { width: 20%; }
	.column-weight { width: 25%; }
	p.search-box { float: none; }
	.search-box input[name="s"] { width: 100%; font-size: 18px; height: 40px; margin-bottom: 15px; }
	td p.doc-link { margin-bottom: 0; }
	td p.doc-link a + a { margin: 0 0.5em; }
</style>

<script>
function toolbeltFilterModules() {

	// Declare variables
	var input = document.getElementById( 'toolbelt-search-input' );
	var filter = input.value.toUpperCase();
	var tr = document.querySelectorAll( 'tbody tr' );
	var txtValue = '';

	// Loop through all table rows, and hide those that don't match the search query
	for ( i = 0; i < tr.length; i++ ) {

		txtValue = '';

		td = tr[i].getElementsByTagName( 'td' )[0].getElementsByTagName( 'strong' )[0];
		txtValue += ' ' + ( td.textContent || td.innerText );

		td = tr[i].getElementsByTagName( 'td' )[1].getElementsByTagName( 'p' )[0];
		txtValue += ' ' + ( td.textContent || td.innerText );

		if ( txtValue ) {
			if ( txtValue.toUpperCase().indexOf( filter ) > -1 ) {
				tr[i].style.display = '';
			} else {
				tr[i].style.display = 'none';
			}
		}
	}
}
</script>

<div class="wrap about-wrap full-width-layout">

	<div class="wp-header-end"></div><!-- admin notices go after .wp-header-end or .wrap>h2:first-child -->
	<h1><?php esc_html_e( 'Toolbelt', 'wp-toolbelt' ); ?></h1>

	<div class="about-text"><?php esc_html_e( 'Toolbelt is a lightweight, privacy focused, collection of things that add commonly needed features to your WordPress website.', 'wp-toolbelt' ); ?></div>

	<form action="" method="POST">

		<p class="search-box">
			<label class="screen-reader-text" for="toolbelt-search-input"><?php esc_html_e( 'Search for Modules', 'wp-toolbelt' ); ?></label>
			<input type="search" id="toolbelt-search-input" onkeyup="toolbeltFilterModules()" class="wp-filter-search" name="s" value="" placeholder="<?php esc_attr_e( 'Search for Modules...', 'wp-toolbelt' ); ?>" />
		</p>

		<?php wp_nonce_field( 'toolbelt_modules' ); ?>

		<table class="wp-list-table widefat fixed striped" id="toolbelt-modules-table">
			<thead>
				<tr>
					<td class="manage-column column-cb check-column">
						<input type="checkbox" name="check_all" <?php checked( toolbelt_admin_all_modules_enabled() ); ?> />
					</td>
					<th class="column-title column-primary">
						<?php esc_html_e( 'Module', 'wp-toolbelt' ); ?>
					</th>
					<th>
						<?php esc_html_e( 'Description', 'wp-toolbelt' ); ?>
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

		<?php submit_button( esc_html__( 'Save Settings', 'wp-toolbelt' ) ); ?>

	</form>

</div>
