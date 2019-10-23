( function() {

	const { registerBlockType } = wp.blocks;
	const { createElement, Fragment, Component, RawHTML } = wp.element;
	const { ExternalLink, Path, Rect, SVG } = wp.components;
	const { __ } = wp.i18n;
	const { PlainText } = wp.blockEditor;

	const exampleTitle = __( 'Try Markdown', 'wp-toolbelt' );
	const exampleDescription = __(
		'Markdown is a text formatting syntax that is converted into HTML. You can _emphasize_ text or **make it strong** with just a few characters.',
		'wp-toolbelt'
	);

	registerBlockType(
		'toolbelt/markdown',
		{

			title: __( 'Markdown', 'wp-toolbelt' ),

			description: (
				<Fragment>
					<p>
						{__( 'Use regular characters and punctuation to style text, links, and lists.', 'wp-toolbelt' )}
					</p>
					<ExternalLink href="https://en.support.wordpress.com/markdown-quick-reference/">
						{__( 'Support reference', 'wp-toolbelt' )}
					</ExternalLink>
				</Fragment>
			),

			keywords: [ __( 'toolbelt', 'wp-toolbelt' ) ],

			icon: {
				src: (
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 208 128">
						<Rect
							width="198"
							height="118"
							x="5"
							y="5"
							ry="10"
							stroke="currentColor"
							strokeWidth="10"
							fill="none"
						/>
						<Path d="M30 98v-68h20l20 25 20-25h20v68h-20v-39l-20 25-20-25v39zM155 98l-30-33h20v-35h20v35h20z" />
					</svg>
				)
			},

			category: 'common',

			attributes: {
				source: {
					type: 'string',
				},
			},

			supports: {
				html: false,
			},

			/**
			 * Save the formatted markdown content.
			 */
			save( props ) {

				const { attributes, className } = props;
				const { source } = attributes;

				return (
					<RawHTML className={className}>
						{source.length ? marked( source ) : ''}
					</RawHTML>
				);

			},

			/**
			 * Edit the settings.
			 */
			edit( props ) {

				const { attributes, isSelected, className } = props;
				const { source } = attributes;

				/**
				 * Check to see if the markdown content is empty or not.
				 */
				const isEmpty = () => {
					return !source || source.trim() === '';
				}

				/**
				 * Upadte the markdown content attribute.
				 */
				const updateSource = ( source ) => {
					props.setAttributes( { source } );
				}

				/**
				 * Display a placeholder.
				 */
				if ( !isSelected && isEmpty() ) {
					return (
						<p className={className}>
							<strong>{__( 'Write your _Markdown_ **here**…', 'wp-toolbelt' )}</strong>
						</p>
					);
				}

				/**
				 * Render the markdown content.
				 */
				if ( !isSelected && !isEmpty() ) {
					return (
						<RawHTML className={className}>
							{source.length ? marked( source ) : ''}
						</RawHTML>
					)
				}

				/**
				 * Edit the markdown content.
				 */
				return (
					<div className={className}>
						<PlainText
							placeholder={__( 'Write your _Markdown_ **here**…', 'wp-toolbelt' )}
							value={source}
							onChange={updateSource}
						></PlainText >
					</div>
				);

			},

			example: {
				attributes: {
					source: `## ## ${exampleTitle}\n\n${exampleDescription}`,
				},
			}

		}
	);

} )();
