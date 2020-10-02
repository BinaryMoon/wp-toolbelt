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
  var icon = {
    src: createElement("svg", {
      xmlns: "http://www.w3.org/2000/svg",
      width: "60",
      height: "60",
      viewBox: "0 0 60 60"
    }, createElement("g", {
      fill: "none",
      "fill-rule": "evenodd"
    }, createElement("path", {
      fill: "#000000",
      d: "M6,15 L31,15 L31,15 L39,30 L31,45 L6,45 C4.34314575,45 3,43.6568542 3,42 L3,18 C3,16.3431458 4.34314575,15 6,15 Z"
    }), createElement("path", {
      fill: "#000000",
      d: "M50,15 L58,30 L50,45 L34,45 L42,30 L34,15 L50,15 Z"
    })))
  };
  console.log('related posts');
  registerBlockType('toolbelt/related-posts', {
    title: __('TB Related Posts', 'wp-toolbelt'),
    icon: icon,
    description: __('Display related posts for the current post.', 'wp-toolbelt'),
    category: 'wp-toolbelt',
    keywords: [_x('related posts', 'block search term', 'wp-toolbelt'), _x('toolbelt', 'block search term', 'wp-toolbelt')],
    supports: {
      align: ['full', 'wide']
    },
    edit: function edit(props) {
      return [createElement(ServerSideRender, {
        block: "toolbelt/related-posts",
        attributes: props.attributes
      }), createElement(InspectorControls, null, createElement(PanelBody, {
        title: __('Important Note', 'wp-toolbelt'),
        initialOpen: true
      }, createElement("p", null, __('The related posts block will only display on post types that support related posts.', 'wp-toolbelt'))))];
    },
    save: function save() {
      return null;
    }
  });
})();