/**
 * Toolbelt Option element.
 */
function ToolbeltMultiOption(
	{
		isSelected,
		option,
		type,
		updateOption,
		deleteOption,
		keyPress,
		index,
		inFocus
	}
) {

	const thisRef = createRef();

	useEffect(
		() => {

			if ( !thisRef || !thisRef.current ) {
				return;
			}

			if ( index === inFocus ) {
				thisRef.current.focus();
			}
		}
	);

	return (

		<li className="toolbelt-option">

			{type && type !== 'select' && (

				<input
					className="toolbelt-option-type"
					type={type}
					disabled
				/>

			)}

			{isSelected && (

				<>

					<input
						type="text"
						className="toolbelt-option-input"
						value={option}
						placeholder={__( 'Write option…', 'toolbelt' )}
						ref={thisRef}
						onChange={event => { updateOption( index, event.target.value ); }}
						onKeyDown={event => { keyPress( event, index ); }}
					/>

					<Button
						className="toolbelt-option-remove"
						icon="trash"
						label={__( 'Remove option', 'jetpack' )}
						onClick={() => { deleteOption( index ) }}
					/>

				</>

			)}

			{!isSelected && (

				<label className="toolbelt-field-label-text">
					{option}&nbsp;
				</label>

			)}

		</li>

	);

}