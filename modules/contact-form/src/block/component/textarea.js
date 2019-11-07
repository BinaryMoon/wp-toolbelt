function ToolbeltFieldTextarea(
	{
		required,
		label,
		setAttributes,
		isSelected
	}
) {
	return (
		<Fragment>
			<div className="toolbelt-field">

				<ToolbeltFieldLabel
					required={required}
					label={label}
					setAttributes={setAttributes}
					isSelected={isSelected}
				/>

				<TextareaControl
					disabled
				/>

			</div>

			<InspectorControls>
				<PanelBody title={__( 'Field Settings', 'wp-toolbelt' )}>

					<TextControl
						label={__( 'Label', 'wp-toolbelt' )}
						value={label}
						onChange={value => setAttributes( { label: value } )}
					/>

				</PanelBody>
			</InspectorControls>

		</Fragment>
	);
}
