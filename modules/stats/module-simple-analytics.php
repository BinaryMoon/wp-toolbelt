<?php
/**
 * Simple Analytics
 *
 * @package toolbelt
 */

/**
 * Display the Simple Analytics tracking code.
 *
 * @see https://docs.simpleanalytics.com/script
 */
function toolbelt_stats_simple_analytics() {

?>

<script async defer src="https://cdn.simpleanalytics.io/hello.js"></script> <?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript ?>
<noscript><img src="https://api.simpleanalytics.io/hello.gif" alt=""></noscript>

<?php

}

add_action( 'wp_head', 'toolbelt_stats_simple_analytics' );
