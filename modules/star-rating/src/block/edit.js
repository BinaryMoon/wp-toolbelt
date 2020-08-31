const Rating = ( { id, setRating, children } ) => {

	const setNewRating = newRating => () => setRating( newRating );
	const maybeSetNewRating = newRating => ( { keyCode } ) => keyCode === ENTER ? setRating( newRating ) : null;

	return (
		<span
			className="toolbelt-ratings-button"
			data-position={id}
			tabIndex={0}
			role="button"
			onClick={setNewRating( id )}
			onKeyDown={maybeSetNewRating( id )}
		>
			{children}
		</span>
	);

};


const edit = ( props ) => {

	const { className, setAttributes, attributes: { align, color, rating, maxRating } } = props;

	const setNewMaxRating = newMaxRating => {
		setAttributes(
			{
				rating: Math.min( rating, newMaxRating ),
				maxRating: newMaxRating
			}
		);
	}

	const setNewColor = newColor => setAttributes( { color: newColor } );

	const setNewRating = newRating => {

		/**
		 * If the same star is clicked more than once then we make it a half
		 * star.
		 */
		if ( newRating === rating ) {
			/**
			 * If the number rounded up = the current rating, then they are a
			 * whole number, so let's subtract half to make it a half star.
			 */
			if ( Math.ceil( rating ) === rating ) {
				// Whole number.
				newRating = newRating - 0.5;
			}
		}

		setAttributes( { rating: newRating } );

	};

	return [
		<BlockControls>
			<AlignmentToolbar
				value={align}
				onChange={nextAlign => setAttributes( { align: nextAlign } )}
			/>
		</BlockControls>,
		<div className={className} style={{ textAlign: align }}>
			{range( 1, maxRating + 1 ).map( position => (
				<Rating key={position} id={position} setRating={setNewRating}>
					<span>
						<StarIcon
							color={color}
							className={rating >= position - 0.5 ? null : 'is-rating-unfilled'}
						/>
					</span>
					<span>
						<StarIcon
							color={color}
							className={rating >= position ? null : 'is-rating-unfilled'}
						/>
					</span>
				</Rating>
			) )}
		</div>,
		<InspectorControls>
			<PanelBody title={__( 'Settings', 'wp-toolbelt' )}>
				<RangeControl
					label={__( 'Highest rating', 'wp-toolbelt' )}
					value={maxRating}
					onChange={setNewMaxRating}
					min={2}
					max={10}
				/>
				<PanelColorSettings
					title={__( 'Color Settings', 'wp-toolbelt' )}
					initialOpen
					colorSettings={[
						{
							value: color,
							onChange: setNewColor,
							label: __( 'Color', 'wp-toolbelt' ),
						},
					]}
				/>
			</PanelBody>
		</InspectorControls>
	];

};
