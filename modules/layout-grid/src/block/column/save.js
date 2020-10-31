/**
 * HTML for the generated column.
 *
 * @param {array} props The layout properties.
 * @return {string}
 */
const colSave = ( props ) => {

	return (
		<div className={getColClass( props )}>
			<InnerBlocks.Content />
		</div>
	);

};
