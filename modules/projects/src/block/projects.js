const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { RangeControl, SelectControl, PanelBody } = wp.components;
const { __ } = wp.i18n;

registerBlockType(
	'toolbelt/portfolio',
	{
		title: __( 'Portfolio' ),

		icon: 'portfolio',

		description: __( 'Display a grid of Toolbelt Projects.' ),

		category: __( 'common' ),

		keywords: [ __( 'projects' ), __( 'toolbelt' ) ],

		supports: {
			align: [ 'full', 'wide' ],
		},

		attributes: {
			rows: {
				default: 2,
			},
			columns: {
				default: 2
			},
			orderby: {
				default: 'date'
			},
			category: {
				default: ''
			}
		},

		edit( props ) {

			const attributes = props.attributes;
			const setAttributes = props.setAttributes;

			// Function to update the number of rows.
			function changeRows( rows ) {
				setAttributes( { rows } );
			}

			// Function to update the number of columns.
			function changeColumns( columns ) {
				setAttributes( { columns } );
			}

			// Function to update the testimonial order.
			function changeOrderby( orderby ) {
				setAttributes( { orderby } );
			}

			return createElement(
				'div',
				{},
				[

					// Editor Preview.
					createElement(
						wp.serverSideRender,
						{
							block: 'toolbelt/portfolio',
							attributes: attributes
						}
					),

					// Sidebar Controls.
					createElement(
						InspectorControls,
						{},
						[
							createElement(
								PanelBody,
								{
									title: __( 'Layout' ),
									initialOpen: true,
								},
								[
									// Rows.
									createElement(
										RangeControl,
										{
											value: attributes.rows,
											label: __( 'Rows' ),
											onChange: changeRows,
											min: 1,
											max: 10
										}
									),

									// Columns.
									createElement(
										RangeControl,
										{
											value: attributes.columns,
											label: __( 'Columns' ),
											onChange: changeColumns,
											min: 1,
											max: 4
										}
									),

									// Order.
									createElement(
										SelectControl,
										{
											value: attributes.orderby,
											label: __( 'Orderby' ),
											onChange: changeOrderby,
											options: [
												{ value: 'date', label: __( 'date' ) },
												{ value: 'rand', label: __( 'rand' ) },
											]
										}
									)
								]
							)
						]
					)
				]
			);
		},

		save() {
			return null;
		}
	}
);