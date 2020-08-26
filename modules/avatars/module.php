<?php
/**
 * Avatars
 *
 * @package toolbelt
 */

/**
 * Generate the html for the avatars.
 *
 * @param string       $html The html for the avatar image.
 * @param mixed        $id_or_email The Gravatar to retrieve. Accepts a user_id, gravatar md5 hash, user email, WP_User object, WP_Post object, or WP_Comment object.
 * @param array<mixed> $args Avatar properties.
 * @return string
 */
function toolbelt_avatar_html( $html, $id_or_email, $args ) {

	if ( isset( $args['force_default'] ) && $args['force_default'] ) {
		return $html;
	}

	$email_hash = toolbelt_avatar_email_hash( $id_or_email );
	$email_hash = substr( $email_hash, 0, 15 );

	$class = '';
	if ( $args['class'] ) {
		$class = $args['class'];
	}

	$html = sprintf(
		'<canvas class="avatar toolbeltPixelAvatar %3$s" data-hash="%1$s"></canvas>',
		esc_attr( $email_hash ),
		(int) $args['size'],
		esc_attr( $class )
	);

	return $html;

}

add_filter( 'pre_get_avatar', 'toolbelt_avatar_html', 10, 3 );


/**
 * Output scripts and styles in the footer.
 * This needs to go on every page since `get_avatar` could be called anywhere.
 *
 * @return void
 */
function toolbelt_avatar_footer() {

	toolbelt_scripts( 'avatars', 'parts' );
	toolbelt_scripts( 'avatars' );
	toolbelt_styles( 'avatars' );

	if ( is_admin() ) {
		toolbelt_styles( 'avatars', 'admin' );
	}

?>
	<script>pixelGen.generateAllAvatars( '.toolbeltPixelAvatar' );</script>
<?php

}

add_action( 'wp_footer', 'toolbelt_avatar_footer' );
add_action( 'admin_footer', 'toolbelt_avatar_footer' );


/**
 * Calculate the email has for the specified user.
 *
 * This code is lifted from get_avatar_data()
 *
 * @see https://developer.wordpress.org/reference/functions/get_avatar_data/
 *
 * @param object|string $id_or_email Accepts a user ID, Gravatar MD5 hash, user email, WP_User object, WP_Post object, or WP_Comment object.
 * @return string
 */
function toolbelt_avatar_email_hash( $id_or_email ) {

	$email_hash = '';
	$user       = false;
	$email      = false;

	if ( is_object( $id_or_email ) && isset( $id_or_email->comment_ID ) ) {
		$id_or_email = get_comment( $id_or_email );
	}

	// Process the user identifier.
	if ( is_numeric( $id_or_email ) ) {
		$user = get_user_by( 'id', absint( $id_or_email ) );
	} elseif ( is_string( $id_or_email ) ) {
		if ( strpos( $id_or_email, '@md5.gravatar.com' ) ) {
			// MD5 hash.
			list( $email_hash ) = explode( '@', $id_or_email );
		} else {
			// Email address.
			$email = $id_or_email;
		}
	} elseif ( $id_or_email instanceof WP_User ) {
		// User object.
		$user = $id_or_email;
	} elseif ( $id_or_email instanceof WP_Post ) {
		// Post object.
		$user = get_user_by( 'id', (int) $id_or_email->post_author );
	} elseif ( $id_or_email instanceof WP_Comment ) {
		if ( ! is_avatar_comment_type( get_comment_type( $id_or_email ) ) ) {
			$args['url'] = false;
			/** This filter is documented in wp-includes/link-template.php */
			return apply_filters( 'get_avatar_data', $args, $id_or_email );
		}

		if ( ! empty( $id_or_email->user_id ) ) {
			$user = get_user_by( 'id', (int) $id_or_email->user_id );
		}
		if ( ! $user && ! empty( $id_or_email->comment_author_email ) ) {
			$email = $id_or_email->comment_author_email;
		}
	}

	if ( ! $email_hash ) {
		if ( $user ) {
			$email = $user->user_email;
		}

		if ( $email ) {
			$email_hash = md5( strtolower( trim( $email ) ) );
		}
	}

	return $email_hash;

}
