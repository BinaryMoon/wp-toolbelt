"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var _wp$element = wp.element,
      Component = _wp$element.Component,
      createElement = _wp$element.createElement,
      Fragment = _wp$element.Fragment;
  var _wp$components = wp.components,
      Button = _wp$components.Button,
      ButtonGroup = _wp$components.ButtonGroup,
      ExternalLink = _wp$components.ExternalLink,
      IconButton = _wp$components.IconButton,
      PanelBody = _wp$components.PanelBody,
      Path = _wp$components.Path,
      Rect = _wp$components.Rect,
      ResponsiveWrapper = _wp$components.ResponsiveWrapper,
      SVG = _wp$components.SVG,
      TextControl = _wp$components.TextControl;
  var __ = wp.i18n.__;
  var _wp$blockEditor = wp.blockEditor,
      AlignmentToolbar = _wp$blockEditor.AlignmentToolbar,
      BlockControls = _wp$blockEditor.BlockControls,
      BlockIcon = _wp$blockEditor.BlockIcon,
      ContrastChecker = _wp$blockEditor.ContrastChecker,
      InnerBlocks = _wp$blockEditor.InnerBlocks,
      InspectorControls = _wp$blockEditor.InspectorControls,
      PanelColorSettings = _wp$blockEditor.PanelColorSettings,
      RichText = _wp$blockEditor.RichText,
      MediaUpload = _wp$blockEditor.MediaUpload,
      MediaUploadCheck = _wp$blockEditor.MediaUploadCheck;
  var withSelect = wp.data.withSelect;

  var slideSave = function slideSave(props) {
    var attributes = props.attributes;
    var title = attributes.title,
        description = attributes.description,
        link = attributes.link;
    var background = getSlideBackground(attributes);
    return createElement("li", {
      style: background
    }, title && link && createElement("h3", {
      "class": "toolbelt-skip-anchor"
    }, createElement("a", {
      href: "{link}"
    }, title)), title && !link && createElement("h3", {
      "class": "toolbelt-skip-anchor"
    }, title), description && createElement("p", null, description));
  };

  var getSlideClass = function getSlideClass(props) {
    var classNames = ['toolbelt-block-slide'];
    return classNames.join(' ');
  };

  var getSlideBackground = function getSlideBackground(attributes) {
    return {
      backgroundImage: attributes.mediaUrl != '' ? "url(\"".concat(attributes.mediaUrl, "\")") : 'none'
    };
  };

  var slideEdit = function slideEdit(props) {
    var attributes = props.attributes,
        isSelected = props.isSelected,
        setAttributes = props.setAttributes;
    var description = attributes.description,
        title = attributes.title,
        link = attributes.link;
    var hasBackground = attributes.mediaId > 0;

    var removeMedia = function removeMedia() {
      setAttributes({
        mediaId: 0,
        mediaUrl: ''
      });
    };

    var onSelectMedia = function onSelectMedia(media) {
      setAttributes({
        mediaId: media.id,
        mediaUrl: media.url
      });
    };

    var background = getSlideBackground(attributes);
    return [createElement(BlockControls, null, createElement(MediaUploadCheck, null, createElement(MediaUpload, {
      title: __('Upload image', 'wp-toolbelt'),
      value: attributes.mediaId,
      onSelect: onSelectMedia,
      allowedTypes: ['image'],
      render: function render(_ref) {
        var open = _ref.open;
        return createElement(IconButton, {
          onClick: open,
          icon: "format-image",
          label: __('Choose image', 'wp-toolbelt')
        });
      }
    }))), createElement(InspectorControls, null, createElement(PanelBody, {
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
      render: function render(_ref2) {
        var open = _ref2.open;
        return createElement(Button, {
          className: !hasBackground ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
          onClick: open
        }, !hasBackground && __('Choose an image', 'wp-toolbelt'), props.media !== undefined && createElement(ResponsiveWrapper, {
          naturalWidth: props.media.media_details.width,
          naturalHeight: props.media.media_details.height
        }, createElement("img", {
          src: props.media.source_url
        })));
      }
    })), hasBackground && createElement(MediaUploadCheck, null, createElement(Button, {
      onClick: removeMedia,
      isLink: true,
      isDestructive: true
    }, __('Remove image', 'wp-toolbelt'))))), createElement("div", {
      className: getSlideClass(props),
      style: background
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
    var attributes = props.attributes; // const { } = attributes;

    return createElement("div", {
      className: getSliderClass(props)
    }, createElement("ul", null, createElement(InnerBlocks.Content, null)));
  };

  var getSliderClass = function getSliderClass(props) {
    var attributes = props.attributes;
    var classNames = ['toolbelt-block-slider'];

    if (attributes.textAlignment) {
      classNames.push("has-text-align-".concat(attributes.textAlignment));
    }

    if (attributes.slideWidth) {
      classNames.push("toolbelt-block-slide-width-".concat(attributes.slideWidth.toLowerCase()));
    }

    return classNames.join(' ');
  };

  var sliderEdit = function sliderEdit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var textAlignment = attributes.textAlignment,
        slideWidth = attributes.slideWidth;
    var ALLOWED_BLOCKS = ['toolbelt/slide'];
    var SLIDER_TEMPLATE = [['toolbelt/slide']];
    return [createElement(BlockControls, null, createElement(AlignmentToolbar, {
      value: textAlignment,
      label: __('Slide Width', 'wp-toolbelt'),
      onChange: function onChange(value) {
        return setAttributes({
          textAlignment: value
        });
      }
    })), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Slider Settings', 'wp-toolbelt'),
      initialOpen: true
    }, createElement(ButtonGroup, {
      label: __('Slide Width', 'wp-toolbelt')
    }, createElement("p", null, __('Slide Width', 'wp-toolbelt')), ['S', 'M', 'L', 'XL'].map(function (size) {
      return createElement(Button, {
        onClick: function onClick() {
          return setAttributes({
            slideWidth: size
          });
        },
        value: size,
        isPrimary: size === slideWidth
      }, size);
    })))), createElement("div", {
      className: getSliderClass(props),
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
      textAlignment: {
        type: 'string'
      },
      slideWidth: {
        type: 'string',
        "default": 'M'
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