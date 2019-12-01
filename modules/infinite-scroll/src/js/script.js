var toolbelt_is = ( function() {

	/**
	 * Set the url for the archive page.
	 *
	 * Uses push state to change the page so that if the user uses the back
	 * button, or refreshes the page they will stay at the position they last loaded.
	 */
	var url = function() {

		// Doesn't work in IE.
		if ( !window.history.pushState ) {

			return;

		}

		var slug = toolbelt_is.permalink.replace( '%d', toolbelt_is.page );

		if ( window.location.href !== slug ) {

			history.pushState( null, null, slug );
			document.body.dispatchEvent( new Event( 'toolbelt-is-load' ) );

		}

	};

	/**
	 * Get the new blog posts.
	 *
	 * Uses the rest api to grab the next page of posts to display.
	 */
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

				// No more posts to display so hide the 'load more' button.
				if ( !response.html ) {
					document.body.classList.add( 'toolbelt-infinite-scroll-end' );
				}

				var button = document.querySelector( '.toolbelt-infinite-scroll-wrapper button' );
				button.style.display = 'inline';

				var spinner = document.querySelector( '.toolbelt-infinite-scroll-wrapper .toolbelt-spinner' );
				spinner.style.display = 'none';

				/**
				 * Update the page url to signify the loading of the page, and
				 * so that refreshing and the back button work appropriately.
				 */
				url();

				/**
				 * Dispatch an event so that themes and plugins know when posts
				 * have loaded.
				 *
				 * This is helpful for people using Masonry who need to
				 * rearrange content.
				 *
				 * The 'load-post' name comes from Jetpack, and I am using it
				 * for backwards (sideways?) compatability.
				 */
				document.body.dispatchEvent( new Event( 'load-post' ) );

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