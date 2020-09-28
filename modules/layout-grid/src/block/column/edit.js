
/**
 * Get the column classes.
 *
 * @param {array} props The layout properties.
 * @return {string}
 */
const getColClass = ( props ) => {

	const { className, attributes } = props;

	const { alignment } = attributes;

	let classes = [
		'toolbelt-column-align-' + alignment
	];

	let newClassName = className;

	if ( newClassName === undefined || newClassName === 'undefined' ) {
		newClassName = '';
	}

	newClassName = newClassName + ' ' + classes.join( ' ' );
	newClassName = newClassName.replace( 'undefined', '' );

	return newClassName;

};


/**
 * HTML for editing the column properties.
 *
 * @param {array} props The layout properties.
 * @return {string}
 */
const colEdit = ( props ) => {

	const { className, clientId, attributes, setAttributes } = props;

	const { alignment } = attributes;

	// Count the innerblocks.
	// https://stackoverflow.com/questions/53345956/gutenberg-custom-block-add-elements-by-innerblocks-length
	const blocks = select( 'core/editor' ).getBlocksByClientId( clientId )[ 0 ];
	let blockCount = 0;

	if ( blocks ) {
		blockCount = blocks.innerBlocks.length;
	}

	const hasChildBlocks = blockCount > 0;

	return [
		<InspectorControls>
			<PanelBody
				title={__( 'Column Layout', 'wp-toolbelt' )}
				initialOpen={true}
			>
				<RadioControl
					label={__( 'Alignment', 'wp-toolbelt' )}
					selected={alignment}
					options={
						[
							{ label: __( 'Top', 'wp-toolbelt' ), value: 'top' },
							{ label: __( 'Middle', 'wp-toolbelt' ), value: 'middle' },
							{ label: __( 'Bottom', 'wp-toolbelt' ), value: 'bottom' },
							{ label: __( 'Space Between', 'wp-toolbelt' ), value: 'space-between' },
						]
					}
					onChange={
						( newAlignment ) => setAttributes( { 'alignment': newAlignment } )
					}
				/>
			</PanelBody>
		</InspectorControls>,
		<div className={getColClass( props )}>
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
