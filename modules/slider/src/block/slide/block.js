
//=require ./save.js
//=require ./edit.js


registerBlockType(
	'toolbelt/slide',
	{

		title: __( 'TB Slide', 'wp-toolbelt' ),

		description: __( 'A simple accessible CSS slider.', 'wp-toolbelt' ),

		parent: [ 'toolbelt/slider' ],

		icon: {
			src: (
				<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60">
					<rect width="40" height="40" x="10" y="10" fill="#000000" fill-rule="evenodd" />
				</svg>
			)
		},

		attributes: {
			title: {
				type: 'string',
			},
			description: {
				type: 'string',
			},
			link: {
				type: 'string',
			},
			mediaId: {
				type: 'number',
				default: 0
			},
			mediaUrl: {
				type: 'string',
				default: ''
			},
		},

		/**
		 * Save the formatted markdown content.
		 */
		save: slideSave,

		/**
		 * Edit the settings.
		 */
		edit: withSelect(
			( select, props ) => {
				return {
					media: props.attributes.mediaId ? select( 'core' ).getMedia( props.attributes.mediaId ) : undefined
				};
			}
		)( slideEdit ),

	}
);
