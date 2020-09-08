const getSlideClass = ( props ) => {

	let classNames = [
		'toolbelt-block-slide',
	];

	return classNames.join( ' ' );

};

const slideEdit = ( props ) => {

	const { attributes } = props;
	const { backgroundColor, textColor } = attributes;

	return [
		<div className={getSlideClass( props )}>
			<a style={{ backgroundColor, color: textColor }}>
				{}
			</a>
		</div>
		// gridInspector( props )
	];

};
