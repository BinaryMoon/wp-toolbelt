const getSliderClass = ( props ) => {

	const { attributes } = props;

	let classNames = [
		'toolbelt-block-slider',
	];

	if ( attributes.textAlignment ) {
		classNames.push( `has-text-align-${attributes.textAlignment}` );
	}

	return classNames.join( ' ' );

};

const sliderEdit = ( props ) => {

	const { attributes, setAttributes } = props;
	const { textAlignment } = attributes;
	const ALLOWED_BLOCKS = [ 'toolbelt/slide' ];
	const SLIDER_TEMPLATE = [ [ 'toolbelt/slide' ] ];

	return [
		<BlockControls>
			<AlignmentToolbar
				value={textAlignment}
				onChange={( value ) => setAttributes( { textAlignment: value } )}
			/>
		</BlockControls>,
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
