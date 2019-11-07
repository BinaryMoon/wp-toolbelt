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

	console.log( inFocus, index );

	useEffect(
		() => {

			if ( !thisRef || !thisRef.current ) {
				return;
			}

			if ( index === inFocus ) {
				console.log( 'focus', index );
				thisRef.current.focus();
			}
		}
	);

	return (

		<li className="toolbelt-option">

			{type && type !== 'select' && (

				<input className="toolbelt-option-type" type={type} disabled />

			)}

			{isSelected && (

				<>

					<input
						type="text"
						className="toolbelt-option-input"
						value={option}
						placeholder={__( 'Write option…', 'toolbelt' )}
						ref={thisRef}
						onChange={value => { updateOption( index, value ); }}
						onKeyDown={( event ) => { keyPress( event, index ); }}
					/>

					<IconButton
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