

registerBlockType(
	'toolbelt/layout-column',
	{

		title: __( 'Layout Grid Column', 'wp-toolbelt' ),

		description: __( 'Flexible content display', 'wp-toolbelt' ),

		keywords: [ __( 'toolbelt', 'wp-toolbelt' ), __( 'layout grid columns', 'wp-toolbelt' ) ],

		icon: 'table',

		category: 'wp-toolbelt',

		parent: [ 'toolbelt/layout-grid' ],


		attributes: {
		},

		save() {
		},

		/**
		 * Edit the settings.
		 */
		edit( props ) {

			const { attributes, setAttributes, instanceId } = props;
			const { url } = attributes;

			return (
				<div className="toolbelt-layout-column">

				</div>
			)
		},

	}
);