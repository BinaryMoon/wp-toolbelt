<?php
/**
 * Display footnotes for a blog post.
 *
 * @package toolbelt
 */

/**
 * Parse the post content and display footnotes
 *
 * @param string $data The post data to look through.
 * @return string
 */
function toolbelt_footnotes( $data = '' ) {

	// Regex to find all footnotes in the post content.
	$search_string = '/(' . preg_quote( '((', '/' ) . ')(.*)(' . preg_quote( '))', '/' ) . ')/Us';

	// Extract all footnotes or return if there are none.
	if ( ! preg_match_all( $search_string, $data, $identifiers, PREG_SET_ORDER ) ) {
		return $data;
	}

	// Store processed footnote data.
	$footnotes = array();

	// The number of found footnotes.
	$identifier_count = count( $identifiers );

	for ( $i = 0; $i < $identifier_count; $i++ ) {

		$identifiers[ $i ]['text'] = $identifiers[ $i ][2];

		// If we're combining identical notes check if we've already got one like this & record keys.
		$footnote_count = count( $footnotes );

		for ( $j = 0; $j < $footnote_count; $j++ ) {

			if ( $footnotes[ $j ]['text'] === $identifiers[ $i ]['text'] ) {

				$identifiers[ $i ]['use_footnote'] = $j;
				$footnotes[ $j ]['identifiers'][] = $i;
				break;

			}

		}

		/**
		 * If the footnote is not already set (is not a duplicate) then save the
		 * footnote info.
		 */
		if ( ! isset( $identifiers[ $i ]['use_footnote'] ) ) {

			// Add footnote and record the key.
			$identifiers[ $i ]['use_footnote'] = count( $footnotes );
			$footnotes[ $identifiers[ $i ]['use_footnote'] ]['text'] = $identifiers[ $i ]['text'];
			$footnotes[ $identifiers[ $i ]['use_footnote'] ]['symbol'] = isset( $identifiers[ $i ]['symbol'] ) ? $identifiers[ $i ]['symbol'] : '';
			$footnotes[ $identifiers[ $i ]['use_footnote'] ]['identifiers'][] = $i;

		}
	}

	/**
	 * We've processed the footnotes now.
	 * Next we need to display them.
	 */

	// Should we display the full page link, or just the anchor link?
	$use_full_link = false;

	if ( is_feed() ) {
		$use_full_link = true;
	}

	if ( is_preview() ) {
		$use_full_link = false;
	}

	// Get the post/ page url.
	$permalink = '';
	$post_id = (int) get_the_ID();

	if ( $use_full_link && $post_id ) {
		$permalink = get_permalink( $post_id );
	}

	// Should we display the footnotes or hide them?
	$display = true;
	if ( ! is_singular() && $post_id ) {
		$display = false;
	}

	/**
	 * Display links to footnotes in post content.
	 */
	foreach ( $identifiers as $key => $value ) {

		$id_replace = '';

		if ( $display ) {

			$id_replace = sprintf(
				'<sup><a href="%1$s" id="%2$s" class="footnote-link footnote-identifier-link" title="%3$s">(%4$d)</a></sup>',
				$permalink . '#footnote_' . $value['use_footnote'] . '_' . $post_id,
				'identifier_' . $key . '_' . $post_id,
				str_replace( '"', '&quot;', htmlentities( html_entity_decode( wp_strip_all_tags( $value['text'] ), ENT_QUOTES, 'UTF-8' ), ENT_QUOTES, 'UTF-8' ) ),
				$value['use_footnote'] + 1
			);

		}

		$data = substr_replace( $data, $id_replace, strpos( $data, $value[0] ), strlen( $value[0] ) );

	}

	/**
	 * Generate footnote markup to display at the end of the post.
	 */
	if ( $display ) {

		$footnotes_markup = array();

		$footnotes_markup[] = '<h3 class="toolbelt-heading toolbelt-heading-footnotes">' . esc_html__( 'Footnotes', 'wp-toolbelt' ) . '</h3>';

		$footnotes_markup[] = '<ol class="toolbelt-footnotes">';

		foreach ( $footnotes as $key => $value ) {

			$content = $value['text'];

			/**
			 * Get a list of backlinks.
			 */
			$backlinks = array();

			foreach ( $value['identifiers'] as $identifier ) {

				$backlinks[] = sprintf(
					'(<a href="%1$s#identifier_%2$d_%3$d" class="footnote-link footnote-back-link">&#8617;</a>)',
					$permalink,
					$identifier,
					$post_id
				);

			}

			if ( count( $backlinks ) > 0 ) {

				$content = $content . ' ' . sprintf(
					'<span class="backlink-container">%1$s</span>',
					implode( ' ', $backlinks )
				);

			}

			/**
			 * Generate the actual footnote.
			 */
			$footnotes_markup[] = sprintf(
				'<li id="footnote_%1$d_%2$d">%3$s</li>',
				(int) $key,
				$post_id,
				wp_kses_post( $content )
			);

		}

		$footnotes_markup[] = '</ol>';

		$data = $data . implode( '', $footnotes_markup );

	}

	return $data;

}

add_filter( 'the_content', 'toolbelt_footnotes', 5 );
