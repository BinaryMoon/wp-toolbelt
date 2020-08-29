const getColor = props => ( props && props.color ? props.color : 'currentColor' );
const getClassName = props => ( props && props.className ? props.className : '' );

const StarIcon = props => {

	const color = getColor( props );
	const className = getClassName( props );

	return (
		<SVG
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			color={color}
		>
			<Path
				className={className}
				fill={color}
				stroke={color}
				d="M12,17.3l6.2,3.7l-1.6-7L22,9.2l-7.2-0.6L12,2L9.2,8.6L2,9.2L7.5,14l-1.6,7L12,17.3z"
			/>
		</SVG>
	);
};
