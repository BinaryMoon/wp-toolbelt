( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement, Fragment, Component } = wp.element;
	const {
		Path,
		SVG,
		CheckboxControl,
		SelectControl,
		PanelBody,
		RangeControl,
		RadioControl,
	} = wp.components;
	const ServerSideRender = wp.serverSideRender;
	const { __ } = wp.i18n;
	const {
		BlockIcon,
		InspectorControls,
	} = wp.blockEditor;

	const layouts = [
		{
			label: 'list',
			value: '1',
		},
		{
			label: 'large image',
			value: '2',
		},
		{
			label: 'small image',
			value: '3',
		},
		{
			label: 'excerpt',
			value: '4',
		},
	];

	registerBlockType(
		'toolbelt/post-category',
		{

			title: __( 'TB Post Category', 'wp-toolbelt' ),

			description: __( 'A summary of recent posts from the selected category.', 'wp-toolbelt' ),

			keywords: [ __( 'toolbelt', 'wp-toolbelt' ), __( 'recent post category', 'wp-toolbelt' ) ],

			icon: 'networking',

			category: 'wp-toolbelt',

			attributes: {
				category: {
					default: '',
					type: 'string',
				},
				count: {
					default: 10,
					type: 'int',
				},
				layout: {
					default: '1',
					type: 'string',
				},
			},

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
			],

			save() {
				return null;
			},

			/**
			 * Edit the settings.
			 */
			edit( props ) {

				const { attributes, setAttributes } = props;
				const { category, count, layout } = attributes;

				return [
					<ServerSideRender
						block="toolbelt/post-category"
						attributes={props.attributes}
					/>,
					<InspectorControls>
						<PanelBody
							title={__( 'Sections', 'wp-toolbelt' )}
							initialOpen={true}
						>
							<SelectControl
								label={__( 'Category', 'wp-toolbelt' )}
								options={toolbelt_post_categories}
								value={category}
								onChange={( new_category ) => { setAttributes( { category: new_category } ) }}
							/>
							<RangeControl
								label={__( 'Number of Posts', 'wp-toolbelt' )}
								min={3}
								max={19}
								value={count}
								onChange={( new_count ) => { setAttributes( { count: new_count } ) }}
							/>
							<RadioControl
								label={__( 'Layout', 'wp-toolbelt' )}
								options={layouts}
								onChange={( new_layout ) => { setAttributes( { layout: new_layout } ) }}
								selected={layout}
							/>
						</PanelBody>
					</InspectorControls>,
				];

			},


		}
	);

} )();
