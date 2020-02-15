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
function toolbelt_footnotes( $data ) {

	global $post;

	// Ensure post exists.
	if ( ! $post ) {
		return $data;
	}

	$search_string = '/(' . preg_quote( '((', '/' ) . ')(.*)(' . preg_quote( '))', '/' ) . ')/Us';

	// Regex extraction of all footnotes (or return if there are none).
	if ( ! preg_match_all( $search_string, $data, $identifiers, PREG_SET_ORDER ) ) {
		return $data;
	}

	// Should we display the footnotes or hide them?
	$display = true;
	if ( ! is_singular() ) {
		$display = false;
	}

	$footnotes = array();

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

		if ( ! isset( $identifiers[ $i ]['use_footnote'] ) ) {

			// Add footnote and record the key.
			$identifiers[ $i ]['use_footnote'] = count( $footnotes );
			$footnotes[ $identifiers[ $i ]['use_footnote'] ]['text'] = $identifiers[ $i ]['text'];
			$footnotes[ $identifiers[ $i ]['use_footnote'] ]['symbol'] = isset( $identifiers[ $i ]['symbol'] ) ? $identifiers[ $i ]['symbol'] : '';
			$footnotes[ $identifiers[ $i ]['use_footnote'] ]['identifiers'][] = $i;

		}
	}

	$use_full_link = false;

	if ( is_feed() ) {
		$use_full_link = true;
	}

	if ( is_preview() ) {
		$use_full_link = false;
	}

	// Display identifiers.
	foreach ( $identifiers as $key => $value ) {

		$id_id = 'identifier_' . $key . '_' . $post->ID;
		$id_num = $value['use_footnote'] + 1;
		$id_href = ( ( $use_full_link ) ? get_permalink( $post->ID ) : '' ) . '#footnote_' . $value['use_footnote'] . '_' . $post->ID;
		$id_title = str_replace( '"', '&quot;', htmlentities( html_entity_decode( wp_strip_all_tags( $value['text'] ), ENT_QUOTES, 'UTF-8' ), ENT_QUOTES, 'UTF-8' ) );

		if ( $display ) {
			$id_replace = '<sup><a href="' . $id_href . '" id="' . $id_id . '" class="footnote-link footnote-identifier-link" title="' . $id_title . '">(' . $id_num . ')</a></sup>';
		} else {
			$id_replace = '';
		}

		$data = substr_replace( $data, $id_replace, strpos( $data, $value[0] ), strlen( $value[0] ) );

	}

	// Display footnotes.
	if ( $display ) {

		$footnotes_markup = array();

		$footnotes_markup[] = '<ol class="footnotes">';

		foreach ( $footnotes as $key => $value ) {

			$content = $value['text'];

			/**
			 * Get a list of backlinks.
			 */
			$backlinks = array();

			foreach ( $value['identifiers'] as $identifier ) {

				$backlinks[] = sprintf(
					'(<a href="%1$s#identifier_%2$d_%3$d" class="footnote-link footnote-back-link">&#8617;</a>)',
					( ( $use_full_link ) ? get_permalink( $post->ID ) : '' ),
					$identifier,
					(int) $post->ID
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
				$post->ID,
				wp_kses_post( $content )
			);

		}

		$footnotes_markup[] = '</ol>';

		$data = $data . implode( '', $footnotes_markup );

	}

	return $data;

}

add_filter( 'the_content', 'toolbelt_footnotes', 5 );
