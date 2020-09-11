
/**
 * Get the classes for the slider.
 *
 * @param {array} props The slider properties.
 * @return {string}
 */
const getSliderClass = ( props ) => {

	const { attributes, className } = props;

	let classNames = [
		'toolbelt-block-slider',
		className,
	];

	if ( attributes.textAlignment ) {
		classNames.push( `has-text-align-${attributes.textAlignment}` );
	}

	if ( attributes.slideWidth ) {
		classNames.push( `toolbelt-block-slide-width-${attributes.slideWidth.toLowerCase()}` );
	}

	return classNames.join( ' ' );

};

/**
 * HTML used to edit the slider.
 *
 * @param {array} props The slider properties.
 * @return {array}
 */
const sliderEdit = ( props ) => {

	const { attributes, setAttributes } = props;
	const { textAlignment, slideWidth } = attributes;
	const ALLOWED_BLOCKS = [ 'toolbelt/slide' ];
	const SLIDER_TEMPLATE = [ [ 'toolbelt/slide' ] ];

	return [
		<BlockControls>
			<AlignmentToolbar
				value={textAlignment}
				label={__( 'Slide Width', 'wp-toolbelt' )}
				onChange={( value ) => setAttributes( { textAlignment: value } )}
			/>
		</BlockControls>,
		<InspectorControls>
			<PanelBody
				title={__( 'Slider Settings', 'wp-toolbelt' )}
				initialOpen={true}
			>
				<ButtonGroup
					label={__( 'Slide Width', 'wp-toolbelt' )}
				>
					<p>{__( 'Slide Width', 'wp-toolbelt' )}</p>
					{
						[ 'S', 'M', 'L', 'XL' ].map(
							size => (
								<Button
									onClick={() => setAttributes( { slideWidth: size } )}
									value={size}
									isPrimary={size === slideWidth}
								>
									{size}
								</Button>
							)
						)
					}
				</ButtonGroup>
			</PanelBody>
		</InspectorControls>,
		<div className={getSliderClass( props )} role="group">
			<InnerBlocks
				template={SLIDER_TEMPLATE}
				allowedBlocks={ALLOWED_BLOCKS}
				orientation="horizontal"
				renderAppender={
					() => (
						<InnerBlocks.ButtonBlockAppender />
					)
				}
			/>
		</div>
	];

};
