"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var _wp$element = wp.element,
      createElement = _wp$element.createElement,
      Fragment = _wp$element.Fragment,
      Component = _wp$element.Component,
      RawHTML = _wp$element.RawHTML;
  var _wp$components = wp.components,
      ExternalLink = _wp$components.ExternalLink,
      Path = _wp$components.Path,
      Rect = _wp$components.Rect,
      SVG = _wp$components.SVG;
  var __ = wp.i18n.__;
  var PlainText = wp.blockEditor.PlainText;

  var exampleTitle = __('Try Markdown', 'wp-toolbelt');

  var exampleDescription = __('Markdown is a text formatting syntax that is converted into HTML. You can _emphasize_ text or **make it strong** with just a few characters.', 'wp-toolbelt');

  registerBlockType('toolbelt/markdown', {
    title: __('Markdown', 'wp-toolbelt'),
    description: createElement(Fragment, null, createElement("p", null, __('Use regular characters and punctuation to style text, links, and lists.', 'wp-toolbelt')), createElement(ExternalLink, {
      href: "https://en.support.wordpress.com/markdown-quick-reference/"
    }, __('Support reference', 'wp-toolbelt'))),
    keywords: [__('toolbelt', 'wp-toolbelt')],
    icon: {
      src: createElement("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        viewBox: "0 0 208 128"
      }, createElement(Rect, {
        width: "198",
        height: "118",
        x: "5",
        y: "5",
        ry: "10",
        stroke: "currentColor",
        strokeWidth: "10",
        fill: "none"
      }), createElement(Path, {
        d: "M30 98v-68h20l20 25 20-25h20v68h-20v-39l-20 25-20-25v39zM155 98l-30-33h20v-35h20v35h20z"
      }))
    },
    category: 'wp-toolbelt',
    attributes: {
      source: {
        type: 'string'
      }
    },
    supports: {
      html: false
    },

    /**
     * Save the formatted markdown content.
     */
    save: function save(props) {
      var attributes = props.attributes,
          className = props.className;
      var source = attributes.source;
      return createElement(RawHTML, {
        className: className
      }, source.length ? marked(source) : '');
    },

    /**
     * Edit the settings.
     */
    edit: function edit(props) {
      var attributes = props.attributes,
          isSelected = props.isSelected,
          className = props.className;
      var source = attributes.source;
      /**
       * Check to see if the markdown content is empty or not.
       */

      var isEmpty = function isEmpty() {
        return !source || source.trim() === '';
      };
      /**
       * Upadte the markdown content attribute.
       */


      var updateSource = function updateSource(source) {
        props.setAttributes({
          source: source
        });
      };
      /**
       * Display a placeholder.
       */


      if (!isSelected && isEmpty()) {
        return createElement("p", {
          className: className
        }, createElement("strong", null, __('Write your _Markdown_ **here**…', 'wp-toolbelt')));
      }
      /**
       * Render the markdown content.
       */


      if (!isSelected && !isEmpty()) {
        return createElement(RawHTML, {
          className: className
        }, source.length ? marked(source) : '');
      }
      /**
       * Edit the markdown content.
       */


      return createElement("div", {
        className: className
      }, createElement(PlainText, {
        placeholder: __('Write your _Markdown_ **here**…', 'wp-toolbelt'),
        value: source,
        onChange: updateSource
      }));
    },
    example: {
      attributes: {
        source: "## ## ".concat(exampleTitle, "\n\n").concat(exampleDescription)
      }
    }
  });
})();