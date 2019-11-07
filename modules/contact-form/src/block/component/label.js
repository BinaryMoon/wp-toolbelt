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
					onChange={value => { setAttributes( { label: value } ); }}
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

			{!isSelected && required && (

				<em>({__( 'Required', 'wp-toolbelt' )})</em>

			)}

		</div>
	);

};
