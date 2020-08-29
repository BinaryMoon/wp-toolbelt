/**
 * Save the data.
 * This data is only used in the editor or as a fallback. It's not actually
 * displayed on the front end because that's rendered with PHP.
 */
const save = ( props ) => {

	const { className, attributes: { align, rating, maxRating, color } } = props;
	const fallbackSymbol = '⭐';

	const rating_text = sprintf(
		__( 'Rating %d out of %d', 'wp-toolbelt' ),
		rating,
		maxRating
	);

	return (
		<figure className={className} style={{ textAlign: align }}>
			{range( 1, rating + 1 ).map( position => (
				<span key={position} style={{ color }}>
					{fallbackSymbol}
				</span>
			) )}
			<span class="screen-reader-text">{rating_text}</span>
		</figure>
	);

};
