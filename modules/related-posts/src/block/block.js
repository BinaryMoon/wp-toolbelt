( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { InspectorControls } = wp.blockEditor;
	const { PanelBody } = wp.components;
	const ServerSideRender = wp.serverSideRender;
	const { __, _x } = wp.i18n;

	//=require ./icon.js

	console.log( 'related posts' );

	registerBlockType(
		'toolbelt/related-posts',
		{
			title: __( 'TB Related Posts', 'wp-toolbelt' ),

			icon,

			description: __( 'Display related posts for the current post.', 'wp-toolbelt' ),

			category: 'wp-toolbelt',

			keywords: [
				_x( 'related posts', 'block search term', 'wp-toolbelt' ),
				_x( 'toolbelt', 'block search term', 'wp-toolbelt' )
			],

			supports: {
				align: [ 'full', 'wide' ],
			},

			edit( props ) {

				return [
					<ServerSideRender
						block="toolbelt/related-posts"
						attributes={props.attributes}
					/>,
					<InspectorControls>
						<PanelBody
							title={__( 'Important Note', 'wp-toolbelt' )}
							initialOpen={true}
						>
							<p>{__( 'The related posts block will only display on post types that support related posts.', 'wp-toolbelt' )}</p>
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
