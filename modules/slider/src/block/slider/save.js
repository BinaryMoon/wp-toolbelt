const sliderSave = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;

	return (
		<div className={getSliderClass( props )} style={{ backgroundColor, color: textColor }}>
			<ul>
				<InnerBlocks.Content />
			</ul>
		</div>
	);

};
