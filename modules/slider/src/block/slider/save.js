const sliderSave = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;

	return (
		<section className={getSliderClass( props )} style={{ backgroundColor, color: textColor }}>
			<InnerBlocks.Content />
		</section>
	);

};
