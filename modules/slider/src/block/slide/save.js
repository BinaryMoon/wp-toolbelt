const slideSave = ( props ) => {

	const { attributes } = props;
	const { title, description, link } = attributes;

	return (
		<a className={getSlideClass( props )} href="{link}">
			{
				title && (
					<h3>{title}</h3>
				)
			}
			{
				description && (
					<p>{description}</p>
				)
			}
		</a>
	);

};
