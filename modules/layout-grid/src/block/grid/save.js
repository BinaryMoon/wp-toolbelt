/**
 * The saved html for the grid layout.
 *
 * @param {array} props The block properties.
 * @param {string}
 */
const gridSave = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;

	return (
		<div className={getWrapperClass( props )} style={{ backgroundColor, color: textColor }}>
			<InnerBlocks.Content />
		</div>
	);

};