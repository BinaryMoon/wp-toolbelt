
/**
 * HTML for the generated slider.
 *
 * @param {array} props The slider properties.
 * @return {string}
 */
const sliderSave = ( props ) => {

	return (
		<div className={getSliderClass( props )} role="region" aria-label={__( 'slider', 'wp-toolbelt' )} tabindex="0">
			<ul>
				<InnerBlocks.Content />
			</ul>
		</div>
	);

};
