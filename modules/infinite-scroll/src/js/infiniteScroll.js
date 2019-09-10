var toolbelt_is = ( function() {

	var url = function( new_path ) {

		// Doesn't work in IE.
		if ( !window.history.pushState ) {
			return;
		}

		// Only set state if we're not on the homepage.
		if ( toolbelt_is.page > 1 ) {

		}

		var slug = toolbelt_is.home + 'page/' + toolbelt_is.page + '/';

		if ( window.location.href !== slug ) {
			history.pushState( null, null, slug );
		}

	};

	var get = function() {

		var request = new XMLHttpRequest();
		var route = toolbelt_is.route + toolbelt_is.page;

		request.open( 'GET', route, true );

		request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8' );

		request.onreadystatechange = function() {

			if ( 4 === request.readyState ) {

				var response = JSON.parse( request.response );
				var el = document.querySelectorAll( '.toolbelt-infinite-scroll-wrapper' )[ 0 ];

				if ( el && response.html ) {
					el.insertAdjacentHTML( 'beforebegin', response.html );
				}

				url();

				// No more posts to display so hide the 'load more' button.
				if ( !response.html ) {
					document.body.classList.add( 'toolbelt-infinite-scroll-end' );
				}

				var button = document.querySelector( '.toolbelt-infinite-scroll-wrapper button' );
				button.style.display = 'inline';

				var spinner = document.querySelector( '.toolbelt-infinite-scroll-wrapper .toolbelt-spinner' );
				spinner.style.display = 'none';

				/**
				 * Dispatch an event so that themes and plugins know when posts
				 * have loaded.
				 *
				 * This is helpful for people using Masonry who need to
				 * rearrange content.
				 *
				 * The 'load-post' name comes from Jetpack, and I am using it
				 * for backwards compatability.
				 */
				document.body.dispatchEvent( new CustomEvent( 'load-post' ) );

			}

		};

		request.send();

	};

	return {

		init: function() {

			var button = document.querySelector( '.toolbelt-infinite-scroll-wrapper button' );

			if ( !button ) {
				return;
			}

			button.addEventListener(
				'click',
				toolbelt_is.request,
				false
			);

		},

		request: function() {

			if ( toolbelt_is.page <= 0 ) {
				return;
			}

			if ( !toolbelt_is.route ) {
				return;
			}

			var button = document.querySelector( '.toolbelt-infinite-scroll-wrapper button' );
			button.style.display = 'none';

			var spinner = document.querySelector( '.toolbelt-infinite-scroll-wrapper .toolbelt-spinner' );
			spinner.style.display = 'block';

			toolbelt_is.page++;

			get();

		},

		page: -1,

	};

} )();

toolbelt_is.init();