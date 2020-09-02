const gridInspector = ( props ) => {

	const { attributes, setAttributes } = props;
	const { columns, layout, textColor, backgroundColor } = attributes;

	let layouts = [];

	if ( columnLayouts[ columns ] ) {
		layouts = columnLayouts[ columns ];
	}

	return (
		<InspectorControls>
			{
				( layouts ) && (
					<PanelBody
						title={__( 'General', 'wp-toolbelt' )}
						initialOpen={true}
						className="toolbelt-column-select-panel"
					>
						<p>{__( 'Column Layout', 'wp-toolbelt' )}</p>
						<ButtonGroup
							aria-label={__( 'Column Layout', 'wp-toolbelt' )}
						>
							{
								layouts.map(
									( { name, icon }, index ) => {

										return (
											<Tooltip
												text={name}
												key={'col' + index}
											>
												<Button
													key={'col' + index}
													className="toolbelt-grid-column-selector"
													isSmall
													onClick={
														() => {
															setAttributes( { layout: index } );
															this.setState( { selectLayout: false } );
														}
													}
												>
													{icon}
												</Button>
											</Tooltip>
										);

									}
								)
							}
						</ButtonGroup>
						<p className="description">
							{__( 'Change the layout of your columns.', 'wp-toolbelt' )}
						</p>
					</PanelBody>
				)
			}

			<PanelColorSettings
				title={__( 'Color Settings', 'wp-toolbelt' )}
				initialOpen={false}
				colorSettings={[
					{
						value: textColor,
						onChange: ( newColor ) => setAttributes( { textColor: newColor } ),
						label: __( 'Text Color', 'wp-toolbelt' ),
					},
					{
						value: backgroundColor,
						onChange: ( newColor ) => setAttributes( { backgroundColor: newColor } ),
						label: __( 'Background Color', 'wp-toolbelt' ),
					},
				]}
			/>
		</InspectorControls>
	);

};
