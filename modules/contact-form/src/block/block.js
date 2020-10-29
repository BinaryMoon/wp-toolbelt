(
	function() {

		const { __, _x } = wp.i18n;
		const {
			InspectorControls,
			InnerBlocks,
			PlainText
		} = wp.blockEditor;
		const {
			getBlockType,
			createBlock,
			registerBlockType
		} = wp.blocks;
		const {
			Fragment,
			Component,
			createElement,
			createRef,
			useEffect,
			useState
		} = wp.element;
		const {
			compose,
			withInstanceId
		} = wp.compose;
		const {
			BaseControl,
			Button,
			Icon,
			PanelBody,
			RadioControl,
			Placeholder,
			SelectControl,
			TextareaControl,
			TextControl,
			ToggleControl,
			Path, Rect, SVG, Circle
		} = wp.components;

		/**
		 * The block edit properties.
		 * This is for the parent block.
		 */
		//=require ./edit.js

		/**
		 * The block settings.
		 */
		//=require ./settings.js

		/**
		 * The individual form components.
		 */
		//=require ./component/checkbox.js
		//=require ./component/field.js
		//=require ./component/label.js
		//=require ./component/textarea.js
		//=require ./component/multi.js
		//=require ./component/option.js

		registerBlockType( 'toolbelt/contact-form', settings );

		//=require ./variations.js

		childBlocks.forEach(
			childBlock => registerBlockType( `toolbelt/${childBlock.name}`, childBlock.settings )
		);

	}
)();
