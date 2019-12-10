<?php
/**
 * Custom contact form
 *
 * Form validation uses Bouncer: @link https://github.com/cferdinandi/bouncer
 * Form design inspired by: @link https://adamsilver.io/articles/form-design-from-zero-to-hero-all-in-one-blog-post/
 *
 * @package toolbelt
 */

/**
 * Templates
 * ---
 * Project Quote Form
 * Blank Form
 * Competition form
 * Feedback form (with star rating)
 * template inspiration - https://www.typeform.com/templates/
 * Survey Form
 *
 * New Field Ideas
 * ---
 * Range slider
 * Number (with min and max values?)
 * Hidden field
 * Star rating
 * Country list
 *
 * Wishlist
 * ---
 * Stripe and Paypal support.
 * Add support for extra blocks inside contact form.
 * Drag and drop items in multi field?
 * custom post type to temporarily store contact form messages.
 * daily wp_cron to delete old contact form messages.
 * weekly wp_cron to report spam emails.
 * [shorttags] for subject line to add different properties from the form.
 */


/**
 * Block settings and admin properties.
 */
require 'module-admin.php';

/**
 * Contact form submission and sanitization.
 */
require 'module-submit-form.php';

/**
 * Block fields.
 */
require 'module-fields.php';

/**
 * Custom post type.
 */
require 'module-cpt.php';

/**
 * Cron job.
 */
require 'module-cron.php';

/**
 * Only include in the admin.
 * We don't want regular site visitors using this.
 */
if ( is_admin() ) {

	/**
	 * Admin ajax responses.
	 */
	require 'module-ajax.php';

}
