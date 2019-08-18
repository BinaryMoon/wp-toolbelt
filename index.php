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

// load_modules();

require TB_PATH . 'cookie-banner/index.php';

require TB_PATH . 'projects/index.php';
