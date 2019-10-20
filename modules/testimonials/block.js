"use strict";

var registerBlockType = wp.blocks.registerBlockType;
var createElement = wp.element.createElement;
var InspectorControls = wp.blockEditor.InspectorControls;
var _wp$components = wp.components,
    RangeControl = _wp$components.RangeControl,
    SelectControl = _wp$components.SelectControl,
    PanelBody = _wp$components.PanelBody,
    ServerSideRender = _wp$components.ServerSideRender;
var __ = wp.i18n.__;
registerBlockType('toolbelt/testimonials', {
  title: __('Testimonials', 'wp-toolbelt'),
  icon: 'testimonial',
  description: __('Display a grid of Toolbelt Testimonials.', 'wp-toolbelt'),
  keywords: [__('toolbelt', 'wp-toolbelt')],
  category: 'common',
  supports: {
    align: ['full', 'wide']
  },
  attributes: {
    rows: {
      default: 2
    },
    columns: {
      default: 2
    },
    orderby: {
      default: 'date'
    }
  },
  edit: function edit(props) {
    var attributes = props.attributes;
    var setAttributes = props.setAttributes; // Function to update the number of rows.

    function changeRows(rows) {
      setAttributes({
        rows: rows
      });
    } // Function to update the number of columns.


    function changeColumns(columns) {
      setAttributes({
        columns: columns
      });
    } // Function to update the testimonial order.


    function changeOrderby(orderby) {
      setAttributes({
        orderby: orderby
      });
    }

    return [createElement(ServerSideRender, {
      block: "toolbelt/testimonials",
      attributes: attributes
    }), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Layout', 'wp-toolbelt'),
      initialOpen: true
    }, createElement(RangeControl, {
      value: attributes.rows,
      label: __('Rows', 'wp-toolbelt'),
      onChange: changeRows,
      min: 1,
      max: 10
    }), createElement(RangeControl, {
      value: attributes.columns,
      label: __('Columns', 'wp-toolbelt'),
      onChange: changeColumns,
      min: 1,
      max: 4
    }), createElement(SelectControl, {
      value: attributes.orderby,
      label: __('Order by', 'wp-toolbelt'),
      onChange: changeOrderby,
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