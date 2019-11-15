/**
 * Toolbelt Field Label
 *
 * A generic label component. This displays a label, and a 'required' flag. It
 * can be reused across all field types.
 */
function ToolbeltFieldLabel(
	{
		setAttributes,
		label,
		required,
		isSelected
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

				<ToggleControl
					label={__( 'Required', 'wp-toolbelt' )}
					className="toolbelt-field-label-required"
					checked={required}
					onChange={value => setAttributes( { required: value } )}
				/>

			)}

			{!isSelected && !required && (

				<em>({__( 'Optional', 'wp-toolbelt' )})</em>

			)}

		</div>
	);

};
