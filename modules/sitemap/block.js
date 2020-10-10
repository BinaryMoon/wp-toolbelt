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
  var github_icon = createElement("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24"
  }, createElement("path", {
    d: "M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"
  }));
  registerBlockType('toolbelt/sitemap', {
    title: __('TB Sitemap', 'wp-toolbelt'),
    description: __('Display your Sitemap', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('sitemap', 'wp-toolbelt')],
    icon: github_icon,
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