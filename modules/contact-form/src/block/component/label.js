/**
 * Toolbelt Field Label
 *
 * A generic label component. This displays a label, a 'required' flag, and
 * space for a description. It can be reused across all field types.
 */
function ToolbeltFieldLabel(
	{
		setAttributes,
		label,
		required,
		isSelected,
		description
	}
) {

	let thisRef = createRef();

	return (
		<div className="toolbelt-field-label">

			{isSelected && (

				<input
					type="text"
					value={label}
					className="toolbelt-field-label-text"
					onChange={event => { setAttributes( { label: event.target.value } ); }}
					placeholder={__( 'Write label…', 'wp-toolbelt' )}
					ref={thisRef}
				/>

			)}

			{!isSelected && (

				<label className="toolbelt-field-label-text">
					{label}&nbsp;
				</label>

			)}

			{isSelected && (

				<>

					<ToggleControl
						label={__( 'Required', 'wp-toolbelt' )}
						className="toolbelt-field-label-required"
						checked={required}
						onChange={value => setAttributes( { required: value } )}
					/>

					<TextareaControl
						label={__( 'Description', 'wp-toolbelt' )}
						value={description}
						className="toolbelt-field-label-description"
						onChange={( value ) => { console.log( value ); setAttributes( { description: value } ) }}
					/>

				</>

			)}

			{!isSelected && !required && (

				<em>({__( 'Optional', 'wp-toolbelt' )})</em>

			)}

			{!isSelected && description && (

				<p className="toolbelt-field-label-description">{description}</p>

			)}

		</div>
	);

};
