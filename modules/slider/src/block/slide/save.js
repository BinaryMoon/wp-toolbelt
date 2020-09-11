const slideSave = ( props ) => {

	const { attributes } = props;
	const { title, description, link } = attributes;
	const background = getSlideBackground( attributes );

	return (
		<li style={background}>
			{
				title && link && (
					<h3 class="toolbelt-skip-anchor"><a href="{link}">{title}</a></h3>
				)
			}
			{
				title && !link && (
					<h3 class="toolbelt-skip-anchor">{title}</h3>
				)
			}
			{
				description && (
					<p>{description}</p>
				)
			}
		</li>
	);

};
