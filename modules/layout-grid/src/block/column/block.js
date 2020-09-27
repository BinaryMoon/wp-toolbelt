
//=require ./save.js
//=require ./edit.js


registerBlockType(
	'toolbelt/column',
	{

		title: __( 'TB Column', 'wp-toolbelt' ),

		description: __( 'Columns for your layout.', 'wp-toolbelt' ),

		parent: [ 'toolbelt/layout-grid' ],

		styles: [
			{
				name: 'normal',
				label: __( 'Default', 'wp-toolbelt' ),
				isDefault: true,
			},
			{
				name: 'border-top',
				label: __( 'Border Top', 'wp-toolbelt' ),
			},
			{
				name: 'padded',
				label: __( 'Has Padding', 'wp-toolbelt' ),
			},
		],

		icon: {
			src: (
				<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60">
					<rect width="40" height="40" x="10" y="10" fill="#000000" fill-rule="evenodd" />
				</svg>
			)
		},

		save: colSave,

		edit: colEdit,

	}
);
