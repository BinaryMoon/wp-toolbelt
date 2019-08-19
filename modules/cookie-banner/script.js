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

			if ( !get_cookie( 'tb_accepted_cookies' ) ) {

				var container = document.querySelector( '.tb_cookie_wrapper' );
				container.style.display = 'flex';

				document.querySelector( '.tb_cookie_wrapper button' ).addEventListener(
					'click',
					toolbelt_cookie_bar.accept,
					false
				);

			}

		},

		accept: function() {

			set_cookie( 'tb_accepted_cookies', 'yes', 365 );
			document.querySelector( '.tb_cookie_wrapper' ).style.display = 'none';

		}

	};

} )();

toolbelt_cookie_bar.init();