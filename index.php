<?php
/**
 * Plugin Name: Toolbelt
 * Plugin URI: https://prothemedesign.com
 * Description: More features, fast.
 * Author: Ben Gillbanks
 * Version: 0.0.1
 * Author URI: https://prothemedesign.com
 *
 * @package tb
 */

define( 'TB_VERSION', '0.0.1' );
define( 'TB_PATH', plugin_dir_path( __FILE__ ) );

if ( is_admin() ) {

	require TB_PATH . 'admin/index.php';

}

function tb_load_modules() {

	$modules = array(
		'cookie-banner',
		'projects',
		'cleanup',
	);

	foreach ( $modules as $module ) {

		// if module active then load it.
		require TB_PATH . $module . '/index.php';

	}

}

add_action( 'init', 'tb_load_modules' );
