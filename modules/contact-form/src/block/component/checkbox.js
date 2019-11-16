/**
 * Toolbelt Field Checkbox
 *
 * A field used specifically for checkbox items.
 */
function ToolbeltFieldCheckbox(
	{
		label,
		setAttributes,
		defaultValue,
		isSelected,
		description
	}
) {

	console.log( description );

	return (
		<Fragment>

			<div className="toolbelt-field-checkbox">

				<input
					className="toolbelt-field-checkbox__checkbox"
					type="checkbox"
					disabled
					checked={defaultValue}
				/>

				{isSelected && (

					<>

						<input
							type="text"
							className="toolbelt-field-label-text"
							value={label}
							onChange={event => setAttributes( { label: event.target.value } )}
						/>

						<TextareaControl
							label={__( 'Description', 'wp-toolbelt' )}
							value={description}
							className="toolbelt-field-label-description"
							onChange={( value ) => { console.log( value ); setAttributes( { description: value } ) }}
						/>

					</>

				)}

				{!isSelected && (

					<>

						<label className="toolbelt-field-label-text">
							{label}
						</label>

						{description && (
							<p className="toolbelt-field-label-description">{description}</p>
						)}

					</>

				)}

			</div>

			<InspectorControls>
				<PanelBody title={__( 'Field Settings', 'wp-toolbelt' )}>

					<TextControl
						label={__( 'Label', 'wp-toolbelt' )}
						value={label}
						onChange={value => setAttributes( { label: value } )}
					/>

					<ToggleControl
						label={__( 'Default Checked State', 'wp-toolbelt' )}
						checked={defaultValue}
						onChange={value => setAttributes( { defaultValue: value } )}
					/>

				</PanelBody>
			</InspectorControls>

		</Fragment>
	);
};