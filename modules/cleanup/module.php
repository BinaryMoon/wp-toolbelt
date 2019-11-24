<?php
/**
 * Cleanup WordPress html.
 *
 * @package toolbelt
 */

/**
 * Disable nag notices.
 * Make sure they aren't already defined!
 */
if ( ! defined( 'DISABLE_NAG_NOTICES' ) ) {
	define( 'DISABLE_NAG_NOTICES', true );
}

// Remove really simple discovery link.
remove_action( 'wp_head', 'rsd_link' );

// Remove wlwmanifest.xml (needed to support windows live writer).
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove generator tag from RSS feeds.
remove_action( 'atom_head', 'the_generator' );
remove_action( 'comments_atom_head', 'the_generator' );
remove_action( 'rss_head', 'the_generator' );
remove_action( 'rss2_head', 'the_generator' );
remove_action( 'commentsrss2_head', 'the_generator' );
remove_action( 'rdf_header', 'the_generator' );
remove_action( 'opml_head', 'the_generator' );
remove_action( 'app_head', 'the_generator' );
add_filter( 'the_generator', '__return_false' );

// Remove the next and previous post links.
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

// Remove the shortlink url from header.
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

// Remove WordPress generator version.
remove_action( 'wp_head', 'wp_generator' );

// Remove the annoying:
// <style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>.
add_filter( 'show_recent_comments_widget_style', '__return_false' );

// Remove emoji styles and script from header.
if ( is_admin() ) {

	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter(
		'tiny_mce_plugins',
		function( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
			}
			return array();
		}
	);

} else {

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	add_filter( 'emoji_svg_url', '__return_false' );

	add_filter(
		'xmlrpc_methods',
		function( $methods ) {

			unset( $methods['pingback.ping'] );
			return $methods;

		}
	);

}

// Slow down the default heartbeat.
add_filter(
	'heartbeat_settings',
	function ( $settings ) {
		// 60 seconds.
		$settings['interval'] = 60;
		return $settings;
	}
);


// Remove self pings.
add_action(
	'pre_ping',
	function( &$links ) {
		$home = get_option( 'home' );
		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, $home ) ) {
				unset( $links[ $l ] );
			}
		}
	}
);

// Remove dashicons in customize preview and when the adminbar is hidden.
add_action(
	'wp_print_styles',
	function() {
		if ( ! is_admin_bar_showing() && ! is_customize_preview() ) {
			wp_deregister_style( 'dashicons' );
		}
	},
	100
);

// Remove jQuery Migrate.
add_action(
	'wp_default_scripts',
	function( $scripts ) {
		if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
			$jquery_dependencies = $scripts->registered['jquery']->deps;
			$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
		}
	}
);
