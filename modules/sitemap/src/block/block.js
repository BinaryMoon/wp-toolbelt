( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement, Fragment, Component, RawHTML } = wp.element;
	const {
		Path,
		SVG,
		CheckboxControl,
		PanelBody,
	} = wp.components;
	const ServerSideRender = wp.serverSideRender;
	const { __ } = wp.i18n;
	const {
		BlockIcon,
		InspectorControls,
	} = wp.blockEditor;

	registerBlockType(
		'toolbelt/sitemap',
		{

			title: __( 'TB Sitemap', 'wp-toolbelt' ),

			description: __( 'Display your Sitemap', 'wp-toolbelt' ),

			keywords: [ __( 'toolbelt', 'wp-toolbelt' ), __( 'sitemap', 'wp-toolbelt' ) ],

			icon: 'networking',

			category: 'wp-toolbelt',

			attributes: {
				posts: {
					default: true,
					type: 'boolean',
				},
				pages: {
					default: true,
					type: 'boolean',
				},
				categories: {
					default: true,
					type: 'boolean',
				},
			},

			save() {
				return null;
			},

			/**
			 * Edit the settings.
			 */
			edit( props ) {

				const { attributes, setAttributes } = props;
				const { categories, pages, posts } = attributes;

				return [
					<ServerSideRender
						block="toolbelt/sitemap"
						attributes={props.attributes}
					/>,
					<InspectorControls>
						<PanelBody
							title={__( 'Sections', 'wp-toolbelt' )}
							initialOpen={true}
						>
							<CheckboxControl
								label={__( 'Categories', 'wp-toolbelt' )}
								checked={categories}
								onChange={( val ) => { setAttributes( { categories: val } ) }}
							/>
							<CheckboxControl
								label={__( 'Pages', 'wp-toolbelt' )}
								checked={pages}
								onChange={( val ) => { setAttributes( { pages: val } ) }}
							/>
							<CheckboxControl
								label={__( 'Posts', 'wp-toolbelt' )}
								checked={posts}
								onChange={( val ) => { setAttributes( { posts: val } ) }}
							/>
						</PanelBody>
					</InspectorControls>,
				];

			},


		}
	);

} )();
