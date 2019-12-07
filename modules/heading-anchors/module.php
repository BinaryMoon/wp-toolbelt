<?php
/**
 * Link headings.
 *
 * @package toolbelt
 */

/**
 * Add heading anchors to the page/ post content.
 *
 * @param string $content The post content to add the anchors to.
 * @return string
 */
function toolbelt_heading_anchors( $content ) {

	// Only do it for the main post.
	if ( ! is_singular() || ! is_main_query() ) {

		return $content;

	}

	if ( ! apply_filters( 'toolbelt_heading_anchors_display', true ) ) {

		return $content;

	}

	$doc = new DOMDocument();

	/**
	 * DOMDocument::loadHTML does not really support HTML5 so I am silencing the
	 * errors it may generate based on content it doesn't understand.
	 *
	 * Not ideal but there doesn't seem to be a nice way to work around this
	 * beside using a different library, and I would rather not do that.
	 */
	$dom_content = @$doc->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES' ) ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

	if ( false === $dom_content ) {

		return $content;

	}

	$doc = toolbelt_heading_ids( $doc, 'h1' );
	$doc = toolbelt_heading_ids( $doc, 'h2' );
	$doc = toolbelt_heading_ids( $doc, 'h3' );
	$doc = toolbelt_heading_ids( $doc, 'h4' );

	toolbelt_styles( 'heading-anchors' );

	return $doc->saveHTML();

}

add_filter( 'the_content', 'toolbelt_heading_anchors', 9 );


/**
 * Add the anchors to the specified tag.
 *
 * @param DOMDocument $doc The DOMDocument object for the current page.
 * @param string      $tag The tag to search and add the anchor to.
 * @return DOMDocument The modified DOMDocument object.
 */
function toolbelt_heading_ids( $doc, $tag ) {

	$elements = $doc->getElementsByTagName( $tag );

	if ( $elements->length <= 0 ) {
		return $doc;
	}

	foreach ( $elements as $el ) {

		// Add an id to use as the anchor.
		$slug = sanitize_title( $el->nodeValue ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$el->setAttribute( 'id', $slug );

		// Set class so we can style it nicely.
		$element_class = $el->getAttribute( 'class' );

		if ( false === strpos( $element_class, 'toolbelt-skip-anchor' ) ) {

			$element_class .= ' toolbelt-anchor';
			$el->setAttribute( 'class', trim( $element_class ) );

			// Add a link element.
			$link = $doc->createElement( 'a', '#' );
			$link->setAttribute( 'class', 'toolbelt-link' );
			$link->setAttribute( 'href', '#' . $slug );
			$link->setAttribute( 'aria-hidden', 'true' );
			$el->appendChild( $link );

		}
	}

	return $doc;

}
