( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { InspectorControls } = wp.blockEditor;
	const { PanelBody } = wp.components;
	const ServerSideRender = wp.serverSideRender;
	const { __, _x } = wp.i18n;

	registerBlockType(
		'toolbelt/breadcrumbs',
		{
			title: __( 'Breadcumbs', 'wp-toolbelt' ),

			icon: 'menu-alt2',

			description: __( 'Display breadcrumbs for the current page.', 'wp-toolbelt' ),

			category: 'wp-toolbelt',

			keywords: [
				_x( 'breadcrumbs', 'block search term', 'wp-toolbelt' ),
				_x( 'toolbelt', 'block search term', 'wp-toolbelt' )
			],

			supports: {
				align: [ 'full', 'wide' ],
			},

			edit( props ) {

				return [
					<ServerSideRender
						block="toolbelt/breadcrumbs"
						attributes={props.attributes}
					/>,
					<InspectorControls>
						<PanelBody
							title={__( 'Important Note', 'wp-toolbelt' )}
							initialOpen={true}
						>
							<p>{__( 'The breadcrumb output may differ from what is shown in the block preview.', 'wp-toolbelt' )}</p>
							<p>{__( 'The breadcrumb block does not display on the front page.', 'wp-toolbelt' )}</p>
						</PanelBody>
					</InspectorControls>
				];

			},

			save() {
				return null;
			}
		}
	);

} )();
