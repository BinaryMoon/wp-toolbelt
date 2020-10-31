"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var createElement = wp.element.createElement;
  var InspectorControls = wp.blockEditor.InspectorControls;
  var _wp$components = wp.components,
      RangeControl = _wp$components.RangeControl,
      RadioControl = _wp$components.RadioControl,
      PanelBody = _wp$components.PanelBody;
  var ServerSideRender = wp.serverSideRender;
  var __ = wp.i18n.__;
  registerBlockType('toolbelt/testimonials', {
    title: __('TB Testimonials', 'wp-toolbelt'),
    icon: 'testimonial',
    description: __('Display a grid of Toolbelt Testimonials.', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt')],
    category: 'wp-toolbelt',
    supports: {
      align: ['full', 'wide']
    },
    attributes: {
      rows: {
        "default": 2
      },
      columns: {
        "default": 2
      },
      orderby: {
        "default": 'date'
      }
    },
    edit: function edit(props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      return [createElement(ServerSideRender, {
        block: "toolbelt/testimonials",
        attributes: attributes
      }), createElement(InspectorControls, null, createElement(PanelBody, {
        title: __('Layout', 'wp-toolbelt'),
        initialOpen: true
      }, createElement(RangeControl, {
        value: attributes.rows,
        label: __('Rows', 'wp-toolbelt'),
        onChange: function onChange(value) {
          return setAttributes({
            rows: value
          });
        },
        min: 1,
        max: 10
      }), createElement(RangeControl, {
        value: attributes.columns,
        label: __('Columns', 'wp-toolbelt'),
        onChange: function onChange(value) {
          return setAttributes({
            columns: value
          });
        },
        min: 1,
        max: 4
      }), createElement(RadioControl, {
        selected: attributes.orderby,
        label: __('Order by', 'wp-toolbelt'),
        onChange: function onChange(value) {
          return setAttributes({
            orderby: value
          });
        },
        options: [{
          value: 'date',
          label: __('date', 'wp-toolbelt')
        }, {
          value: 'rand',
          label: __('random', 'wp-toolbelt')
        }]
      })))];
    },
    save: function save() {
      return null;
    }
  });
})();