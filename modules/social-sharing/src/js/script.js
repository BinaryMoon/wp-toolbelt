( () => {

	// If the social share api feature is not available then quit.
	if ( !navigator.share ) {
		return;
	}

	// Add class to body to allow social sharing.
	document.addEventListener(
		'DOMContentLoaded',
		() => {
			document.body.classList.add( 'toolbelt-social-share-api-enabled' );
		}
	);

	// Add click handler for sharing button.
	document.querySelector( '.toolbelt_share-api' ).addEventListener(
		'click',
		() => {
			const title = document.querySelector( 'title' ).textContent;
			const permalink = document.querySelector( 'link[rel="canonical"]' ).getAttribute( 'href' );
			const $description = document.querySelector( 'meta[name="description"]' );

			let text = '';
			if ( $description ) {
				text = $description.getAttribute( 'content' );
			}

			navigator.share(
				{
					title,
					text,
					url: permalink
				}
			);
		}
	);

} )();