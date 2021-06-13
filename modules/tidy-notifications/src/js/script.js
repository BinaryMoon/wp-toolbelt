; ( function( $ ) {

	/**
	 * Our notification container.
	 */
	let $container = null;

	/**
	 * List of the notification widgets to hide.
	 * This may grow quite long.
	 *
	 * Note that .notice-success, and .notice-error are filtered out so that
	 * errors and success messages can be seen like normal.
	 */
	const notice_selectors = [
		'#wpwrap .notice',
		'#wpwrap .woocommerce-message',
	];


	/**
	 * Add the notification container.
	 *
	 * @return {void}
	 */
	const addContainer = () => {

		const $report_notification = $( '<a></a>' )
			.html( 'Report Missed Notification' )
			.addClass( 'toolbelt-report-notification' )
			.attr( 'target', '_blank' )
			.attr( 'href', 'https://github.com/BinaryMoon/wp-toolbelt/issues/new?assignees=&labels=&template=report-missed-plugin-notification.md&title=' );

		$container = $( '<div></div>' )
			.addClass( 'toolbelt-notication-container' );

		$container.append( $report_notification );

		$( 'body' ).append( $container );

	};


	/**
	 * Move the notices into the container.
	 *
	 * @return {void}
	 */
	const moveNotices = () => {

		// Join the global selectors into a jQuery selector string.
		const selectors = notice_selectors.join( ', ' );

		/**
		 * Grab the notices and exclude things users might want to see.
		 */
		$( selectors )
			.not( '.notice-success' )
			.not( '.notice-error' )
			.not( '.notice-failure' )
			.prependTo( $container );

		/**
		 * Could the notifications. We have to ignore hidden ones that it
		 * appears some people use.
		 */
		const notification_count = $container.find( '> div' )
			.filter( ':visible' )
			.size();

		/**
		 * If there are notifications then display the admin bar toggle.
		 * Otherwise there's no toggle. No point showing users an empty sidebar.
		 */
		if ( notification_count > 0 ) {

			const $menu_item = $( '#wp-admin-bar-toolbelt-notifications-menu' );

			$menu_item.find( '.ab-label' ).html( notification_count );

			$menu_item
				.addClass( 'toolbelt-display' )
				.on(
					'click',
					( e ) => {
						e.preventDefault();
						$container.toggleClass( 'toolbelt-display' );
					}
				);

		}

	};

	$( document ).ready(
		() => {
			addContainer();
			setTimeout( moveNotices, 500 );
		}
	);

} )( jQuery );

