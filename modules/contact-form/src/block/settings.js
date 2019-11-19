
const renderMaterialIcon = svg => (
	<SVG xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
		<Path fill="none" d="M0 0h24v24H0V0z" />
		{svg}
	</SVG>
);

const settings = {

	title: __( 'Contact Form', 'wp-toolbelt' ),

	description: __( 'Use the form builder to create your own forms.', 'wp-toolbelt' ),

	icon: 'email',

	category: 'wp-toolbelt',

	keywords: [
		_x( 'email contact', 'block search term', 'wp-toolbelt' ),
		_x( 'feedback', 'block search term', 'wp-toolbelt' ),
		_x( 'toolbelt', 'block search term', 'wp-toolbelt' ),
	],

	supports: {
		reusable: false,
		html: false,
	},

	attributes: {
		subject: {
			type: 'string',
			default: '',
		},
		to: {
			type: 'string',
			default: '',
		},
		submitButtonText: {
			type: 'string',
			default: __( 'Submit', 'wp-toolbelt' ),
		},
		customThankyou: {
			type: 'string',
			default: '',
		},
		customThankyouMessage: {
			type: 'string',
			default: '',
		},
		customThankyouRedirect: {
			type: 'string',
			default: '',
		},
	},

	save: () => <InnerBlocks.Content />,

	edit,

	example: {
		attributes: {
			submitButtonText: __( 'Submit', 'wp-toolbelt' ),
		},
		innerBlocks: [
			{
				name: 'toolbelt/field-name',
				attributes: {
					label: __( 'Name', 'wp-toolbelt' ),
					required: true,
				},
			},
			{
				name: 'toolbelt/field-email',
				attributes: {
					label: __( 'Email', 'wp-toolbelt' ),
					required: true,
				},
			},
			{
				name: 'toolbelt/field-textarea',
				attributes: {
					label: __( 'Message', 'wp-toolbelt' ),
				},
			},
		],
	}
};

const AttributeDefaults = {
	label: {
		type: 'string',
		default: null,
	},
	required: {
		type: 'boolean',
		default: false,
	},
	description: {
		type: 'string',
		default: '',
	},
	options: {
		type: 'array',
		default: [],
	},
	defaultValue: {
		type: 'string',
		default: '',
	},
	placeholder: {
		type: 'string',
		default: '',
	},
}

const FieldTransforms = {
	to: [
		{
			type: 'block',
			blocks: [ 'toolbelt/field-text' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-text', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-name' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-name', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-email' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-email', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-url' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-url', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-date' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-date', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-telephone' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-telephone', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-textarea' ],
			isMatch: ( { options } ) => !options.length,
			transform: attributes => createBlock( 'toolbelt/field-textarea', attributes ),
		},
	],
};

const MultiFieldTransforms = {
	to: [
		{
			type: 'block',
			blocks: [ 'toolbelt/field-checkbox-multiple' ],
			isMatch: ( { options } ) => 1 <= options.length,
			transform: attributes => createBlock( 'toolbelt/field-checkbox-multiple', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-radio' ],
			isMatch: ( { options } ) => 1 <= options.length,
			transform: attributes => createBlock( 'toolbelt/field-radio', attributes ),
		},
		{
			type: 'block',
			blocks: [ 'toolbelt/field-select' ],
			isMatch: ( { options } ) => 1 <= options.length,
			transform: attributes => createBlock( 'toolbelt/field-select', attributes ),
		},
	]
};

const FieldDefaults = {
	category: 'wp-toolbelt',
	parent: [ 'toolbelt/contact-form' ],
	supports: {
		reusable: false,
		html: false,
	},
	attributes: AttributeDefaults,
	transforms: FieldTransforms,
	save: () => null,
};

const getFieldLabel = ( { attributes, name: blockName } ) => {

	return null === attributes.label ? getBlockType( blockName ).title : attributes.label;

};

const editField = type => props => (

	<ToolbeltField
		type={type}
		label={getFieldLabel( props )}
		required={props.attributes.required}
		description={props.attributes.description}
		setAttributes={props.setAttributes}
		isSelected={props.isSelected}
		defaultValue={props.attributes.defaultValue}
		placeholder={props.attributes.placeholder}
		id={props.attributes.id}
	/>

);

const editMultiField = type => props => (

	<ToolbeltFieldMultiple
		label={getFieldLabel( props )}
		required={props.attributes.required}
		options={props.attributes.options}
		description={props.attributes.description}
		setAttributes={props.setAttributes}
		type={type}
		isSelected={props.isSelected}
		id={props.attributes.id}
	/>

);


const childBlocks = [
	{
		name: 'field-text',
		settings: {
			...FieldDefaults,
			title: __( 'Text', 'wp-toolbelt' ),
			description: __( 'When you need just a small amount of text, add a text input.', 'wp-toolbelt' ),
			icon: renderMaterialIcon( <Path d="M4 9h16v2H4V9zm0 4h10v2H4v-2z" /> ),
			edit: editField( 'text' ),
		},
	},
	{
		name: 'field-name',
		settings: {
			...FieldDefaults,
			title: __( 'Name', 'wp-toolbelt' ),
			description: __(
				'Introductions are important. Add an input for folks to add their name.',
				'wp-toolbelt'
			),
			icon: renderMaterialIcon(
				<Path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
			),
			edit: editField( 'text' ),
		},
	},
	{
		name: 'field-email',
		settings: {
			...FieldDefaults,
			title: __( 'Email', 'wp-toolbelt' ),
			keywords: [ __( 'e-mail', 'wp-toolbelt' ), __( 'mail', 'wp-toolbelt' ), 'email' ],
			description: __( 'Want to reply to folks? Add an email address input.', 'wp-toolbelt' ),
			attributes: {
				...AttributeDefaults,
				placeholder: {
					type: 'string',
					default: 'name@domain.com',
				}
			},
			icon: renderMaterialIcon(
				<Path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z" />
			),
			edit: editField( 'email' ),
		},
	},

	{
		name: 'field-url',
		settings: {
			...FieldDefaults,
			title: __( 'Website', 'wp-toolbelt' ),
			keywords: [ 'url', __( 'internet page', 'wp-toolbelt' ), 'link' ],
			description: __( 'Add an address input for a website.', 'wp-toolbelt' ),
			attributes: {
				...AttributeDefaults,
				placeholder: {
					type: 'string',
					default: 'https://domain.com',
				}
			},
			icon: renderMaterialIcon(
				<Path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
			),
			edit: editField( 'url' ),
		},
	},

	{
		name: 'field-date',
		settings: {
			...FieldDefaults,
			title: __( 'Date Picker', 'wp-toolbelt' ),
			keywords: [
				__( 'Calendar', 'wp-toolbelt' ),
				__( 'day month year', 'block search term', 'wp-toolbelt' ),
			],
			description: __( 'The best way to set a date. Add a date picker.', 'wp-toolbelt' ),
			icon: renderMaterialIcon(
				<Path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V9h14v10zm0-12H5V5h14v2zM7 11h5v5H7z" />
			),
			edit: editField( 'text' ),
		},
	},
	{
		name: 'field-telephone',
		settings: {
			...FieldDefaults,
			title: __( 'Telephone', 'wp-toolbelt' ),
			keywords: [
				__( 'Phone', 'wp-toolbelt' ),
				__( 'Cellular phone', 'wp-toolbelt' ),
				__( 'Mobile', 'wp-toolbelt' ),
			],
			description: __( 'Add a phone number input.', 'wp-toolbelt' ),
			icon: renderMaterialIcon(
				<Path d="M6.54 5c.06.89.21 1.76.45 2.59l-1.2 1.2c-.41-1.2-.67-2.47-.76-3.79h1.51m9.86 12.02c.85.24 1.72.39 2.6.45v1.49c-1.32-.09-2.59-.35-3.8-.75l1.2-1.19M7.5 3H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.49c0-.55-.45-1-1-1-1.24 0-2.45-.2-3.57-.57-.1-.04-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.45-5.15-3.76-6.59-6.59l2.2-2.2c.28-.28.36-.67.25-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1z" />
			),
			edit: editField( 'tel' ),
		},
	},
	{
		name: 'field-textarea',
		settings: {
			...FieldDefaults,
			title: __( 'Message', 'wp-toolbelt' ),
			keywords: [ __( 'Textarea', 'wp-toolbelt' ), 'textarea', __( 'Multiline text', 'wp-toolbelt' ) ],
			description: __(
				'Let folks speak their mind. This text box is great for longer responses.',
				'wp-toolbelt'
			),
			icon: renderMaterialIcon( <Path d="M21 11.01L3 11v2h18zM3 16h12v2H3zM21 6H3v2.01L21 8z" /> ),
			edit: props => (
				<ToolbeltFieldTextarea
					label={getFieldLabel( props )}
					required={props.attributes.required}
					setAttributes={props.setAttributes}
					isSelected={props.isSelected}
					defaultValue={props.attributes.defaultValue}
					placeholder={props.attributes.placeholder}
					id={props.attributes.id}
				/>
			),
		},
	},
	{
		name: 'field-checkbox',
		settings: {
			...FieldDefaults,
			title: __( 'Checkbox', 'wp-toolbelt' ),
			keywords: [ __( 'Confirm', 'wp-toolbelt' ), __( 'Accept', 'wp-toolbelt' ) ],
			description: __( 'Add a single checkbox.', 'wp-toolbelt' ),
			icon: renderMaterialIcon(
				<Path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM17.99 9l-1.41-1.42-6.59 6.59-2.58-2.57-1.42 1.41 4 3.99z" />
			),
			edit: props => (
				<ToolbeltFieldCheckbox
					label={props.attributes.label} // label intentinally left blank
					required={props.attributes.required}
					description={props.attributes.description}
					setAttributes={props.setAttributes}
					isSelected={props.isSelected}
					defaultValue={props.attributes.defaultValue}
					id={props.attributes.id}
				/>
			),
			attributes: {
				...FieldDefaults.attributes,
				label: {
					type: 'string',
					default: '',
				},
			},
		},
	},
	{
		name: 'field-checkbox-multiple',
		settings: {
			...FieldDefaults,
			title: __( 'Checkbox Group', 'wp-toolbelt' ),
			keywords: [ __( 'Choose Multiple', 'wp-toolbelt' ), __( 'Option', 'wp-toolbelt' ) ],
			description: __( 'People love options. Add several checkbox items.', 'wp-toolbelt' ),
			icon: renderMaterialIcon(
				<Path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" />
			),
			edit: editMultiField( 'checkbox' ),
			transforms: MultiFieldTransforms,
			attributes: {
				...FieldDefaults.attributes,
				label: {
					type: 'string',
					default: __( 'Select several', 'wp-toolbelt' ),
				},
			},
		},
	},
	{
		name: 'field-radio',
		settings: {
			...FieldDefaults,
			title: __( 'Radio', 'wp-toolbelt' ),
			keywords: [ __( 'Choose', 'wp-toolbelt' ), __( 'Select', 'wp-toolbelt' ), __( 'Option', 'wp-toolbelt' ) ],
			description: __(
				'Inspired by radios, only one radio item can be selected at a time. Add several radio button items.',
				'wp-toolbelt'
			),
			icon: renderMaterialIcon(
				<Fragment>
					<Path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
					<Circle cx="12" cy="12" r="5" />
				</Fragment>
			),
			edit: editMultiField( 'radio' ),
			transforms: MultiFieldTransforms,
			attributes: {
				...FieldDefaults.attributes,
				label: {
					type: 'string',
					default: __( 'Select one', 'wp-toolbelt' ),
				},
			},
		},
	},
	{
		name: 'field-select',
		settings: {
			...FieldDefaults,
			title: __( 'Select', 'wp-toolbelt' ),
			keywords: [
				__( 'Choose', 'wp-toolbelt' ),
				__( 'Dropdown', 'wp-toolbelt' ),
				__( 'Option', 'wp-toolbelt' ),
			],
			description: __( 'Compact, but powerful. Add a select box with several items.', 'wp-toolbelt' ),
			icon: renderMaterialIcon(
				<Path d="M3 17h18v2H3zm16-5v1H5v-1h14m2-2H3v5h18v-5zM3 6h18v2H3z" />
			),
			edit: editMultiField( 'select' ),
			transforms: MultiFieldTransforms,
			attributes: {
				...FieldDefaults.attributes,
				label: {
					type: 'string',
					default: __( 'Select one', 'wp-toolbelt' ),
				},
			},
		},
	},
];
