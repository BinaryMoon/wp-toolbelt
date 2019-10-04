var toolbelt_spam = ( function() {

	var inputAdded = false;

	/**
	 * Attach the spam check field to the comment form.
	 *
	 * @param object event
	 */
	var attachInput = function( event ) {

		// Check to stop us from adding multiple fields.
		if ( inputAdded ) {
			return;
		}

		var commentform = document.getElementById( 'commentform' );

		// Create an input field to add to the form.
		var input = document.createElement( 'input' );
		input.type = 'hidden';
		input.name = 'toolbelt-check';
		input.value = 1;

		// Append the field.
		commentform.appendChild( input );

		inputAdded = true;

	};

	return {

		init: function() {

			var commentform = document.getElementById( 'commentform' );

			// Quit if there's no comment form.
			if ( ! commentform ) {
				return;
			}

			commentform.addEventListener(
				'submit',
				attachInput,
				false
			);

		}

	};

} )();

toolbelt_spam.init();
