const gridSave = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;

	return (
		<div className={getWrapperClass( props )} style={{ backgroundColor, color: textColor }}>
			<InnerBlocks.Content />
		</div>
	);

};