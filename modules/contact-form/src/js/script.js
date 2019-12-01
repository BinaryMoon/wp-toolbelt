; ( function() {

	const toolbelt_changed = function( event ) {
		event.target.classList.add( 'toolbelt-changed' );
	};

	const selectors = [
		'.toolbelt-contact-form input',
		'.toolbelt-contact-form select',
		'.toolbelt-contact-form textarea'
	];

	let inputs = document.querySelectorAll( selectors.join( ',' ) );

	inputs.forEach(
		( value, index ) => {
			inputs[ index ].addEventListener( 'keydown', toolbelt_changed );
			inputs[ index ].addEventListener( 'blur', toolbelt_changed );
		}
	);

} )();
