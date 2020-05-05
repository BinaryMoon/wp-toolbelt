const gridEdit = function( props ) {


	const { attributes, setAttributes } = props;
	const { columns } = attributes;
	const ALLOWED_BLOCKS = [ 'core/column' ];

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
		{
			name: __( '6 Columns', 'toolbelt' ),
			key: 'six-column',
			columns: 6,
			icon: icons.sixEqual
		}
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
					{columnOptions.map(
						( { name, key, icon, columns } ) => (
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
					)}
				</ButtonGroup>
			</Placeholder >
		];

	}

	return [
		<div className={className ? className : undefined}>
			<InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
		</div>
	];

};