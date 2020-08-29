<?php
/**
 * Star Rating Render related functions.
 *
 * All the stuff for the front end.
 *
 * @package toolbelt
 */

/**
 * Render the block on the front end.
 *
 * @param array<string> $attributes The block attributes.
 * @return string
 */
function toolbelt_star_rating_render_block( $attributes ) {

	$classname = empty( $attributes['className'] ) ? '' : ' ' . $attributes['className'];

	$rating_text = sprintf(
		// translators: %1$s is awarded rating score, %2$s is the best possible rating.
		esc_html__( 'Rating %1$s out of %2$s', 'wp-toolbelt' ),
		esc_attr( $attributes['rating'] ),
		esc_attr( $attributes['maxRating'] )
	);

	$rating_value = sprintf(
		'<span itemprop="ratingValue" class="screen-reader-text" content="%1$s"> %2$s </span>',
		esc_attr( $attributes['rating'] ),
		esc_html( $rating_text )
	);

	return sprintf(
		'<a href="%5$s" title="%6$s" class="%1$s" style="text-align:%4$s" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">%2$s%3$s</a>',
		esc_attr( 'wp-block-toolbelt-star-rating ' . $classname ),
		toolbelt_star_rating_get_symbols( $attributes ),
		$rating_value,
		( isset( $attributes['align'] ) ) ? esc_attr( $attributes['align'] ) : '',
		esc_url( site_url( '/?s=' . rawurlencode( $rating_text ) ) ),
		esc_attr__( 'Search for content with this rating.', 'wp-toolbelt' )
	);

}


/**
 * Returns the low fidelity symbol for the block.
 *
 * @return string
 */
function toolbelt_star_rating_get_symbol_low_fidelity() {

	return '<span aria-hidden="true">⭐</span>';

}


/**
 * Return the high fidelity symbol for the block.
 *
 * @param string $classname_whole Name of the whole symbol class.
 * @param string $classname_half Name of the half symbol class.
 * @param string $color Color of the block.
 * @return string
 */
function toolbelt_star_rating_star_get_symbol_high_fidelity( $classname_whole, $classname_half, $color ) {

	return <<<ELO
<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path class="{$classname_whole}" fill="{$color}" stroke="{$color}" d="M12,17.3l6.2,3.7l-1.6-7L22,9.2l-7.2-0.6L12,2L9.2,8.6L2,9.2L7.5,14l-1.6,7L12,17.3z" />
</svg></span>
<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path class="{$classname_half}" fill="{$color}" stroke="{$color}" d="M12,17.3l6.2,3.7l-1.6-7L22,9.2l-7.2-0.6L12,2L9.2,8.6L2,9.2L7.5,14l-1.6,7L12,17.3z" />
</svg></span>
ELO;

}



/**
 * Returns the high fidelity symbol for the block.
 *
 * @param array<int|string> $attributes Array containing the block attributes.
 * @param integer           $pos Value to render whole and half symbols.
 * @return string
 */
function toolbelt_star_rating_get_symbol_high_fidelity( $attributes, $pos ) {

	$classname_whole = ( $attributes['rating'] >= ( $pos - 0.5 ) ) ? '' : 'is-rating-unfilled';
	$classname_half = ( $attributes['rating'] >= $pos ) ? '' : 'is-rating-unfilled';

	$color = 'currentColor';
	if ( ! empty( $attributes['color'] ) ) {
		$color = esc_attr( (string) $attributes['color'] );
	}

	return toolbelt_star_rating_star_get_symbol_high_fidelity( $classname_whole, $classname_half, $color );

}


/**
 * Returns an itemprop and content for rating symbols
 *
 * @param integer $position The position of the symbol.
 * @param integer $max_rating The maximum symbol score.
 * @return string
 */
function toolbelt_star_rating_get_schema_for_symbol( $position, $max_rating ) {

	$schema = '';

	if ( 1 === $position ) {
		$schema = 'itemprop="worstRating" content="0.5"';
	} elseif ( $max_rating === $position ) {
		$schema = 'itemprop="bestRating" content="' . esc_attr( (string) $max_rating ) . '"';
	}

	return $schema;

}


/**
 * Returns the symbol for the block.
 *
 * @param array<string|int> $attributes Array containing the block attributes.
 * @return string
 */
function toolbelt_star_rating_get_symbols( $attributes ) {

	/**
	 * Output SVGs for high fidelity contexts, then color them according to rating.
	 * These are hidden by default, then unhid when CSS loads.
	 */
	$symbols_hifi = array();
	for ( $pos = 1; $pos <= $attributes['maxRating']; $pos++ ) {
		$symbols_hifi[] = sprintf(
			'<span style="display: none;" %1$s>%2$s</span>',
			toolbelt_star_rating_get_schema_for_symbol( $pos, (int) $attributes['maxRating'] ),
			toolbelt_star_rating_get_symbol_high_fidelity( $attributes, $pos )
		);
	}

	/**
	 * Output fallback symbols for low fidelity contexts, like AMP,
	 * where CSS is not loaded so the high-fidelity symbols won't be rendered.
	 */
	$symbols_lofi = '';
	for ( $i = 0; $i < $attributes['rating']; $i++ ) {
		$symbols_lofi .= toolbelt_star_rating_get_symbol_low_fidelity();
	}

	return '<p>' . $symbols_lofi . '</p>' . implode( $symbols_hifi );

}
