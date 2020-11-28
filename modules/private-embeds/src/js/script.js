const toolbelt_private_embeds = ( function() {

	return {

		init: function() {

			const buttons = document.querySelectorAll( 'button.toolbelt-embed-shield' );

			if ( !buttons ) {
				return;
			}

			buttons.forEach(
				button => {
					button.addEventListener(
						'click',
						( e ) => {
							const iframe_data = e.target.getAttribute( 'data-iframe' );
							const html_fragment = document.createRange().createContextualFragment( iframe_data );
							e.target.replaceWith( html_fragment );
						}
					);
				}
			);

		}

	};

} )();

toolbelt_private_embeds.init();
