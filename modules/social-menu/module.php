<?php
/**
 * Social Menu
 *
 * @package toolbelt
 */

/**
 * Add the menu position.
 *
 * Normally I'd hook these into an action but since this file is included in
 * the after_setup_theme action I'm calling it directly.
 */
register_nav_menu( 'toolbelt-social', esc_html__( 'Social Menu', 'wp-toolbelt' ) );


/**
 * Display the social menu.
 */
function toolbelt_social_menu() {

	// There's no menu so quit.
	if ( ! has_nav_menu( 'toolbelt-social' ) ) {
		return;
	}

	toolbelt_styles( 'social-menu' );

?>

<nav class="toolbelt-menu-social" aria-label="<?php esc_attr_e( 'Social Menu', 'wp-toolbelt' ); ?>">

<?php

	wp_nav_menu(
		array(
			'theme_location' => 'toolbelt-social',
			'container' => false,
			'item_spacing' => 'discard',
			'fallback_cb' => false,
			'depth' => 1,
			'link_before' => '<span class="screen-reader-text">',
			'link_after' => '</span>' . toolbelt_social_menu_svg( 'share' ),
		)
	);

?>

</nav>

<?php

}


/**
 * Embed an svg directly into the webpage.
 *
 * @param string $key The key for the svg file. This is the filename without the .svg.
 * @return string
 */
function toolbelt_social_menu_svg( $key ) {

	$file_path = TOOLBELT_PATH . 'svg/' . $key . '.svg';

	return (string) file_get_contents( $file_path );

}


/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function toolbelt_social_menu_icons() {

	$social_links_icons = array(
		'behance.net'     => 'behance',
		'deviantart.com'  => 'deviantart',
		'dribbble.com'    => 'dribbble',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'email',
		'medium.com'      => 'medium',
		'pinterest.com'   => 'pinterest',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'snapchat.com'    => 'snapchat',
		'soundcloud.com'  => 'soundcloud',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'youtube.com'     => 'youtube',
	);

	return apply_filters( 'toolbelt_social_menu_icons', $social_links_icons );

}


/**
 * Display SVG icons in social navigation.
 *
 * @since 1.0.0
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  object  $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function toolbelt_social_menu_nav_menu_icons( $item_output, $item, $depth, $args ) {

	// Quit early if it's the wrong menu.
	if ( 'toolbelt-social' !== $args->theme_location ) {
		return $item_output;
	}

	// Get supported social icons.
	$social_icons = toolbelt_social_menu_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	foreach ( $social_icons as $attr => $value ) {
		if ( false !== strpos( $item_output, $attr ) ) {
			$item_output = str_replace( $args->link_after, '</span>' . toolbelt_social_menu_svg( $value ), $item_output );
		}
	}

	return $item_output;

}

add_filter( 'walker_nav_menu_start_el', 'toolbelt_social_menu_nav_menu_icons', 10, 4 );
