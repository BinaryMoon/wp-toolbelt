"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var _wp$element = wp.element,
      createElement = _wp$element.createElement,
      Fragment = _wp$element.Fragment,
      Component = _wp$element.Component,
      RawHTML = _wp$element.RawHTML;
  var _wp$components = wp.components,
      Path = _wp$components.Path,
      SVG = _wp$components.SVG,
      CheckboxControl = _wp$components.CheckboxControl,
      PanelBody = _wp$components.PanelBody;
  var ServerSideRender = wp.serverSideRender;
  var __ = wp.i18n.__;
  var _wp$blockEditor = wp.blockEditor,
      BlockIcon = _wp$blockEditor.BlockIcon,
      InspectorControls = _wp$blockEditor.InspectorControls;
  registerBlockType('toolbelt/sitemap', {
    title: __('TB Sitemap', 'wp-toolbelt'),
    description: __('Display your Sitemap', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('sitemap', 'wp-toolbelt')],
    icon: 'networking',
    category: 'wp-toolbelt',
    attributes: {
      posts: {
        "default": true,
        type: 'boolean'
      },
      pages: {
        "default": true,
        type: 'boolean'
      },
      categories: {
        "default": true,
        type: 'boolean'
      }
    },
    save: function save() {
      return null;
    },

    /**
     * Edit the settings.
     */
    edit: function edit(props) {
      var attributes = props.attributes,
          setAttributes = props.setAttributes;
      var categories = attributes.categories,
          pages = attributes.pages,
          posts = attributes.posts;
      return [createElement(ServerSideRender, {
        block: "toolbelt/sitemap",
        attributes: props.attributes
      }), createElement(InspectorControls, null, createElement(PanelBody, {
        title: __('Sections', 'wp-toolbelt'),
        initialOpen: true
      }, createElement(CheckboxControl, {
        label: __('Categories', 'wp-toolbelt'),
        checked: categories,
        onChange: function onChange(val) {
          setAttributes({
            categories: val
          });
        }
      }), createElement(CheckboxControl, {
        label: __('Pages', 'wp-toolbelt'),
        checked: pages,
        onChange: function onChange(val) {
          setAttributes({
            pages: val
          });
        }
      }), createElement(CheckboxControl, {
        label: __('Posts', 'wp-toolbelt'),
        checked: posts,
        onChange: function onChange(val) {
          setAttributes({
            posts: val
          });
        }
      })))];
    }
  });
})();