<?php
/**
 * Social sharing links.
 *
 * @package toolbelt
 */

// Don't display in the WordPress admin.
if ( is_admin() ) {
	return;
}


/**
 * Add social sharing buttons to the post content.
 *
 * @param string $content The post content to append the sharing option to.
 *
 * @return string The post content with the sharing options appended.
 */
function toolbelt_social_sharing( $content ) {

	$post_types = apply_filters(
		'toolbelt_social_sharing_post_types',
		array( 'post' )
	);

	/**
	 * Not a singular post type of any sort so let's quit.
	 */
	if ( ! is_singular( $post_types ) ) {
		return $content;
	}

	// If a password is required then don't add this stuff.
	if ( post_password_required() ) {
		return $content;
	}

	/**
	 * Check a filter to see if we should quit.
	 *
	 * By default will return if it's not a blog post.
	 * You can change this with the filter.
	 */
	if ( ! apply_filters( 'toolbelt_display_social_sharing', true ) ) {
		return $content;
	}

	toolbelt_styles( 'social-sharing' );

	$html = '';

	// Get the canonical link for the blog post.
	// Fallback to the permalink.
	$canonical = wp_get_canonical_url();

	if ( ! $canonical ) {
		$canonical = get_permalink();
	}

	/**
	 * Let's build it ourselves from the server information.
	 */
	if ( ! $canonical ) {

		$server = wp_unslash( $_SERVER );

		if ( is_array( $server ) ) {

			$https = 'http';
			if ( isset( $server['HTTPS'] ) ) {
				if ( 'on' === $server['HTTPS'] ) {
					$https = 'https';
				}
			}

			/**
			 * Ignore input sanitization since the generated url will be escaped
			 * immediately after.
			 */
			if ( isset( $server['HTTP_HOST'] ) && isset( $server['REQUEST_URI'] ) ) {
				$canonical = $https . '://' . $server['HTTP_HOST'] . $server['REQUEST_URI']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			}
		}
	}

	/**
	 * There's no url so let's quit.
	 *
	 * This can happen in some places such as buddypress where some pages are
	 * created virtually and don't have a linkable url.
	 */
	if ( empty( $canonical ) ) {
		return $content;
	}

	/**
	 * Escape the url. Particularly important for urls that have been generated
	 * from the $_SERVER properties.
	 */
	$canonical = esc_url( (string) $canonical );

	// Display a list of social networks.
	$networks = toolbelt_social_networks();

	foreach ( $networks as $slug => $network ) {

		$url  = sprintf( $network['url'], rawurlencode( $canonical ) );

		// Load icon.
		$svg = file_get_contents( TOOLBELT_PATH . 'svg/' . $slug . '.svg' );
		$svg = str_replace( '<svg', '<svg aria-hidden="true" role="img"', $svg );

		// Generate HTML.
		$html .= sprintf(
			'<a href="%1$s" title="%2$s" class="%3$s" target="_blank" rel="nofollow" style="background-color:#%6$s">%4$s <span>%5$s</span></a>' . "\n",
			esc_url( $url ),
			esc_attr( $network['title'] ),
			'toolbelt_' . esc_attr( $slug ),
			$svg,
			esc_html( $network['label'] ),
			esc_attr( $network['color'] )
		);

	}

	return $content . '<section class="toolbelt_social_share toolbelt-social-share">' . $html . '</section>';

}

add_filter( 'the_content', 'toolbelt_social_sharing', 99 );


/**
 * Get the list of social networks and their properties.
 *
 * @see https://github.com/bradvin/social-share-urls
 *
 * @return array<mixed>
 */
function toolbelt_social_networks_get() {

	return array(
		'facebook'  => array(
			'title' => esc_html__( 'Share on Facebook', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Facebook button label', 'wp-toolbelt' ),
			'url'   => 'https://facebook.com/sharer/sharer.php?u=%s',
			'color' => '3b5998',
		),
		'twitter'   => array(
			'title' => esc_html__( 'Tweet on Twitter', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Tweet this', 'Twitter button label', 'wp-toolbelt' ),
			'url'   => 'https://twitter.com/intent/tweet?url=%s',
			'color' => '1da1f2',
		),
		'linkedin'  => array(
			'title' => esc_html__( 'Share on LinkedIn', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'LinkedIn button label', 'wp-toolbelt' ),
			'url'   => 'https://www.linkedin.com/shareArticle?mini=true&url=%s',
			'color' => '0077b5',
		),
		/**
		 * Share Whatsapp
		 *
		 * According to the documentation the link should be:
		 * 'https://wa.me/?text=%s'
		 * This link works on desktop but not on mobile.
		 *
		 * The docs can be seen here:
		 * https://faq.whatsapp.com/en/android/26000030/
		 */
		'whatsapp'  => array(
			'title' => esc_html__( 'Share on WhatsApp', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'WhatsApp button label', 'wp-toolbelt' ),
			'url'   => 'https://api.whatsapp.com/send?text=%s',
			'note'  => esc_html__( 'Only shown on mobile', 'wp-toolbelt' ),
			'color' => '075e54',
		),
		'pinterest' => array(
			'title' => esc_html__( 'Pin on Pinterest', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Pin this', 'Pinterest button label', 'wp-toolbelt' ),
			'url'   => 'https://pinterest.com/pin/create/button/?url=%s',
			'color' => 'bd081c',
		),
		'pocket'    => array(
			'title' => esc_html__( 'Save to Pocket', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Save this', 'Pocket button label', 'wp-toolbelt' ),
			'url'   => 'https://getpocket.com/save?url=%s',
			'color' => 'ef4056',
		),
		'wallabag'  => array(
			'title' => esc_html__( 'Save to Wallabag', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Save this', 'Wallabag button label', 'wp-toolbelt' ),
			'url'   => 'https://app.wallabag.it/bookmarklet?url=%s',
			'color' => '26a69a',
		),
		'instapaper' => array(
			'title' => esc_html__( 'Save to Instapaper', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Save this', 'Instapaper button label', 'wp-toolbelt' ),
			'url'   => 'http://www.instapaper.com/edit?url=%s',
			'color' => '000000',
		),
		'reddit'    => array(
			'title' => esc_html__( 'Share on Reddit', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Reddit button label', 'wp-toolbelt' ),
			'url'   => 'https://reddit.com/submit?url=%s',
			'color' => 'ff4500',
		),
		'tumblr' => array(
			'title' => esc_html__( 'Share on Tumblr', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Tumblr button label', 'wp-toolbelt' ),
			'url'   => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=%s',
			'color' => '35465c',
		),
		'hackernews' => array(
			'title' => esc_html__( 'Share on HackerNews', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'HackerNews button label', 'wp-toolbelt' ),
			'url'   => 'https://news.ycombinator.com/submitlink?u=%s',
			'color' => 'ff4000',
		),
		'evernote' => array(
			'title' => esc_html__( 'Share on Evernote', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Evernote button label', 'wp-toolbelt' ),
			'url'   => 'https://www.evernote.com/clip.action?url=%s',
			'color' => '2dbe60',
		),
		'flipboard' => array(
			'title' => esc_html__( 'Share on Flipboard', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Share this', 'Flipboard button label', 'wp-toolbelt' ),
			'url'   => 'https://share.flipboard.com/bookmarklet/popout?v=2&url=%s',
			'color' => 'e12828',
		),
		'email'     => array(
			'title' => esc_html__( 'Send via Email', 'wp-toolbelt' ),
			'label' => esc_html_x( 'Send this', 'Email button label', 'wp-toolbelt' ),
			'url'   => ' mailto:somebody@example.com?body=%s',
			'color' => '483d8b',
		),

	);

}


/**
 * Get a list of social networks and their sharing links.
 *
 * @return array<mixed>
 */
function toolbelt_social_networks() {

	// Get the plugin settings.
	$settings = get_option( 'toolbelt_settings', array() );

	// Turn the list of networks into an array.
	$enabled_networks = explode( '|', $settings['social-sharing'] );

	$desired_networks = apply_filters( 'toolbelt_social_networks', $enabled_networks );

	$networks = toolbelt_social_networks_get();

	$output = array();

	foreach ( $desired_networks as $item ) {
		if ( array_key_exists( $item, $networks ) ) {
			$output[ $item ] = $networks[ $item ];
		}
	}

	return $output;

}


/**
 * Set default social sharing options.
 *
 * @param array<mixed> $value The default settings option.
 * @return array<mixed>
 */
function toolbelt_social_sharing_default_settings( $value ) {

	if ( ! isset( $value['social-sharing'] ) ) {
		$value['social-sharing'] = implode(
			'|',
			array(
				'facebook',
				'twitter',
				'email',
			)
		);
	}

	return $value;

}

add_filter( 'option_toolbelt_settings', 'toolbelt_social_sharing_default_settings' );

