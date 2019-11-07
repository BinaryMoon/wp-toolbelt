( function() {

	const { __, _x } = wp.i18n;
	const { createElement } = wp.element;
	const { InspectorControls, InnerBlocks, PlainText } = wp.blockEditor;
	const { getBlockType, registerBlockType } = wp.blocks;
	const { Fragment, Component, createBlock, createRef, useEffect } = wp.element;
	const { compose, withInstanceId } = wp.compose;
	const {
		BaseControl,
		Button,
		IconButton,
		PanelBody,
		Placeholder,
		SelectControl,
		TextareaControl,
		TextControl,
		ToggleControl,
		Path, Rect, SVG, Circle
	} = wp.components;

	//=require ./edit.js
	//=require ./settings.js
	//=require ./component/checkbox.js
	//=require ./component/field.js
	//=require ./component/label.js
	//=require ./component/textarea.js
	//=require ./component/multi.js
	//=require ./component/option.js

	registerBlockType( 'toolbelt/contact-form', settings );

	childBlocks.forEach(
		childBlock => registerBlockType( `toolbelt/${childBlock.name}`, childBlock.settings )
	);

} )();
