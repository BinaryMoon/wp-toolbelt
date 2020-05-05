
//
registerBlockType(
	'toolbelt/layout-grid',
	{

		title: __( 'Layout Grid', 'wp-toolbelt' ),

		description: __( 'Flexible content display', 'wp-toolbelt' ),

		keywords: [ __( 'toolbelt', 'wp-toolbelt' ), __( 'layout grid columns', 'wp-toolbelt' ) ],

		icon: 'editor-table',

		category: 'wp-toolbelt',

		attributes: {
			columns: {
				type: 'int',
			},
			pattern: {
				type: 'string',
			},
		},

		supports: {
			align: [ 'full', 'wide' ],
		},

		save() {
		},

		/**
		 * Edit the settings.
		 */
		edit: gridEdit,

	}
);