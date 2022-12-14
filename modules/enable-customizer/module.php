<?php
/**
 * Force the Customizer to be enabled.
 *
 * @package toolbelt
 */


/**
 * Register a dummy control.
 * This forces the customizer to display.
 *
 * @see https://twitter.com/pixolin/status/1484825348437164035/photo/1
 *
 * @return void
 */
function toolbelt_enable_customizer_register( $wp_customize ) {

	$wp_customize->add_control( 'toolbelt-placeholder', array() );

}

add_action( 'customize_register', 'toolbelt_enable_customizer_register' );
