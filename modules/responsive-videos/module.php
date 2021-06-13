<?php
/**
 * Ensure embedded videos resize properly.
 *
 * @package toolbelt
 */

if ( is_admin() ) {
	return;
}

/**
 * Load the Responsive videos plugin.
 *
 * @return void
 */
function toolbelt_responsive_video_init() {

	// If the theme supports 'jetpack-responsive-videos', quit.
	if ( current_theme_supports( 'jetpack-responsive-videos' ) ) {
		return;
	}

	// Wrap the videos.
	add_filter( 'wp_video_shortcode', 'toolbelt_responsive_video_embed_html' );
	add_filter( 'video_embed_html', 'toolbelt_responsive_video_embed_html' );

	// Only wrap oEmbeds if video.
	add_filter( 'embed_oembed_html', 'toolbelt_responsive_video_maybe_wrap_oembed', 10, 2 );
	add_filter( 'embed_handler_html', 'toolbelt_responsive_video_maybe_wrap_oembed', 10, 2 );

	// Wrap videos in Buddypress.
	add_filter( 'bp_embed_oembed_html', 'toolbelt_responsive_video_embed_html' );

	// Wrap Slideshare shortcodes.
	add_filter( 'toolbelt_slideshare_shortcode', 'toolbelt_responsive_video_embed_html' );

	add_filter( 'wp_head', 'toolbelt_responsive_video_styles' );

	// Remove the responsive video wrapper in embed blocks on sites that use core responsive embeds.
	if ( current_theme_supports( 'responsive-embeds' ) ) {
		add_filter( 'render_block', 'toolbelt_responsive_video_remove_wrap_oembed', 10, 2 );
	}

}

add_action( 'after_setup_theme', 'toolbelt_responsive_video_init', 99 );


/**
 * Add the toolbelt video styles.
 *
 * @return void
 */
function toolbelt_responsive_video_styles() {

	toolbelt_styles( 'responsive-videos' );

}


/**
 * Adds a wrapper to videos.
 *
 * @param string $html The video embed html to wrap.
 * @return string
 */
function toolbelt_responsive_video_embed_html( $html ) {

	if ( empty( $html ) || ! is_string( $html ) ) {
		return $html;
	}

	/**
	 * The customizer video widget wraps videos with a class of wp-video.
	 * mejs as of 4.9 resizes videos too which causes issues skip the video if
	 * it is wrapped in wp-video.
	 */
	$video_widget_wrapper = 'class="wp-video"';
	$mejs_wrapped = strpos( $html, $video_widget_wrapper );

	// If this is a video widget wrapped by mejs, return the html.
	if ( false !== $mejs_wrapped ) {
		return $html;
	}

	// Enqueue CSS to ensure compatibility with all themes.
	return '<div class="toolbelt-video-wrapper">' . $html . '</div>';

}


/**
 * Check if oEmbed is a `$video_patterns` provider video before wrapping.
 *
 * @param mixed  $html The cached HTML result, stored in post meta.
 * @param string $url  he attempted embed URL.
 * @return string
 */
function toolbelt_responsive_video_maybe_wrap_oembed( $html, $url = null ) {

	if ( empty( $html ) || ! is_string( $html ) || ! $url ) {
		return $html;
	}

	$toolbelt_video_wrapper = '<div class="toolbelt-video-wrapper">';
	$already_wrapped = strpos( $html, $toolbelt_video_wrapper );

	// If the oEmbed has already been wrapped, return the html.
	if ( false !== $already_wrapped ) {
		return $html;
	}

	/**
	 * OEmbed Video Providers.
	 *
	 * An allowed list of oEmbed video provider Regex patterns to check against
	 * before wrapping the output.
	 */
	$video_patterns = apply_filters(
		'toolbelt_responsive_videos_oembed_videos',
		array(
			'https?://((m|www)\.)?youtube\.com/watch',
			'https?://((m|www)\.)?youtube\.com/playlist',
			'https?://youtu\.be/',
			'https?://(.+\.)?vimeo\.com/',
			'https?://(www\.)?dailymotion\.com/',
			'https?://dai.ly/',
			'https?://(www\.)?hulu\.com/watch/',
			'https?://wordpress.tv/',
			'https?://(www\.)?funnyordie\.com/videos/',
			'https?://vine.co/v/',
			'https?://(www\.)?collegehumor\.com/video/',
			'https?://(www\.|embed\.)?ted\.com/talks/',
		)
	);

	// Merge patterns to run in a single preg_match call.
	$video_patterns = '(' . implode( '|', $video_patterns ) . ')';
	$is_video = preg_match( $video_patterns, $url );

	// If the oEmbed is a video, wrap it in the responsive wrapper.
	if ( false === $already_wrapped && 1 === $is_video ) {
		return toolbelt_responsive_video_embed_html( $html );
	}

	return $html;

}


/**
 * Remove the responsive video wrapper in embed blocks.
 *
 * @param string       $block_content The block content about to be appended.
 * @param array<mixed> $block         The full block, including name and attributes.
 * @return string $block_content String of rendered HTML.
 */
function toolbelt_responsive_video_remove_wrap_oembed( $block_content = '', $block = array() ) {

	if ( isset( $block['blockName'] ) && false !== strpos( $block['blockName'], 'core-embed' ) ) {
		$block_content = (string) preg_replace( '#<div class="toolbelt-video-wrapper">(.*?)</div>#', '${1}', $block_content );
	}

	return $block_content;

}
