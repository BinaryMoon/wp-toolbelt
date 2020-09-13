
//=require ./save.js
//=require ./edit.js


registerBlockType(
	'toolbelt/slider',
	{

		title: __( 'TB Slider', 'wp-toolbelt' ),

		description: __( 'A simple accessible CSS slider.', 'wp-toolbelt' ),

		keywords: [
			__( 'toolbelt', 'wp-toolbelt' ),
			__( 'slider', 'wp-toolbelt' )
		],

		icon: {
			src: (
				<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60">
					<g fill="none" fill-rule="evenodd">
						<rect width="30" height="30" x="15" y="15" fill="#000000" rx="3" />
						<path fill="#000000" d="M13 18L13 42 11 42C9.8954305 42 9 41.1045695 9 40L9 20C9 18.8954305 9.8954305 18 11 18L13 18zM49 18C50.1045695 18 51 18.8954305 51 20L51 40C51 41.1045695 50.1045695 42 49 42L47 42 47 18 49 18zM7 21L7 39 5 39C3.8954305 39 3 38.1045695 3 37L3 23C3 21.8954305 3.8954305 21 5 21L7 21zM55 21C56.1045695 21 57 21.8954305 57 23L57 37C57 38.1045695 56.1045695 39 55 39L53 39 53 21 55 21z" />
					</g>
				</svg>
			)
		},

		styles: [
			{
				name: 'normal',
				label: __( 'Simple', 'wp-toolbelt' ),
				isDefault: true,
			},
			{
				name: 'padding',
				label: __( 'With padding', 'wp-toolbelt' ),
			},
			{
				name: 'border',
				label: __( 'With border', 'wp-toolbelt' ),
			}
		],

		category: 'wp-toolbelt',

		attributes: {
			columnWidth: {
				type: 'int',
			},
			textAlignment: {
				type: 'string',
			},
			slideWidth: {
				type: 'string',
				default: 'M',
			},
		},

		supports: {
			align: [ 'full', 'wide' ],
		},

		/**
		 * Save the formatted markdown content.
		 */
		save: sliderSave,

		/**
		 * Edit the settings.
		 */
		edit: sliderEdit,

	}
);
