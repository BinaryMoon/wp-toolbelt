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
      TextControl = _wp$components.TextControl,
      PanelBody = _wp$components.PanelBody,
      Button = _wp$components.Button,
      ResponsiveWrapper = _wp$components.ResponsiveWrapper,
      SVG = _wp$components.SVG;
  var __ = wp.i18n.__;
  var _wp$blockEditor = wp.blockEditor,
      BlockIcon = _wp$blockEditor.BlockIcon,
      InnerBlocks = _wp$blockEditor.InnerBlocks,
      InspectorControls = _wp$blockEditor.InspectorControls,
      PanelColorSettings = _wp$blockEditor.PanelColorSettings,
      RichText = _wp$blockEditor.RichText,
      ContrastChecker = _wp$blockEditor.ContrastChecker,
      MediaUpload = _wp$blockEditor.MediaUpload,
      MediaUploadCheck = _wp$blockEditor.MediaUploadCheck;
  var withSelect = wp.data.withSelect;

  var slideSave = function slideSave(props) {
    var attributes = props.attributes;
    var title = attributes.title,
        description = attributes.description,
        link = attributes.link;
    return createElement("li", null, title && link && createElement("h3", null, createElement("a", {
      href: "{link}"
    }, title)), title && !link && createElement("h3", null, title), description && createElement("p", null, description));
  };

  var getSlideClass = function getSlideClass(props) {
    var classNames = ['toolbelt-block-slide'];
    return classNames.join(' ');
  };

  var slideEdit = function slideEdit(props) {
    var attributes = props.attributes,
        isSelected = props.isSelected,
        setAttributes = props.setAttributes;
    var description = attributes.description,
        title = attributes.title,
        link = attributes.link;

    var removeMedia = function removeMedia() {
      props.setAttributes({
        mediaId: 0,
        mediaUrl: ''
      });
    };

    var onSelectMedia = function onSelectMedia(media) {
      props.setAttributes({
        mediaId: media.id,
        mediaUrl: media.url
      });
    };

    var blockStyle = {
      backgroundImage: attributes.mediaUrl != '' ? 'url("' + attributes.mediaUrl + '")' : 'none'
    };
    return [createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Link URL', 'wp-toolbelt'),
      initialOpen: true
    }, createElement(TextControl, {
      placeholder: "https://",
      value: link,
      onChange: function onChange(value) {
        return setAttributes({
          link: value
        });
      }
    })), createElement(PanelBody, {
      title: __('Background Image', 'wp-toolbelt'),
      initialOpen: true
    }, createElement(MediaUploadCheck, null, createElement(MediaUpload, {
      onSelect: onSelectMedia,
      value: attributes.mediaId,
      allowedTypes: ['image'],
      render: function render(_ref) {
        var open = _ref.open;
        return createElement(Button, {
          className: attributes.mediaId === 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
          onClick: open
        }, attributes.mediaId === 0 && __('Choose an image', 'wp-toolbelt'), props.media !== undefined && createElement(ResponsiveWrapper, {
          naturalWidth: props.media.media_details.width,
          naturalHeight: props.media.media_details.height
        }, createElement("img", {
          src: props.media.source_url
        })));
      }
    })), attributes.mediaId !== 0 && createElement(MediaUploadCheck, null, createElement(Button, {
      onClick: removeMedia,
      isLink: true,
      isDestructive: true
    }, __('Remove image', 'wp-toolbelt'))))), createElement("div", {
      className: getSlideClass(props),
      style: blockStyle
    }, isSelected && createElement(Fragment, null, createElement("h3", null, createElement(RichText, {
      value: title,
      placeholder: __('Title', 'wp-toolbelt'),
      onChange: function onChange(value) {
        return setAttributes({
          title: value
        });
      }
    })), createElement("p", null, createElement(RichText, {
      value: description,
      placeholder: __('Description', 'wp-toolbelt'),
      onChange: function onChange(value) {
        return setAttributes({
          description: value
        });
      }
    }))), !isSelected && title && createElement("h3", null, title), !isSelected && description && createElement("p", null, description))];
  };

  registerBlockType('toolbelt/slide', {
    title: __('TB Slide', 'wp-toolbelt'),
    description: __('A simple accessible CSS slider.', 'wp-toolbelt'),
    parent: ['toolbelt/slider'],
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
    attributes: {
      title: {
        type: 'string'
      },
      description: {
        type: 'string'
      },
      link: {
        type: 'string'
      },
      mediaId: {
        type: 'number',
        "default": 0
      },
      mediaUrl: {
        type: 'string',
        "default": ''
      }
    },

    /**
     * Save the formatted markdown content.
     */
    save: slideSave,

    /**
     * Edit the settings.
     */
    edit: withSelect(function (select, props) {
      return {
        media: props.attributes.mediaId ? select('core').getMedia(props.attributes.mediaId) : undefined
      };
    })(slideEdit)
  });

  var sliderSave = function sliderSave(props) {
    var attributes = props.attributes;
    var backgroundColor = attributes.backgroundColor,
        textColor = attributes.textColor;
    return createElement("div", {
      className: getSliderClass(props),
      style: {
        backgroundColor: backgroundColor,
        color: textColor
      }
    }, createElement("ul", null, createElement(InnerBlocks.Content, null)));
  };

  var getSliderClass = function getSliderClass(props) {
    var classNames = ['toolbelt-block-slider'];
    return classNames.join(' ');
  };

  var sliderEdit = function sliderEdit(props) {
    var attributes = props.attributes;
    var backgroundColor = attributes.backgroundColor,
        textColor = attributes.textColor;
    var ALLOWED_BLOCKS = ['toolbelt/slide'];
    var SLIDER_TEMPLATE = [['toolbelt/slide']];
    return [createElement("div", {
      className: getSliderClass(props),
      style: {
        backgroundColor: backgroundColor,
        color: textColor
      },
      role: "group"
    }, createElement(InnerBlocks, {
      template: SLIDER_TEMPLATE,
      allowedBlocks: ALLOWED_BLOCKS,
      orientation: "horizontal",
      renderAppender: function renderAppender() {
        return createElement(InnerBlocks.ButtonBlockAppender, null);
      }
    }))];
  };

  registerBlockType('toolbelt/slider', {
    title: __('TB Slider', 'wp-toolbelt'),
    description: __('A simple accessible CSS slider.', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('slider', 'wp-toolbelt')],
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
      columnWidth: {
        type: 'int'
      },
      backgroundColor: {
        type: 'string'
      },
      textColor: {
        type: 'string'
      }
    },
    supports: {
      align: ['full', 'wide']
    },

    /**
     * Save the formatted markdown content.
     */
    save: sliderSave,

    /**
     * Edit the settings.
     */
    edit: sliderEdit
  });
})();