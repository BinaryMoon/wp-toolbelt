
jQuery( document ).ready(
	function( $ ) {

		/**
		 * Callback method for row status change.
		 *
		 * Fades out then deletes the affected row and updates the status
		 * navigation.
		 */
		const rowCallback = function( response ) {

			response = JSON.parse( response );
			const id = '#post-' + response.id;

			$( id )
				.css( { backgroundColor: '#FF7979' } )
				.fadeOut(
					350,
					function() {
						$( this ).remove();
						$( 'ul.subsubsub' ).html( response.html );
					}
				);

		};

		/**
		 * The desired minimum height for the messages.
		 */
		const desired_height = 150;

		/**
		 * The expand and contract button click event.
		 */
		const buttonClickEvent = function( e ) {

			e.preventDefault();

			const $this = $( this );
			const $parent = $this.prev( '.toolbelt-excerpt' );

			$parent.css( { 'height': 'auto' } );
			$this.remove();

		};

		/**
		 * Mark a post as not spam.
		 */
		$( '.feedback-ham a' ).click(
			function( e ) {

				e.preventDefault();
				const id = $( this ).data( 'id' );

				$.post(
					ajaxurl,
					{
						action: 'toolbelt_ajax_ham',
						post_id: id,
						_ajax_nonce: 3//'<?php echo wp_create_nonce( 'grunion- post - status - ' . $post_id ); ?>'
					},
					rowCallback
				);
			}
		);

		/**
		 * Mark a post as spam.
		 */
		$( '.feedback-spam a' ).click(
			function( e ) {

				e.preventDefault();
				const id = $( this ).data( 'id' );

				$.post(
					ajaxurl,
					{
						action: 'toolbelt_ajax_spam',
						post_id: id,
						_ajax_nonce: 3//'<?php echo wp_create_nonce( 'grunion- post - status - ' . $post_id ); ?>'
					},
					rowCallback
				);
			}
		);

		/**
		 * Loop through all of the post excerpts and add a toggle button that
		 * shows and hides the content.
		 */
		$( '.toolbelt-excerpt' ).each(
			function() {

				const $this = $( this );
				const height = parseInt( $this.outerHeight() );

				// Only add the toggle button if the content is long enough.
				if ( height > desired_height ) {

					$this.css(
						{
							'height': desired_height + 'px',
							'overflow': 'hidden',
						}
					);

					// Setup the toggle button.
					$this.next( 'button' )
						.on( 'click', buttonClickEvent )
						.show();

				}

			}
		);

	}
);