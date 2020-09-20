
/**
 * HTML for editing the column properties.
 *
 * @param {array} props The layout properties.
 * @return {string}
 */
const colEdit = ( props ) => {

	const { className, clientId } = props;

	const hasChildBlocks = useSelect(
		( select ) => {
			const blockCount = select( 'core/editor' ).getBlocksByClientId( clientId )[ 0 ].innerBlocks.length;
			return blockCount > 0;
		},
		[ clientId ]
	);

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
