const sliderSave = ( props ) => {

	const { attributes } = props;
	// const { } = attributes;

	return (
		<div className={getSliderClass( props )}>
			<ul>
				<InnerBlocks.Content />
			</ul>
		</div>
	);

};
