wp.blocks.registerBlockVariation(
	'toolbelt/contact-form',
	{
		name: 'feedback',
		title: __( 'TB Feedback Form', 'wp-toolbelt' ),
		attributes: {
			layout: 'feedback',
		}
	}
);

wp.blocks.registerBlockVariation(
	'toolbelt/contact-form',
	{
		name: 'nps',
		title: __( 'TB Net Promoter Score (NPS) Form', 'wp-toolbelt' ),
		attributes: {
			layout: 'nps',
		}
	}
);