var toolbelt_cookie_bar = ( function() {

	var set_cookie = function( name, value, days ) {

		var expires = '';
		if ( days ) {
			var date = new Date();
			date.setTime( date.getTime() + ( days * 24 * 60 * 60 * 1000 ) );
			var expires = "; expires=" + date.toGMTString();
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

			console.log( 'cookie', cookie );

			// Cookie not set so ask for acceptance.
			if ( !cookie ) {

				document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'flex';

				document.querySelector( '.toolbelt_cookie_wrapper .toolbelt_cookie_accept' ).addEventListener(
					'click',
					toolbelt_cookie_bar.accept,
					false
				);

				document.querySelector( '.toolbelt_cookie_wrapper .toolbelt_cookie_decline' ).addEventListener(
					'click',
					toolbelt_cookie_bar.decline,
					false
				);

			}

			// Cookie is accepted.
			if ( 'accepted' === cookie ) {

				toolbelt_cookies_accepted();

			}

			// Cookie is declined.
			if ( 'declined' === cookie ) {

			}

		},

		accept: function() {

			set_cookie( 'toolbelt_accepted_cookies', 'accepted', 365 );

			document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'none';

			toolbelt_cookies_accepted();

		},

		decline: function() {

			set_cookie( 'toolbelt_accepted_cookies', 'declined', 365 );

			document.querySelector( '.toolbelt_cookie_wrapper' ).style.display = 'none';

		}

	};

} )();

toolbelt_cookie_bar.init();