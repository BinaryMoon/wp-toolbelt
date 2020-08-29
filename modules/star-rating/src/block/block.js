(
	function() {

		const { registerBlockType } = wp.blocks;
		const { createElement } = wp.element;
		const {
			AlignmentToolbar,
			BlockControls,
			InspectorControls,
			PanelColorSettings,
		} = wp.blockEditor;
		const {
			RangeControl,
			PanelBody,
			Path,
			SVG,
		} = wp.components;
		const { ENTER } = wp.keycodes;
		const { __, _x, sprintf } = wp.i18n;

		//=require ./icon.js
		//=require ./edit.js
		//=require ./save.js

		const range = ( start, end, step = 1 ) => {

			let index = -1;
			let length = Math.max( Math.ceil( ( end - start ) / step ), 0 );
			let result = Array( length );

			while ( length-- ) {
				result[ ++index ] = start;
				start += step;
			}

			return result;

		};

		registerBlockType(
			'toolbelt/star-rating',
			{
				title: __( 'Star Rating', 'wp-toolbelt' ),

				icon: StarIcon,

				description: __( 'Add star ratings.', 'wp-toolbelt' ),

				category: 'wp-toolbelt',

				keywords: [
					_x( 'star stars rating rate', 'block search term', 'wp-toolbelt' ),
					_x( 'toolbelt', 'block search term', 'wp-toolbelt' )
				],

				attributes: {
					rating: {
						type: 'number',
						default: 1,
					},
					maxRating: {
						type: 'number',
						default: 5,
					},
					color: {
						type: 'string',
					},
					align: {
						type: 'string',
						default: 'left',
					},
				},

				edit,

				save

			}
		);

	}
)();
