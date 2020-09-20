
//=require ./column-layouts.js
//=require ./inspector.js
//=require ./edit.js
//=require ./save.js

registerBlockType(
	'toolbelt/layout-grid',
	{

		title: __( 'TB Layout Grid', 'wp-toolbelt' ),

		description: __( 'Flexible content display', 'wp-toolbelt' ),

		keywords: [ __( 'toolbelt', 'wp-toolbelt' ), __( 'layout grid columns', 'wp-toolbelt' ) ],

		icon: 'editor-table',

		category: 'wp-toolbelt',

		attributes: {
			columns: {
				type: 'int',
			},
			layout: {
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

		save: gridSave,

		edit: gridEdit,

	}
);
