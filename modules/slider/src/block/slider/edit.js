const getSliderClass = ( props ) => {

	let classNames = [
		'toolbelt-block-slider',
	];

	return classNames.join( ' ' );

};

const sliderEdit = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;
	const ALLOWED_BLOCKS = [ 'toolbelt/slide' ];
	const SLIDER_TEMPLATE = [ [ 'toolbelt/slide' ] ];

	return [
		<div className={getSliderClass( props )} style={{ backgroundColor, color: textColor }}>
			<InnerBlocks
				template={SLIDER_TEMPLATE}
				allowedBlocks={ALLOWED_BLOCKS}
				orientation="horizontal"
			/>
		</div>
		// gridInspector( props )
	];

};
