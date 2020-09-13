/**
 * Get slide class names.
 *
 * @param {array} props The slider properties.
 * @return {string}
 */
const getSlideClass = ( props ) => {

	const { className } = props;

	let classNames = [
		'toolbelt-block-slide',
		className,
	];

	return classNames.join( ' ' );

};

/**
 * Get slide background styles.
 *
 * @param {array} attributes The slider attributes.
 * @return {string}
 */
const getSlideBackground = ( attributes ) => {

	return {
		backgroundImage: attributes.mediaUrl != '' ? `url("${attributes.mediaUrl}")` : 'none'
	};

}

/**
 * HTML for editing the slide properties.
 *
 * @param {array} props The slider properties.
 * @return {string}
 */
const slideEdit = ( props ) => {

	const { attributes, isSelected, setAttributes } = props;
	const { description, title, link } = attributes;
	const hasBackground = attributes.mediaId > 0;

	/**
	 * Remove the slide background image.
	 *
	 * @return {void}
	 */
	const removeMedia = () => {

		setAttributes(
			{
				mediaId: 0,
				mediaUrl: ''
			}
		);

	}

	/**
	 * Store the background image properties.
	 *
	 * @param {array} media The image properties.
	 * @return {void}
	 */
	const onSelectMedia = ( media ) => {

		let imageUrl = media.url;

		if ( media.sizes && media.sizes.medium ) {
			imageUrl = media.sizes.medium.url;
		}

		setAttributes(
			{
				mediaId: media.id,
				mediaUrl: imageUrl,
			}
		);

	}

	const background = getSlideBackground( attributes );

	return [
		<BlockControls>
			<MediaUploadCheck>
				<MediaUpload
					title={__( 'Upload image', 'wp-toolbelt' )}
					value={attributes.mediaId}
					onSelect={onSelectMedia}
					allowedTypes={[ 'image' ]}
					render={
						( { open } ) => (
							<IconButton
								onClick={open}
								icon="format-image"
								label={__( 'Choose image', 'wp-toolbelt' )}
							/>
						)
					}
				/>
			</MediaUploadCheck>
		</BlockControls>,
		<InspectorControls>
			<PanelBody
				title={__( 'Link URL', 'wp-toolbelt' )}
				initialOpen={true}
			>
				<TextControl
					placeholder="https://"
					value={link}
					onChange={value => setAttributes( { link: value } )}
				/>
			</PanelBody>
			<PanelBody
				title={__( 'Background Image', 'wp-toolbelt' )}
				initialOpen={true}
			>
				<MediaUploadCheck>
					<MediaUpload
						onSelect={onSelectMedia}
						value={attributes.mediaId}
						allowedTypes={[ 'image' ]}
						render={
							( { open } ) => (
								<Button
									className={!hasBackground ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview'}
									onClick={open}
								>
									{
										!hasBackground && __( 'Choose an image', 'wp-toolbelt' )
									}
									{
										props.media !== undefined && (
											<ResponsiveWrapper
												naturalWidth={props.media.media_details.width}
												naturalHeight={props.media.media_details.height}
											>
												<img src={props.media.source_url} />
											</ResponsiveWrapper>
										)
									}
								</Button>
							)
						}
					/>
				</MediaUploadCheck>
				{
					hasBackground && (
						<MediaUploadCheck>
							<Button
								onClick={removeMedia}
								isLink
								isDestructive
							>
								{__( 'Remove image', 'wp-toolbelt' )}
							</Button>
						</MediaUploadCheck>
					)
				}
			</PanelBody>
		</InspectorControls>,
		<div className={getSlideClass( props )} style={background}>
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
