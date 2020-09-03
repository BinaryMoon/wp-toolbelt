"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var createElement = wp.element.createElement;
  var InspectorControls = wp.blockEditor.InspectorControls;
  var PanelBody = wp.components.PanelBody;
  var ServerSideRender = wp.serverSideRender;
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x;
  registerBlockType('toolbelt/breadcrumbs', {
    title: __('TB Breadcumbs', 'wp-toolbelt'),
    icon: 'menu-alt2',
    description: __('Display breadcrumbs for the current page.', 'wp-toolbelt'),
    category: 'wp-toolbelt',
    keywords: [_x('breadcrumbs', 'block search term', 'wp-toolbelt'), _x('toolbelt', 'block search term', 'wp-toolbelt')],
    supports: {
      align: ['full', 'wide']
    },
    edit: function edit(props) {
      return [createElement(ServerSideRender, {
        block: "toolbelt/breadcrumbs",
        attributes: props.attributes
      }), createElement(InspectorControls, null, createElement(PanelBody, {
        title: __('Important Note', 'wp-toolbelt'),
        initialOpen: true
      }, createElement("p", null, __('The breadcrumb output may differ from what is shown in the block preview.', 'wp-toolbelt')), createElement("p", null, __('The breadcrumb block does not display on the front page.', 'wp-toolbelt'))))];
    },
    save: function save() {
      return null;
    }
  });
})();