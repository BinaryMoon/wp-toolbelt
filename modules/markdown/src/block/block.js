const { registerBlockType } = wp.blocks;
const { createElement, Fragment } = wp.element;
const { ExternalLink, Path, Rect, SVG, TextareaControl } = wp.components;
const { __ } = wp.i18n;

registerBlockType(
	'toolbelt/markdown',
	{
		title: __( 'Markdown', 'wp-toolbelt' ),

		description: (
			<Fragment>
				<p>
					{__(
						'Use regular characters and punctuation to style text, links, and lists.',
						'wp-toolbelt'
					)}
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

		edit() {
			return (
				<TextareaControl
					placeholder={__( 'Enter your Markdown here', 'wp-toolbelt' )}
				/>
			);
		},

		save() {
			return null;
		}
	}
)
