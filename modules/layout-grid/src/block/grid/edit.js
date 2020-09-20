
/**
 * Generate the html for the block template.
 *
 * @param {int} columns The number of columns.
 * @return {string}
 */
const getColumnsTemplate = ( columns ) => {

	let index = -1;
	let result = Array( columns );

	while ( ++index < columns ) {
		result[ index ] = [ 'toolbelt/column' ];
	}

	return result;

};


/**
 * Get the class list for the layout grid wrapper.
 *
 * @param {array} props The list of block properties.
 * @return {string}
 */
const getWrapperClass = ( props ) => {

	const { attributes, className } = props;

	const { columns, layout, textColor, backgroundColor } = attributes;

	let classNames = [
		'wp-block-toolbelt-layout-grid',
		className,
	];

	let grid_column = 2;
	let grid_layout = 0;

	if ( columns ) {
		grid_column = columns;
	}

	if ( layout ) {
		grid_layout = layout;
	}

	classNames.push( `toolbelt-grid-layout-${grid_column}-${grid_layout}` );

	if ( backgroundColor ) {
		classNames.push( 'has-background' );
	}

	if ( textColor ) {
		classNames.push( 'has-text-color' );
	}

	return classNames.join( ' ' );

};

/**
 * Create the React code for the editing functionality.
 *
 * @param {array} props The block properties.
 * @param {array}
 */
const gridEdit = function( props ) {

	const { attributes, setAttributes } = props;
	const { columns, layout, textColor, backgroundColor } = attributes;
	const ALLOWED_BLOCKS = [ 'toolbelt/column' ];

	const columnOptions = [
		{
			name: __( '2 Columns', 'toolbelt' ),
			key: 'two-column',
			columns: 2,
			icon: icons.twoEqual
		},
		{
			name: __( '3 Columns', 'toolbelt' ),
			key: 'three-column',
			columns: 3,
			icon: icons.threeEqual
		},
		{
			name: __( '4 Columns', 'toolbelt' ),
			key: 'four-column',
			columns: 4,
			icon: icons.fourEqual
		},
		{
			name: __( '5 Columns', 'toolbelt' ),
			key: 'five-column',
			columns: 5,
			icon: icons.fiveEqual
		},
	];

	if ( !columns ) {

		return [
			<Placeholder
				key="placeholder"
				icon="editor-table"
				label={__( 'Column Count', 'toolbelt' )}
				instructions={__( 'Select the number of columns for this layout.', 'toolbelt' )}
				className={'toolbelt-layout-grid-placeholder'}
			>
				<ButtonGroup
					aria-label={__( 'Select Number of Columns', 'toolbelt' )}
					className="toolbelt-column-selector-group"
				>
					{
						columnOptions.map(
							( { name, key, icon, columns } ) => {
								return (
									<Tooltip text={name} key={key}>
										<Button
											className="toolbelt-column-selector-button"
											onClick={
												() => setAttributes( { columns } )
											}
										>
											{icon}
										</Button>
									</Tooltip>
								)
							}
						)
					}
				</ButtonGroup>
			</Placeholder >
		];

	}

	return [
		<div className={getWrapperClass( props )} style={{ backgroundColor, color: textColor }}>
			<InnerBlocks
				template={getColumnsTemplate( columns )}
				templateLock="all"
				allowedBlocks={ALLOWED_BLOCKS}
			/>
		</div>,
		gridInspector( props )
	];

};
