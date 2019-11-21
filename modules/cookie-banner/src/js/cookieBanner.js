var toolbelt_cookie_bar = ( function() {

	var set_cookie = function( name, value, days ) {

		var expires = '';
		if ( days ) {
			var date = new Date();
			date.setTime( date.getTime() + ( days * 24 * 60 * 60 * 1000 ) );
			expires = "; expires=" + date.toGMTString();
		}
		document.cookie = name + "=" + value + expires + "; path=/";

	};

	var get_cookie = function( name ) {

		var nameEQ = name + "=";
		var ca = document.cookie.split( ';' );
		for ( var i = 0, n = ca.length, c; i < n; i++ ) {
			c = ca[ i ];
			while ( c.charAt( 0 ) == ' ' ) {
				c = c.substring( 1, c.length );
			}
			if ( c.indexOf( nameEQ ) == 0 ) {
				return c.substring( nameEQ.length, c.length );
			}
		}

		return null;

	};

	return {

		init: function() {

			var cookie = get_cookie( 'toolbelt_accepted_cookies' );

			document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'none';

			// Cookie not set so ask for acceptance.
			if ( !cookie ) {

				document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'flex';

				var accept = document.querySelector( '.toolbelt_cookie_wrapper .toolbelt_cookie_accept' );
				if ( accept !== null ) {
					accept.addEventListener(
						'click',
						toolbelt_cookie_bar.accept,
						false
					);
				}

				var decline = document.querySelector( '.toolbelt_cookie_wrapper .toolbelt_cookie_decline' );
				if ( decline !== null ) {

					decline.addEventListener(
						'click',
						toolbelt_cookie_bar.decline,
						false
					);

				}

			}

			// Cookie is accepted.
			if ( 'accepted' === cookie || 'yes' === cookie ) {

				toolbelt_cookies_accepted();
				document.body.dispatchEvent( new Event( 'toolbelt-cookie-accepted' ) );

			}

			// Cookie is declined.
			if ( 'declined' === cookie ) {

				document.body.dispatchEvent( new Event( 'toolbelt-cookie-declined' ) );

			}

		},

		accept: function() {

			set_cookie( 'toolbelt_accepted_cookies', 'accepted', 365 );

			document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'none';

			toolbelt_cookies_accepted();
			document.body.dispatchEvent( new Event( 'toolbelt-cookie-accepted' ) );

		},

		decline: function() {

			set_cookie( 'toolbelt_accepted_cookies', 'declined', 365 );

			document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'none';

			document.body.dispatchEvent( new Event( 'toolbelt-cookie-declined' ) );

		}

	};

} )();

toolbelt_cookie_bar.init();