
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
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 208 128">
					<Rect
						width="198"
						height="118"
						x="5"
						y="5"
						ry="10"
						stroke="currentColor"
						strokeWidth="10"
						fill="none"
					/>
					<Path d="M30 98v-68h20l20 25 20-25h20v68h-20v-39l-20 25-20-25v39zM155 98l-30-33h20v-35h20v35h20z" />
				</svg>
			)
		},

		category: 'wp-toolbelt',

		attributes: {
			columnWidth: {
				type: 'int',
			},
			backgroundColor: {
				type: 'string',
			},
			textColor: {
				type: 'string',
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
