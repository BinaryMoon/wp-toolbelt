/**
 * Toolbelt Multi Option Field.
 *
 * A field used to display multiple input types. It supports radio, checkbox,
 * and select elements.
 */
function ToolbeltFieldMultiple(
	{
		instanceId,
		required,
		description,
		label,
		isSelected,
		setAttributes,
		options,
		layout,
		type
	}
) {

	/**
	 * Set the state focus state.
	 *
	 * I have written this as three variables rather than the shorter
	 * `[x, y] = useState` since this works without bundling.
	 */
	const focusState = useState( -1 );
	const inFocus = focusState[ 0 ];
	const setInFocus = focusState[ 1 ];

	/**
	 * Ensure there is at least one option so we have something to start from.
	 */
	if ( !options.length ) {
		options = [ '' ];
	}

	/**
	 * Add a new option to the bottom of the list and set focus to that option.
	 */
	const addNewOption = () => {

		/**
		 * Use options.slice to get a copy of the array rather than a reference
		 * to the array.
		 *
		 * This allows us to edit clean data and not modify the original array
		 * unintentionally.
		 *
		 * We will update the array later with setAttributes.
		 */
		const newOptions = options.slice( 0 );
		newOptions.push( '' );
		setAttributes( { options: newOptions } );

		setInFocus( options.length );

	};

	/**
	 * Add an option.
	 */
	const updateOption = ( index, value ) => {

		if ( !index && index !== 0 ) {
			return;
		}

		const optionsList = options.slice( 0 );
		optionsList[ index ] = value;
		setAttributes( { options: optionsList } );
		setInFocus( index );

	};

	/**
	 * Remove an option.
	 */
	const deleteOption = ( index ) => {

		const optionsList = options.slice( 0 );
		const newOptions = optionsList.slice( 0, index ).concat( optionsList.slice( index + 1, optionsList.length ) );
		setAttributes( { options: newOptions } );

		if ( index > 0 ) {
			setInFocus( index - 1 );
		}

	};

	const keyPress = ( event, index ) => {

		if ( event.key === 'Enter' ) {

			addNewOption();
			event.preventDefault();
			return;

		}

		if ( event.key === 'Backspace' && event.target.value === '' ) {

			deleteOption( index );
			event.preventDefault();
			return;

		}

	};

	let itemLayout = layout;
	if ( !layout ) {
		itemLayout = 'vertical';
	}

	return (
		<Fragment>

			<ToolbeltFieldLabel
				required={required}
				label={label}
				description={description}
				setAttributes={setAttributes}
				isSelected={isSelected}
			/>

			<ol
				className={`toolbelt-field-multiple toolbelt-field-multiple-${type} toolbelt-field-multiple-layout-${itemLayout}`}
				id={`toolbelt-field-multiple-${instanceId}`}
			>

				{options.map(
					( option, index ) => (

						<ToolbeltMultiOption
							type={type}
							key={index}
							index={index}
							option={option}
							isSelected={isSelected}
							inFocus={inFocus}
							updateOption={updateOption}
							deleteOption={deleteOption}
							keyPress={keyPress}
						/>

					)
				)}

			</ol>

			{isSelected && (

				<Button
					className="toolbelt-field-multiple__add-option"
					icon="insert"
					label={__( 'Insert option', 'wp-toolbelt' )}
					onClick={addNewOption}
				>
					{__( 'Add option', 'wp-toolbelt' )}
				</Button>

			)}

			<InspectorControls>
				<PanelBody title={__( 'Field Settings', 'wp-toolbelt' )}>

					<TextControl
						label={__( 'Label', 'wp-toolbelt' )}
						value={label}
						onChange={value => setAttributes( { label: value } )}
					/>

					{( type === 'radio' || type === 'checkbox' ) && (
						<RadioControl
							label={__( 'Layout', 'wp-toolbelt' )}
							options={[
								{
									label: __( 'Vertical', 'wp-toolbelt' ),
									value: 'vertical',
								},
								{
									label: __( 'Horizontal', 'wp-toolbelt' ),
									value: 'horizontal',
								},
							]}
							onChange={( new_layout ) => { setAttributes( { layout: new_layout } ) }}
							selected={itemLayout}
						/>
					)}

				</PanelBody>
			</InspectorControls>

		</Fragment >
	);

}

