
/**
 * HTML for editing the column properties.
 *
 * @param {array} props The layout properties.
 * @return {string}
 */
const colEdit = ( props ) => {

	const { className, clientId } = props;

	// Count the innerblocks.
	// https://stackoverflow.com/questions/53345956/gutenberg-custom-block-add-elements-by-innerblocks-length
	const blocks = select( 'core/editor' ).getBlocksByClientId( clientId )[ 0 ];
	let blockCount = 0;

	if ( blocks ) {
		blockCount = blocks.innerBlocks.length;
	}

	const hasChildBlocks = blockCount > 0;

	return [
		<div className={className}>
			<InnerBlocks
				templateLock={false}
				renderAppender={
					hasChildBlocks
						? undefined
						: () => <InnerBlocks.ButtonBlockAppender />
				}
			/>
		</div>
	];

};
