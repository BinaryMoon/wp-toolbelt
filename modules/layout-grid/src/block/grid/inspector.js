
/**
 * Create the React code for the inspector functionality.
 *
 * @param {array} props The block properties.
 * @param {array}
 */
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

						<div
							className="toolbelt-grid-buttongroup"
						>
							{
								layouts.map(
									( { name, icon }, index ) => {
										let class_name = 'toolbelt-grid-button';
										if ( index === layout ) {
											class_name += ' toolbelt-selected';
										}
										return (
											<Button
												key={'col' + index}
												className={class_name}
												isSmall
												data-index={index}
												onClick={
													() => {
														setAttributes( { layout: index } );
														//this.setState( { selectLayout: false } );
													}
												}
											>
												{icon}
											</Button>
										);
									}
								)
							}
						</div>
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
