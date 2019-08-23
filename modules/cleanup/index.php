<?php
/**
 * Cleanup WordPress html.
 *
 * @package toolbelt
 */

define( 'DISABLE_NAG_NOTICES', true );

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

// Remove the next and previous post links.
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Remove the shortlink url from header.
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );

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
