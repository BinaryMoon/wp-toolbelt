const slideSave = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;

	return (
		<section className={getSlideClass( props )} style={{ backgroundColor, color: textColor }}>
		</section>
	);

};
