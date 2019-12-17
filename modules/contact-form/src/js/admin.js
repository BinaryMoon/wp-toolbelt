
jQuery( document ).ready(
	function( $ ) {

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
					function( r ) {

						$( '#post-' + id )
							.css( { backgroundColor: '#59C859' } )
							.fadeOut(
								350,
								() => {
									$( this ).remove();
									$( 'ul.subsubsub' ).html( r );
								}
							);

					}
				);
			}
		);

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
					function( r ) {
						$( '#post-' + id )
							.css( { backgroundColor: '#FF7979' } )
							.fadeOut(
								350,
								() => {
									$( this ).remove();
									$( 'ul.subsubsub' ).html( r );
								}
							);
					}
				);
			}
		);

	}
);