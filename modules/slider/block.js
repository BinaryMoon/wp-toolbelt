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
  /**
   * HTML for the generated slide.
   *
   * @param {array} props The slider properties.
   * @return {string}
   */

  var slideSave = function slideSave(props) {
    var attributes = props.attributes,
        className = props.className;
    var title = attributes.title,
        description = attributes.description,
        link = attributes.link;
    var background = getSlideBackground(attributes);
    return createElement("li", {
      style: background,
      "class": className
    }, title && link && createElement("h3", {
      "class": "toolbelt-skip-anchor"
    }, createElement("a", {
      href: "{link}"
    }, title)), title && !link && createElement("h3", {
      "class": "toolbelt-skip-anchor"
    }, title), description && createElement("p", null, description));
  };
  /**
   * Get slide class names.
   *
   * @param {array} props The slider properties.
   * @return {string}
   */


  var getSlideClass = function getSlideClass(props) {
    var className = props.className;
    var classNames = ['toolbelt-block-slide', className];
    return classNames.join(' ');
  };
  /**
   * Get slide background styles.
   *
   * @param {array} attributes The slider attributes.
   * @return {string}
   */


  var getSlideBackground = function getSlideBackground(attributes) {
    return {
      backgroundImage: attributes.mediaUrl != '' ? "url(\"".concat(attributes.mediaUrl, "\")") : 'none'
    };
  };
  /**
   * HTML for editing the slide properties.
   *
   * @param {array} props The slider properties.
   * @return {string}
   */


  var slideEdit = function slideEdit(props) {
    var attributes = props.attributes,
        isSelected = props.isSelected,
        setAttributes = props.setAttributes;
    var description = attributes.description,
        title = attributes.title,
        link = attributes.link;
    var hasBackground = attributes.mediaId > 0;
    /**
     * Remove the slide background image.
     *
     * @return {void}
     */

    var removeMedia = function removeMedia() {
      setAttributes({
        mediaId: 0,
        mediaUrl: ''
      });
    };
    /**
     * Store the background image properties.
     *
     * @param {array} media The image properties.
     * @return {void}
     */


    var onSelectMedia = function onSelectMedia(media) {
      var imageUrl = media.url;

      if (media.sizes && media.sizes.medium) {
        imageUrl = media.sizes.medium.url;
      }

      setAttributes({
        mediaId: media.id,
        mediaUrl: imageUrl
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
        width: "60",
        height: "60",
        viewBox: "0 0 60 60"
      }, createElement("rect", {
        width: "40",
        height: "40",
        x: "10",
        y: "10",
        fill: "#000000",
        "fill-rule": "evenodd"
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
    save: slideSave,
    edit: withSelect(function (select, props) {
      return {
        media: props.attributes.mediaId ? select('core').getMedia(props.attributes.mediaId) : undefined
      };
    })(slideEdit)
  });
  /**
   * HTML for the generated slider.
   *
   * @param {array} props The slider properties.
   * @return {string}
   */

  var sliderSave = function sliderSave(props) {
    return createElement("div", {
      className: getSliderClass(props)
    }, createElement("ul", null, createElement(InnerBlocks.Content, null)));
  };
  /**
   * Get the classes for the slider.
   *
   * @param {array} props The slider properties.
   * @return {string}
   */


  var getSliderClass = function getSliderClass(props) {
    var attributes = props.attributes,
        className = props.className;
    var classNames = ['toolbelt-block-slider', className];

    if (attributes.textAlignment) {
      classNames.push("has-text-align-".concat(attributes.textAlignment));
    }

    if (attributes.slideWidth) {
      classNames.push("toolbelt-block-slide-width-".concat(attributes.slideWidth.toLowerCase()));
    }

    return classNames.join(' ');
  };
  /**
   * HTML used to edit the slider.
   *
   * @param {array} props The slider properties.
   * @return {array}
   */


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
        width: "60",
        height: "60",
        viewBox: "0 0 60 60"
      }, createElement("g", {
        fill: "none",
        "fill-rule": "evenodd"
      }, createElement("rect", {
        width: "30",
        height: "30",
        x: "15",
        y: "15",
        fill: "#000000",
        rx: "3"
      }), createElement("path", {
        fill: "#000000",
        d: "M13 18L13 42 11 42C9.8954305 42 9 41.1045695 9 40L9 20C9 18.8954305 9.8954305 18 11 18L13 18zM49 18C50.1045695 18 51 18.8954305 51 20L51 40C51 41.1045695 50.1045695 42 49 42L47 42 47 18 49 18zM7 21L7 39 5 39C3.8954305 39 3 38.1045695 3 37L3 23C3 21.8954305 3.8954305 21 5 21L7 21zM55 21C56.1045695 21 57 21.8954305 57 23L57 37C57 38.1045695 56.1045695 39 55 39L53 39 53 21 55 21z"
      })))
    },
    styles: [{
      name: 'normal',
      label: __('Simple', 'wp-toolbelt'),
      isDefault: true
    }, {
      name: 'padding',
      label: __('With padding', 'wp-toolbelt')
    }, {
      name: 'border',
      label: __('With border', 'wp-toolbelt')
    }, {
      name: 'cosy',
      label: __('No margin', 'wp-toolbelt')
    }],
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
    save: sliderSave,
    edit: sliderEdit
  });
})();