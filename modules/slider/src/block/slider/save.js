
/**
 * HTML for the generated slider.
 *
 * @param {array} props The slider properties.
 * @return {string}
 */
const sliderSave = ( props ) => {

	return (
		<div className={getSliderClass( props )}>
			<ul>
				<InnerBlocks.Content />
			</ul>
		</div>
	);

};
