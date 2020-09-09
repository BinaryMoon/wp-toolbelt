const getSlideClass = ( props ) => {

	let classNames = [
		'toolbelt-block-slide',
	];

	return classNames.join( ' ' );

};

const slideEdit = ( props ) => {

	const { attributes, isSelected, setAttributes } = props;
	const { description, title, link } = attributes;

	return [
		<InspectorControls>
			<PanelBody
				title={__( 'Link URL', 'wp-toolbelt' )}
				initialOpen={true}
			>
				<TextControl
					placeholder="https://"
					value={link}
				/>
			</PanelBody>
		</InspectorControls>,
		<div className={getSlideClass( props )}>
			{
				isSelected && (
					<>
						<h3>
							<RichText
								value={title}
								placeholder={__( 'Title', 'wp-toolbelt' )}
								onChange={value => setAttributes( { title: value } )}
							/>
						</h3>
						<p>
							<RichText
								value={description}
								placeholder={__( 'Description', 'wp-toolbelt' )}
								onChange={value => setAttributes( { description: value } )}
							/>
						</p>
					</>
				)
			}
			{
				!isSelected && title && (
					<h3>{title}</h3>
				)
			}
			{
				!isSelected && description && (
					<p>{description}</p>
				)
			}
		</div>
	];

};
