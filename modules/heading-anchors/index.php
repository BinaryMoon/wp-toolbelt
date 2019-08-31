<?php
/**
 * Link headings.
 *
 * @package toolbelt
 */

/**
 *
 */
function toolbelt_heading_anchors( $content ) {

	if ( ! is_singular() || ! is_main_query() ) {

		return $content;

	}

	$doc = new DOMDocument();
	$dom_content = $doc->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES' ) );

	if ( false === $dom_content ) {

		return $content;

	}

	$doc = toolbelt_heading_ids( $doc, 'h1' );
	$doc = toolbelt_heading_ids( $doc, 'h2' );
	$doc = toolbelt_heading_ids( $doc, 'h3' );
	$doc = toolbelt_heading_ids( $doc, 'h4' );

	toolbelt_styles( 'heading-anchors' );

	return wp_kses_post( $doc->saveHTML() );;

}

add_filter( 'the_content', 'toolbelt_heading_anchors' );


function toolbelt_heading_ids( $doc, $tag ) {

	$elements = $doc->getElementsByTagName( $tag );

	if ( ! $elements ) {
		return $doc;
	}

	foreach ( $elements as $el ) {

		// Add an id to use as the anchor.
		$slug = sanitize_title( $el->nodeValue );
		$el->setAttribute( 'id', $slug );

		// Set class so we can style it nicely.
		$element_class = $el->getAttribute( 'class' ) . ' toolbelt-anchor';
		$el->setAttribute( 'class', trim( $element_class ) );

		// Add a link element.
		$link = $doc->createElement( 'a', '#' );
		$link->setAttribute( 'class', 'toolbelt-link' );
		$link->setAttribute( 'href', '#' . $slug );
		$link->setAttribute( 'aria-hidden', 'true' );
		$el->appendChild( $link );

	}

	return $doc;

}
