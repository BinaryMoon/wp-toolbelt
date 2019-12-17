<?php
/**
 * Contact Form Cron Jobs.
 *
 * @package wp-toolbelt
 */

/**
 * Delete old posts.
 * This is called on a cron job.
 *
 * @return void
 */
function toolbelt_contact_cron_clean_posts() {

	$delete_posts = array_merge(
		toolbelt_contact_clean_posts( 'spam', 30 ),
		toolbelt_contact_clean_posts( 'publish', 90 )
	);

	foreach ( $delete_posts as $post_id ) {

		wp_trash_post( (int) $post_id );

	}

}

add_action( 'toolbelt_cron_daily', 'toolbelt_contact_cron_clean_posts' );


/**
 * Get the post ids for old contact posts that we should delete.
 *
 * @param string $status The post status to delete.
 * @param int    $duration The age of the posts.
 * @return array<int>
 */
function toolbelt_contact_clean_posts( $status = 'spam', $duration = 30 ) {

	global $wpdb;

	return $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts}
			WHERE `post_type` = 'feedback'
			AND `post_status` = %s
			AND DATE_SUB( NOW(), INTERVAL %d DAY ) > `post_date_gmt` LIMIT 100",
			$status,
			$duration
		)
	);

}
