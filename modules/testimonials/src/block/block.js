( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { InspectorControls } = wp.blockEditor;
	const { RangeControl, RadioControl, PanelBody } = wp.components;
	const ServerSideRender = wp.serverSideRender;
	const { __ } = wp.i18n;

	registerBlockType(
		'toolbelt/testimonials',
		{
			title: __( 'Testimonials', 'wp-toolbelt' ),

			icon: 'testimonial',

			description: __( 'Display a grid of Toolbelt Testimonials.', 'wp-toolbelt' ),

			keywords: [ __( 'toolbelt', 'wp-toolbelt' ) ],

			category: 'wp-toolbelt',

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
				}
			},

			edit( props ) {

				const attributes = props.attributes;
				const setAttributes = props.setAttributes;

				// Function to update the number of rows.
				const changeRows = ( rows ) => {
					setAttributes( { rows } );
				}

				// Function to update the number of columns.
				const changeColumns = ( columns ) => {
					setAttributes( { columns } );
				}

				// Function to update the testimonial order.
				const changeOrderby = ( orderby ) => {
					setAttributes( { orderby } );
				}

				return [
					<ServerSideRender
						block="toolbelt/testimonials"
						attributes={attributes}
					/>,
					<InspectorControls>
						<PanelBody
							title={__( 'Layout', 'wp-toolbelt' )}
							initialOpen={true}
						>

							<RangeControl
								value={attributes.rows}
								label={__( 'Rows', 'wp-toolbelt' )}
								onChange={changeRows}
								min={1}
								max={10}
							/>

							<RangeControl
								value={attributes.columns}
								label={__( 'Columns', 'wp-toolbelt' )}
								onChange={changeColumns}
								min={1}
								max={4}
							/>

							<RadioControl
								selected={attributes.orderby}
								label={__( 'Order by', 'wp-toolbelt' )}
								onChange={changeOrderby}
								options={
									[
										{ value: 'date', label: __( 'date', 'wp-toolbelt' ) },
										{ value: 'rand', label: __( 'random', 'wp-toolbelt' ) },
									]
								}
							/>

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
