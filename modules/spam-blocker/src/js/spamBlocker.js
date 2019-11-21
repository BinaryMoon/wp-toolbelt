var toolbelt_spam = ( function() {

	/**
	 * Attach the spam check field to the comment form.
	 *
	 * @param object event
	 */
	var attachInput = function( event ) {

		if ( !event.target ) {
			return;
		}

		// Check we haven't already added the check element.
		if ( event.target.querySelector( '.toolbelt-check' ) ) {
			return;
		}

		// Create an input field to add to the form.
		var input = document.createElement( 'input' );
		input.type = 'hidden';
		input.name = 'toolbelt-check';
		input.className = 'toolbelt-check';
		input.value = 1;

		// Append the field.
		event.target.appendChild( input );

	};


	return {

		init: function() {

			var forms = [
				'#commentform',						// WordPress comments.
				'.contact-form.commentsblock',		// Jetpack Contact form.
				'#contactform',						// ?
				'.ninja-forms-form',				// Ninja Forms.
				'.wpforms-form',					// WPForms.
				'.gform_wrapper form'				// Gravity Forms.
			];

			/**
			 * Get all forms on the page.
			 */
			var commentforms = document.querySelectorAll( forms.join() );

			// Quit if there's no forms.
			if ( !commentforms.length ) {
				return;
			}

			/**
			 * Add the submit event to all forms.
			 */
			for ( var i = 0; i < commentforms.length; i++ ) {

				commentforms[ i ].addEventListener(
					'submit',
					attachInput,
					false
				);

			}

		}

	};

} )();

toolbelt_spam.init();
