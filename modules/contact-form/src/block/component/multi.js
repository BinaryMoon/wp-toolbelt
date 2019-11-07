
function ToolbeltFieldMultiple(
	{
		instanceId,
		required,
		label,
		isSelected,
		setAttributes,
		options,
		type
	}
) {

	/**
	 * Ensure there is at least one option so we have something to start from.
	 */
	if ( !options.length ) {
		options = [ __( 'Example', 'wp-toolbelt' ) ];
	}

	let inFocus = 0;

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

		inFocus = options.length;

	};


	const updateOption = ( index, value ) => {

		if ( !index ) {
			return;
		}

		const optionsList = options.slice( 0 );
		optionsList[ index ] = value;
		setAttributes( { options: optionsList } );

	};

	const deleteOption = ( index ) => {

		const optionsList = options.slice( 0 );
		const newOptions = optionsList.slice( 0, index ).concat( optionsList.slice( index + 1, optionsList.length ) );
		setAttributes( { options: newOptions } );

		inFocus = index - 1;

	};

	const keyPress = ( event, index ) => {

		if ( event.key === 'Enter' ) {

			inFocus = index + 1;

			// addNewOption();
			event.preventDefault();
			return;

		}

		if ( event.key === 'Backspace' && event.target.value === '' ) {

			deleteOption( index );
			event.preventDefault();
			return;

		}

	};

	return (
		<Fragment>

			<ToolbeltFieldLabel
				required={required}
				label={label}
				setAttributes={setAttributes}
				isSelected={isSelected}
			/>

			<ol
				className={`toolbelt-field-multiple toolbelt-field-multiple-${type}`}
				id={`toolbelt-field-multiple-${instanceId}`}
			>

				{options.map(
					( option, index ) => (

						<ToolbeltMultiOption
							type={type}
							key={index}
							option={option}
							index={index}
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

				<IconButton
					className="toolbelt-field-multiple__add-option"
					icon="insert"
					label={__( 'Insert option', 'wp-toolbelt' )}
					onClick={addNewOption}
				>
					{__( 'Add option', 'wp-toolbelt' )}
				</IconButton>

			)}

			<InspectorControls>
				<PanelBody title={__( 'Field Settings', 'wp-toolbelt' )}>

					<TextControl
						label={__( 'Label', 'wp-toolbelt' )}
						value={label}
						onChange={value => setAttributes( { label: value } )}
					/>

				</PanelBody>
			</InspectorControls>

		</Fragment >
	);

	// onChangeOption( key = null, option = null ) {
	// 	const newOptions = this.props.options.slice( 0 );
	// 	if ( null === option ) {
	// 		// Remove a key
	// 		newOptions.splice( key, 1 );
	// 		if ( key > 0 ) {
	// 			this.setState( { inFocus: key - 1 } );
	// 		}
	// 	} else {
	// 		// update a key
	// 		newOptions.splice( key, 1, option );
	// 		this.setState( { inFocus: key } ); // set the focus.
	// 	}
	// 	this.props.setAttributes( { options: newOptions } );
	// }

	// addNewOption( key = null ) {
	// 	const newOptions = this.props.options.slice( 0 );
	// 	let inFocus = 0;
	// 	if ( 'object' === typeof key ) {
	// 		newOptions.push( '' );
	// 		inFocus = newOptions.length - 1;
	// 	} else {
	// 		newOptions.splice( key + 1, 0, '' );
	// 		inFocus = key + 1;
	// 	}

	// 	this.setState( { inFocus: inFocus } );
	// 	this.props.setAttributes( { options: newOptions } );
	// }

	// render() {
	// 	const { type, instanceId, required, label, setAttributes, isSelected, id } = this.props;
	// 	let { options } = this.props;
	// 	let { inFocus } = this.state;
	// 	if ( !options.length ) {
	// 		options = [ '' ];
	// 		inFocus = 0;
	// 	}

	// }

}

