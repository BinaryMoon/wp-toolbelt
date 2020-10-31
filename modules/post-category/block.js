"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var _wp$element = wp.element,
      createElement = _wp$element.createElement,
      Fragment = _wp$element.Fragment,
      Component = _wp$element.Component;
  var _wp$components = wp.components,
      Path = _wp$components.Path,
      SVG = _wp$components.SVG,
      CheckboxControl = _wp$components.CheckboxControl,
      SelectControl = _wp$components.SelectControl,
      PanelBody = _wp$components.PanelBody,
      RangeControl = _wp$components.RangeControl,
      RadioControl = _wp$components.RadioControl;
  var ServerSideRender = wp.serverSideRender;
  var __ = wp.i18n.__;
  var _wp$blockEditor = wp.blockEditor,
      BlockIcon = _wp$blockEditor.BlockIcon,
      InspectorControls = _wp$blockEditor.InspectorControls;
  var layouts = [{
    label: __('Large Image', 'wp-toolbelt'),
    value: '2'
  }, {
    label: __('Small Image', 'wp-toolbelt'),
    value: '3'
  }, {
    label: __('Excerpt', 'wp-toolbelt'),
    value: '4'
  }, {
    label: __('Title only', 'wp-toolbelt'),
    value: '5'
  }, {
    label: __('List', 'wp-toolbelt'),
    value: '1'
  }];
  var layouts_first = [{
    label: __('None', 'wp-toolbelt'),
    value: '1'
  }, {
    label: __('Large Image', 'wp-toolbelt'),
    value: '2'
  }, {
    label: __('Small Image', 'wp-toolbelt'),
    value: '3'
  }, {
    label: __('Excerpt', 'wp-toolbelt'),
    value: '4'
  }, {
    label: __('Title only', 'wp-toolbelt'),
    value: '5'
  }];
  registerBlockType('toolbelt/post-category', {
    title: __('TB Post Category', 'wp-toolbelt'),
    description: __('A summary of recent posts from the selected category.', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('recent post category', 'wp-toolbelt')],
    icon: 'networking',
    category: 'wp-toolbelt',
    attributes: {
      category: {
        "default": '',
        type: 'string'
      },
      count: {
        "default": 10,
        type: 'int'
      },
      layout: {
        "default": '1',
        type: 'string'
      },
      layout_first: {
        "default": '1',
        type: 'string'
      }
    },
    styles: [{
      name: 'normal',
      label: __('Default', 'wp-toolbelt'),
      isDefault: true
    }, {
      name: 'border-top',
      label: __('Border Top', 'wp-toolbelt')
    }],
    save: function save() {
      return null;
    },

    /**
     * Edit the settings.
     */
    edit: function edit(props) {
      var attributes = props.attributes,
          setAttributes = props.setAttributes;
      var category = attributes.category,
          count = attributes.count,
          layout = attributes.layout,
          layout_first = attributes.layout_first;
      return [createElement(ServerSideRender, {
        block: "toolbelt/post-category",
        attributes: props.attributes
      }), createElement(InspectorControls, null, createElement(PanelBody, {
        title: __('Sections', 'wp-toolbelt'),
        initialOpen: true
      }, createElement(SelectControl, {
        label: __('Category', 'wp-toolbelt'),
        options: toolbelt_post_categories,
        value: category,
        onChange: function onChange(new_category) {
          setAttributes({
            category: new_category
          });
        }
      }), createElement(RangeControl, {
        label: __('Number of Posts', 'wp-toolbelt'),
        min: 3,
        max: 19,
        value: count,
        onChange: function onChange(new_count) {
          setAttributes({
            count: new_count
          });
        }
      }), createElement(RadioControl, {
        label: __('Layout', 'wp-toolbelt'),
        options: layouts,
        onChange: function onChange(new_layout) {
          setAttributes({
            layout: new_layout
          });
        },
        selected: layout
      }), createElement(RadioControl, {
        label: __('First Post Layout', 'wp-toolbelt'),
        options: layouts_first,
        onChange: function onChange(new_layout) {
          setAttributes({
            layout_first: new_layout
          });
        },
        selected: layout_first,
        description: __('Use this to make the first post in the block stand out a bit', 'wp-toolbelt')
      })))];
    }
  });
})();