/**
 * External dependencies
 */

/**
 * These are the blocks allowed inside the contact form.
 *
 * Non form elements are allowed so that we can include descriptions and other
 * things related to the form. When the form is submitted these elements will
 * get removed, and replaced with the 'submission complete' message.
 */
const ALLOWED_BLOCKS = [
	'toolbelt/markdown',
	'core/paragraph',
	'core/heading',
	'core/list',
	'core/separator',
	'core/spacer',
	'core/subhead',
	'core/quote',
	'core/image',
];

const edit = ( props ) => {

	const { attributes, setAttributes } = props;
	const { subject, to, submitButtonText, messageConfirmation, layout } = attributes;

	const form_settings = [
		<TextControl
			label={__( 'Email address', 'wp-toolbelt' )}
			value={to}
			placeholder={__( 'name@example.com', 'wp-toolbelt' )}
			help={__( 'You can enter multiple email addresses separated by commas.', 'wp-toolbelt' )}
			onChange={value => setAttributes( { to: value } )}
		/>,
		<TextControl
			label={__( 'Email subject line', 'wp-toolbelt' )}
			value={subject}
			placeholder={__( "Let's work together", 'wp-toolbelt' )}
			onChange={value => setAttributes( { subject: value } )}
		/>,
		<p className="toolbelt-contact-description">
			{__(
				'(If you leave these blank, notifications will go to the author with the post or page title as the subject line.)',
				'wp-toolbelt'
			)}
		</p>
	];

	let template = layout;
	if ( !formTemplate[ layout ] ) {
		template = 'default';
	}

	return [
		<InspectorControls>

			<PanelBody
				title={__( 'Email Feedback Settings', 'wp-toolbelt' )}
				initialOpen={true}
			>

				{form_settings}

			</PanelBody>

			<PanelBody
				title={__( 'Messages', 'wp-toolbelt' )}
			>

				<TextControl
					label={__( 'Submit Button Text', 'wp-toolbelt' )}
					value={submitButtonText}
					onChange={value => setAttributes( { submitButtonText: value } )}
				/>

				<TextareaControl
					label={__( 'Confirmation Message' )}
					value={messageConfirmation}
					onChange={value => setAttributes( { messageConfirmation: value } )}
				/>

			</PanelBody>

		</InspectorControls>,
		<Fragment>

			<Placeholder
				icon="email"
				label={__( 'Contact Form', 'wp-toolbelt' )}
				className="toolbelt-contact-form-settings"
			>

				<form>

					{form_settings}

				</form>

			</Placeholder>

			<InnerBlocks
				allowedBlocks={ALLOWED_BLOCKS}
				templateLock={false}
				template={formTemplate[ template ]}
			/>

			<button disabled>{submitButtonText}</button>

		</Fragment >
	];

};
