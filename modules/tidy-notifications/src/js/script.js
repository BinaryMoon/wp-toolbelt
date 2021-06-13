; ( function( $ ) {

	/**
	 * Our notification container.
	 */
	let $container = null;

	/**
	 * List of the notification widgets to hide.
	 * This may grow quite long.
	 */
	const notice_selectors = [
		'#wpwrap .notice',
		'#wpwrap .woocommerce-message',
	];


	/**
	 * Add the notification container.
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
	 */
	const moveNotices = () => {

		const selectors = notice_selectors.join( ', ' );

		$( selectors )
			.not( '.notice-success' )
			.not( '.notice-error' )
			.not( '.notice-failure' )
			.prependTo( $container );

		const notification_count = $container.find( '> div' )
			.filter( ':visible' )
			.size();

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

