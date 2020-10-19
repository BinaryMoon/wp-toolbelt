<?php
/**
 * Jetpack stubs for functions I use.
 *
 * @see https://github.com/Automattic/jetpack/blob/d7e15e38382868f870024c0831f56ddc733c83c8/functions.photon.php#L13
 * @package jetpack
 */

/**
 * Generates a Photon URL.
 *
 * @see https://developer.wordpress.com/docs/photon/
 *
 * @param string              $image_url URL to the publicly accessible image you want to manipulate.
 * @param array<mixed>|string $args An array of arguments, i.e. array( 'w' => '300', 'resize' => array( 123, 456 ) ), or in string form (w=123&h=456).
 * @param string|null         $scheme URL protocol.
 * @return string The raw final URL. You should run this through esc_url() before displaying it.
 */
function jetpack_photon_url( $image_url, $args = array(), $scheme = null ) {
	return $image_url;
}
