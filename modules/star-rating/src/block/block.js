( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { InspectorControls } = wp.blockEditor;
	const {
		RangeControl,
		PanelBody,
		PanelColorSettings,
	} = wp.components;
	const { __, _x } = wp.i18n;

	registerBlockType(
		'toolbelt/star-rating',
		{
			title: __( 'Star Rating', 'wp-toolbelt' ),

			icon: 'star',

			description: __( 'Add star ratings.', 'wp-toolbelt' ),

			category: 'wp-toolbelt',

			keywords: [
				_x( 'star rating', 'block search term', 'wp-toolbelt' ),
				_x( 'toolbelt', 'block search term', 'wp-toolbelt' )
			],

			attributes: {
				rating: {
					type: 'number',
					default: 1,
				},
				maxRating: {
					type: 'number',
					default: 5,
				},
				color: {
					type: 'string',
				},
				align: {
					type: 'string',
					default: 'left',
				},
			},

			edit( props ) {

				const setNewMaxRating = newMaxRating => setAttributes( { maxRating: newMaxRating } );

				const setNewColor = newColor => setAttributes( { color: newColor } );

				const setNewRating = newRating => {
					if ( newRating === rating ) {
						// Same number clicked twice.
						// Check if a half rating.
						if ( Math.ceil( rating ) === rating ) {
							// Whole number.
							newRating = newRating - 0.5;
						}
					}
					setAttributes( { rating: newRating } );
				};

				return (
					<>
						<BlockControls>
							<AlignmentToolbar
								value={align}
								onChange={nextAlign => setAttributes( { align: nextAlign } )}
							/>
						</BlockControls>
						<div className={className} style={{ textAlign: align }}>
							{range( 1, maxRating + 1 ).map( position => (
								<Rating key={position} id={position} setRating={setNewRating}>
									<span>
										<Symbol
											className={rating >= position - 0.5 ? null : 'is-rating-unfilled'}
											color={color}
										/>
									</span>
									<span>
										<Symbol
											className={rating >= position ? null : 'is-rating-unfilled'}
											color={color}
										/>
									</span>
								</Rating>
							) )}
						</div>
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
					</>
				);

			},

			save() {
				return null;
			}
		}
	);

} )();
