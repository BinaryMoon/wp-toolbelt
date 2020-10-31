"use strict";

(function () {
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x;
  var _wp$blockEditor = wp.blockEditor,
      InspectorControls = _wp$blockEditor.InspectorControls,
      InnerBlocks = _wp$blockEditor.InnerBlocks,
      PlainText = _wp$blockEditor.PlainText;
  var _wp$blocks = wp.blocks,
      getBlockType = _wp$blocks.getBlockType,
      createBlock = _wp$blocks.createBlock,
      registerBlockType = _wp$blocks.registerBlockType;
  var _wp$element = wp.element,
      Fragment = _wp$element.Fragment,
      Component = _wp$element.Component,
      createElement = _wp$element.createElement,
      createRef = _wp$element.createRef,
      useEffect = _wp$element.useEffect,
      useState = _wp$element.useState;
  var _wp$compose = wp.compose,
      compose = _wp$compose.compose,
      withInstanceId = _wp$compose.withInstanceId;
  var _wp$components = wp.components,
      BaseControl = _wp$components.BaseControl,
      Button = _wp$components.Button,
      Icon = _wp$components.Icon,
      PanelBody = _wp$components.PanelBody,
      RadioControl = _wp$components.RadioControl,
      Placeholder = _wp$components.Placeholder,
      SelectControl = _wp$components.SelectControl,
      TextareaControl = _wp$components.TextareaControl,
      TextControl = _wp$components.TextControl,
      ToggleControl = _wp$components.ToggleControl,
      Path = _wp$components.Path,
      Rect = _wp$components.Rect,
      SVG = _wp$components.SVG,
      Circle = _wp$components.Circle;
  /**
   * The block edit properties.
   * This is for the parent block.
   */

  /**
   * External dependencies
   */

  /**
   * These are the blocks allowed inside the contact form.
   *
   * Non form elements are allowed so that we can include descriptions and other
   * things related to the form. When the form is submitted these elements will
   * get removed, and replaced with the 'submission complete' message.
   */

  var ALLOWED_BLOCKS = ['toolbelt/markdown', 'core/paragraph', 'core/heading', 'core/list', 'core/separator', 'core/spacer', 'core/subhead', 'core/quote', 'core/image'];

  var edit = function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var subject = attributes.subject,
        to = attributes.to,
        submitButtonText = attributes.submitButtonText,
        messageConfirmation = attributes.messageConfirmation,
        layout = attributes.layout;
    var form_settings = [createElement(TextControl, {
      label: __('Email address', 'wp-toolbelt'),
      value: to,
      placeholder: __('name@example.com', 'wp-toolbelt'),
      help: __('You can enter multiple email addresses separated by commas.', 'wp-toolbelt'),
      onChange: function onChange(value) {
        return setAttributes({
          to: value
        });
      }
    }), createElement(TextControl, {
      label: __('Email subject line', 'wp-toolbelt'),
      value: subject,
      placeholder: __("Let's work together", 'wp-toolbelt'),
      onChange: function onChange(value) {
        return setAttributes({
          subject: value
        });
      }
    }), createElement("p", {
      className: "toolbelt-contact-description"
    }, __('(If you leave these blank, notifications will go to the author with the post or page title as the subject line.)', 'wp-toolbelt'))];
    var template = layout;

    if (!formTemplate[layout]) {
      template = 'default';
    }

    return [createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Email Feedback Settings', 'wp-toolbelt'),
      initialOpen: true
    }, form_settings), createElement(PanelBody, {
      title: __('Messages', 'wp-toolbelt')
    }, createElement(TextControl, {
      label: __('Submit Button Text', 'wp-toolbelt'),
      value: submitButtonText,
      onChange: function onChange(value) {
        return setAttributes({
          submitButtonText: value
        });
      }
    }), createElement(TextareaControl, {
      label: __('Confirmation Message'),
      value: messageConfirmation,
      onChange: function onChange(value) {
        return setAttributes({
          messageConfirmation: value
        });
      }
    }))), createElement(Fragment, null, createElement(Placeholder, {
      icon: "email",
      label: __('Contact Form', 'wp-toolbelt'),
      className: "toolbelt-contact-form-settings"
    }, createElement("form", null, form_settings)), createElement(InnerBlocks, {
      allowedBlocks: ALLOWED_BLOCKS,
      templateLock: false,
      template: formTemplate[template]
    }), createElement("button", {
      disabled: true
    }, submitButtonText))];
  };
  /**
   * The block settings.
   */


  var renderMaterialIcon = function renderMaterialIcon(svg) {
    return createElement(SVG, {
      xmlns: "http://www.w3.org/2000/svg",
      width: "24",
      height: "24",
      viewBox: "0 0 24 24"
    }, createElement(Path, {
      fill: "none",
      d: "M0 0h24v24H0V0z"
    }), svg);
  };

  var getFormTemplate = function getFormTemplate() {};

  var formTemplate = {
    "default": [['toolbelt/field-name', {
      required: true,
      label: __('Name', 'wp-toolbelt')
    }], ['toolbelt/field-email', {
      required: true,
      label: __('Email Address', 'wp-toolbelt')
    }], ['toolbelt/field-textarea', {
      label: __('Message', 'wp-toolbelt')
    }]],
    feedback: [['toolbelt/field-radio', {
      label: __('Feedback Type', 'wp-toolbelt'),
      options: [__('Comment', 'wp-toolbelt'), __('Feedback', 'wp-toolbelt'), __('Question', 'wp-toolbelt')]
    }], ['toolbelt/field-textarea', {
      label: __('Message', 'wp-toolbelt')
    }], ['toolbelt/field-name', {
      required: true,
      label: __('Name', 'wp-toolbelt')
    }], ['toolbelt/field-email', {
      required: true,
      label: __('Email Address', 'wp-toolbelt')
    }]],
    nps: [['toolbelt/field-radio', {
      label: __('How likely is it that you would recommend our company/product/service to a friend or colleague?', 'wp-toolbelt'),
      description: __('0 = least likely, 10 = most likely', 'wp-toolbelt'),
      options: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      require: true,
      layout: 'horizontal'
    }], ['toolbelt/field-textarea', {
      label: __('Why?', 'wp-toolbelt')
    }], ['toolbelt/field-name', {
      required: true,
      label: __('Name', 'wp-toolbelt')
    }], ['toolbelt/field-email', {
      required: true,
      label: __('Email Address', 'wp-toolbelt')
    }]]
  };
  var settings = {
    title: __('TB Contact Form', 'wp-toolbelt'),
    description: __('Use the form builder to create your own forms.', 'wp-toolbelt'),
    icon: 'email',
    category: 'wp-toolbelt',
    keywords: [_x('email contact', 'block search term', 'wp-toolbelt'), _x('feedback', 'block search term', 'wp-toolbelt'), _x('toolbelt', 'block search term', 'wp-toolbelt')],
    supports: {
      reusable: false,
      html: false
    },
    attributes: {
      subject: {
        type: 'string',
        "default": ''
      },
      to: {
        type: 'string',
        "default": ''
      },
      submitButtonText: {
        type: 'string',
        "default": __('Submit', 'wp-toolbelt')
      },
      messageConfirmation: {
        type: 'string',
        "default": ''
      },
      layout: {
        type: 'string',
        "default": ''
      }
    },

    /**
     * We save the form data here.
     * The actual html is generated in module-fields.php.
     */
    save: function save() {
      return createElement(InnerBlocks.Content, null);
    },
    edit: edit,
    example: {
      attributes: {
        submitButtonText: __('Submit', 'wp-toolbelt')
      },
      innerBlocks: [{
        name: 'toolbelt/field-name',
        attributes: {
          label: __('Name', 'wp-toolbelt'),
          required: true
        }
      }, {
        name: 'toolbelt/field-email',
        attributes: {
          label: __('Email', 'wp-toolbelt'),
          required: true
        }
      }, {
        name: 'toolbelt/field-textarea',
        attributes: {
          label: __('Message', 'wp-toolbelt')
        }
      }]
    }
  };
  var AttributeDefaults = {
    label: {
      type: 'string',
      "default": null
    },
    required: {
      type: 'boolean',
      "default": false
    },
    description: {
      type: 'string',
      "default": ''
    },
    options: {
      type: 'array',
      "default": []
    },
    defaultValue: {
      type: 'string',
      "default": ''
    },
    placeholder: {
      type: 'string',
      "default": ''
    }
  };
  var FieldTransforms = {
    to: [{
      type: 'block',
      blocks: ['toolbelt/field-text'],
      isMatch: function isMatch(_ref) {
        var options = _ref.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-text', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-name'],
      isMatch: function isMatch(_ref2) {
        var options = _ref2.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-name', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-email'],
      isMatch: function isMatch(_ref3) {
        var options = _ref3.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-email', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-url'],
      isMatch: function isMatch(_ref4) {
        var options = _ref4.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-url', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-date'],
      isMatch: function isMatch(_ref5) {
        var options = _ref5.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-date', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-telephone'],
      isMatch: function isMatch(_ref6) {
        var options = _ref6.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-telephone', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-textarea'],
      isMatch: function isMatch(_ref7) {
        var options = _ref7.options;
        return !options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-textarea', attributes);
      }
    }]
  };
  var MultiFieldTransforms = {
    to: [{
      type: 'block',
      blocks: ['toolbelt/field-checkbox-multiple'],
      isMatch: function isMatch(_ref8) {
        var options = _ref8.options;
        return 1 <= options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-checkbox-multiple', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-radio'],
      isMatch: function isMatch(_ref9) {
        var options = _ref9.options;
        return 1 <= options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-radio', attributes);
      }
    }, {
      type: 'block',
      blocks: ['toolbelt/field-select'],
      isMatch: function isMatch(_ref10) {
        var options = _ref10.options;
        return 1 <= options.length;
      },
      transform: function transform(attributes) {
        return createBlock('toolbelt/field-select', attributes);
      }
    }]
  };
  var FieldDefaults = {
    category: 'wp-toolbelt',
    parent: ['toolbelt/contact-form'],
    supports: {
      reusable: false,
      html: false
    },
    attributes: AttributeDefaults,
    transforms: FieldTransforms,
    save: function save() {
      return null;
    }
  };

  var getFieldLabel = function getFieldLabel(_ref11) {
    var attributes = _ref11.attributes,
        blockName = _ref11.name;
    return null === attributes.label ? getBlockType(blockName).title : attributes.label;
  };

  var editField = function editField(type) {
    return function (props) {
      return createElement(ToolbeltField, {
        type: type,
        label: getFieldLabel(props),
        required: props.attributes.required,
        description: props.attributes.description,
        setAttributes: props.setAttributes,
        isSelected: props.isSelected,
        defaultValue: props.attributes.defaultValue,
        placeholder: props.attributes.placeholder,
        id: props.attributes.id
      });
    };
  };

  var editMultiField = function editMultiField(type) {
    return function (props) {
      return createElement(ToolbeltFieldMultiple, {
        label: getFieldLabel(props),
        required: props.attributes.required,
        options: props.attributes.options,
        description: props.attributes.description,
        setAttributes: props.setAttributes,
        type: type,
        isSelected: props.isSelected,
        id: props.attributes.id,
        layout: props.attributes.layout
      });
    };
  };

  var childBlocks = [{
    name: 'field-text',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Text', 'wp-toolbelt'),
      description: __('When you need just a small amount of text, add a text input.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M4 9h16v2H4V9zm0 4h10v2H4v-2z"
      })),
      edit: editField('text')
    })
  }, {
    name: 'field-name',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Name', 'wp-toolbelt'),
      description: __('Introductions are important. Add an input for folks to add their name.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
      })),
      edit: editField('text')
    })
  }, {
    name: 'field-subject',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Subject', 'wp-toolbelt'),
      description: __('What is the message about?', 'wp-toolbelt'),
      icon: 'email',
      edit: editField('text')
    })
  }, {
    name: 'field-email',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Email', 'wp-toolbelt'),
      keywords: [__('e-mail', 'wp-toolbelt'), __('mail', 'wp-toolbelt'), 'email'],
      description: __('Want to reply to folks? Add an email address input.', 'wp-toolbelt'),
      attributes: Object.assign({}, AttributeDefaults, {
        placeholder: {
          type: 'string',
          "default": 'name@domain.com'
        }
      }),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"
      })),
      edit: editField('email')
    })
  }, {
    name: 'field-url',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Website', 'wp-toolbelt'),
      keywords: ['url', __('internet page', 'wp-toolbelt'), 'link'],
      description: __('Add an address input for a website.', 'wp-toolbelt'),
      attributes: Object.assign({}, AttributeDefaults, {
        placeholder: {
          type: 'string',
          "default": 'https://domain.com'
        }
      }),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"
      })),
      edit: editField('url')
    })
  }, {
    name: 'field-date',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Date Picker', 'wp-toolbelt'),
      keywords: [__('Calendar', 'wp-toolbelt'), __('day month year', 'block search term', 'wp-toolbelt')],
      description: __('The best way to set a date. Add a date picker.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V9h14v10zm0-12H5V5h14v2zM7 11h5v5H7z"
      })),
      edit: editField('text')
    })
  }, {
    name: 'field-telephone',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Telephone', 'wp-toolbelt'),
      keywords: [__('Phone', 'wp-toolbelt'), __('Cellular phone', 'wp-toolbelt'), __('Mobile', 'wp-toolbelt')],
      description: __('Add a phone number input.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M6.54 5c.06.89.21 1.76.45 2.59l-1.2 1.2c-.41-1.2-.67-2.47-.76-3.79h1.51m9.86 12.02c.85.24 1.72.39 2.6.45v1.49c-1.32-.09-2.59-.35-3.8-.75l1.2-1.19M7.5 3H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.49c0-.55-.45-1-1-1-1.24 0-2.45-.2-3.57-.57-.1-.04-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.45-5.15-3.76-6.59-6.59l2.2-2.2c.28-.28.36-.67.25-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1z"
      })),
      edit: editField('tel')
    })
  }, {
    name: 'field-textarea',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Message', 'wp-toolbelt'),
      keywords: [__('Textarea', 'wp-toolbelt'), 'textarea', __('Multiline text', 'wp-toolbelt')],
      description: __('Let folks speak their mind. This text box is great for longer responses.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M21 11.01L3 11v2h18zM3 16h12v2H3zM21 6H3v2.01L21 8z"
      })),
      edit: function edit(props) {
        return createElement(ToolbeltFieldTextarea, {
          label: getFieldLabel(props),
          required: props.attributes.required,
          setAttributes: props.setAttributes,
          isSelected: props.isSelected,
          defaultValue: props.attributes.defaultValue,
          placeholder: props.attributes.placeholder,
          id: props.attributes.id
        });
      }
    })
  }, {
    name: 'field-checkbox',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Checkbox', 'wp-toolbelt'),
      keywords: [__('Confirm', 'wp-toolbelt'), __('Accept', 'wp-toolbelt')],
      description: __('Add a single checkbox.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM17.99 9l-1.41-1.42-6.59 6.59-2.58-2.57-1.42 1.41 4 3.99z"
      })),
      edit: function edit(props) {
        return createElement(ToolbeltFieldCheckbox, {
          label: props.attributes.label // label intentinally left blank
          ,
          required: props.attributes.required,
          description: props.attributes.description,
          setAttributes: props.setAttributes,
          isSelected: props.isSelected,
          defaultValue: props.attributes.defaultValue,
          id: props.attributes.id
        });
      },
      attributes: Object.assign({}, FieldDefaults.attributes, {
        label: {
          type: 'string',
          "default": ''
        }
      })
    })
  }, {
    name: 'field-checkbox-multiple',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Checkbox Group', 'wp-toolbelt'),
      keywords: [__('Choose Multiple', 'wp-toolbelt'), __('Option', 'wp-toolbelt')],
      description: __('People love options. Add several checkbox items.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z"
      })),
      edit: editMultiField('checkbox'),
      transforms: MultiFieldTransforms,
      attributes: Object.assign({}, FieldDefaults.attributes, {
        layout: {
          type: 'string',
          "default": 'vertical'
        },
        label: {
          type: 'string',
          "default": __('Select several', 'wp-toolbelt')
        }
      })
    })
  }, {
    name: 'field-radio',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Radio', 'wp-toolbelt'),
      keywords: [__('Choose', 'wp-toolbelt'), __('Select', 'wp-toolbelt'), __('Option', 'wp-toolbelt')],
      description: __('Inspired by radios, only one radio item can be selected at a time. Add several radio button items.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Fragment, null, createElement(Path, {
        d: "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"
      }), createElement(Circle, {
        cx: "12",
        cy: "12",
        r: "5"
      }))),
      edit: editMultiField('radio'),
      transforms: MultiFieldTransforms,
      attributes: Object.assign({}, FieldDefaults.attributes, {
        layout: {
          type: 'string',
          "default": 'vertical'
        },
        label: {
          type: 'string',
          "default": __('Select one', 'wp-toolbelt')
        }
      })
    })
  }, {
    name: 'field-select',
    settings: Object.assign({}, FieldDefaults, {
      title: __('TB Select', 'wp-toolbelt'),
      keywords: [__('Choose', 'wp-toolbelt'), __('Dropdown', 'wp-toolbelt'), __('Option', 'wp-toolbelt')],
      description: __('Compact, but powerful. Add a select box with several items.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M3 17h18v2H3zm16-5v1H5v-1h14m2-2H3v5h18v-5zM3 6h18v2H3z"
      })),
      edit: editMultiField('select'),
      transforms: MultiFieldTransforms,
      attributes: Object.assign({}, FieldDefaults.attributes, {
        label: {
          type: 'string',
          "default": __('Select one', 'wp-toolbelt')
        }
      })
    })
  }];
  /**
   * The individual form components.
   */

  /**
   * Toolbelt Field Checkbox
   *
   * A field used specifically for checkbox items.
   */

  function ToolbeltFieldCheckbox(_ref12) {
    var label = _ref12.label,
        setAttributes = _ref12.setAttributes,
        defaultValue = _ref12.defaultValue,
        isSelected = _ref12.isSelected,
        description = _ref12.description,
        required = _ref12.required;
    return createElement(Fragment, null, createElement("div", {
      className: "toolbelt-field-checkbox"
    }, createElement("input", {
      className: "toolbelt-field-checkbox__checkbox",
      type: "checkbox",
      disabled: true,
      checked: defaultValue
    }), isSelected && createElement(Fragment, null, createElement("input", {
      type: "text",
      className: "toolbelt-field-label-text",
      value: label,
      onChange: function onChange(event) {
        return setAttributes({
          label: event.target.value
        });
      }
    }), createElement(TextareaControl, {
      label: __('Description', 'wp-toolbelt'),
      value: description,
      className: "toolbelt-field-label-description",
      onChange: function onChange(value) {
        setAttributes({
          description: value
        });
      }
    }), createElement(ToggleControl, {
      label: __('Required', 'wp-toolbelt'),
      className: "toolbelt-field-label-required",
      checked: required,
      onChange: function onChange(value) {
        return setAttributes({
          required: value
        });
      }
    })), !isSelected && createElement(Fragment, null, createElement("label", {
      className: "toolbelt-field-label-text"
    }, label), description && createElement("p", {
      className: "toolbelt-field-label-description"
    }, description))), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Field Settings', 'wp-toolbelt')
    }, createElement(TextControl, {
      label: __('Label', 'wp-toolbelt'),
      value: label,
      onChange: function onChange(value) {
        return setAttributes({
          label: value
        });
      }
    }), createElement(ToggleControl, {
      label: __('Default Checked State', 'wp-toolbelt'),
      checked: defaultValue,
      onChange: function onChange(value) {
        return setAttributes({
          defaultValue: value
        });
      }
    }))));
  }

  ;
  /**
   * Toolbelt Field
   *
   * This is a generic text field. It can have any text field type (text, url,
   * date etc) but functions the same regardless of content type.
   */

  function ToolbeltField(_ref13) {
    var type = _ref13.type,
        required = _ref13.required,
        description = _ref13.description,
        label = _ref13.label,
        setAttributes = _ref13.setAttributes,
        defaultValue = _ref13.defaultValue,
        placeholder = _ref13.placeholder,
        isSelected = _ref13.isSelected;
    return createElement(Fragment, null, createElement("div", {
      className: 'toolbelt-field'
    }, createElement(ToolbeltFieldLabel, {
      required: required,
      label: label,
      description: description,
      setAttributes: setAttributes,
      isSelected: isSelected
    }), createElement(TextControl, {
      type: type,
      placeholder: placeholder,
      value: defaultValue,
      onChange: function onChange(value) {
        return setAttributes({
          defaultValue: value
        });
      }
    })), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Field Settings', 'wp-toolbelt')
    }, createElement(TextControl, {
      label: __('Label', 'wp-toolbelt'),
      value: label,
      onChange: function onChange(value) {
        return setAttributes({
          label: value
        });
      }
    }), createElement(TextControl, {
      label: __('Default Value', 'wp-toolbelt'),
      value: defaultValue,
      onChange: function onChange(value) {
        return setAttributes({
          defaultValue: value
        });
      }
    }), createElement(TextControl, {
      label: __('Placeholder', 'wp-toolbelt'),
      value: placeholder,
      onChange: function onChange(value) {
        return setAttributes({
          placeholder: value
        });
      }
    }))));
  }
  /**
   * Toolbelt Field Label
   *
   * A generic label component. This displays a label, a 'required' flag, and
   * space for a description. It can be reused across all field types.
   */


  function ToolbeltFieldLabel(_ref14) {
    var setAttributes = _ref14.setAttributes,
        label = _ref14.label,
        required = _ref14.required,
        isSelected = _ref14.isSelected,
        description = _ref14.description;
    var thisRef = createRef();
    return createElement("div", {
      className: "toolbelt-field-label"
    }, isSelected && createElement("input", {
      type: "text",
      value: label,
      className: "toolbelt-field-label-text",
      onChange: function onChange(event) {
        setAttributes({
          label: event.target.value
        });
      },
      placeholder: __('Write label…', 'wp-toolbelt'),
      ref: thisRef
    }), !isSelected && createElement("label", {
      className: "toolbelt-field-label-text"
    }, label, "\xA0"), isSelected && createElement(Fragment, null, createElement(ToggleControl, {
      label: __('Required', 'wp-toolbelt'),
      className: "toolbelt-field-label-required",
      checked: required,
      onChange: function onChange(value) {
        return setAttributes({
          required: value
        });
      }
    }), createElement(TextareaControl, {
      label: __('Description', 'wp-toolbelt'),
      value: description,
      className: "toolbelt-field-label-description",
      onChange: function onChange(value) {
        setAttributes({
          description: value
        });
      }
    })), !isSelected && !required && createElement("em", null, "(", __('Optional', 'wp-toolbelt'), ")"), !isSelected && description && createElement("p", {
      className: "toolbelt-field-label-description"
    }, description));
  }

  ;
  /**
   * Toolbelt Field Textarea
   *
   * A textarea field.
   */

  function ToolbeltFieldTextarea(_ref15) {
    var required = _ref15.required,
        label = _ref15.label,
        setAttributes = _ref15.setAttributes,
        description = _ref15.description,
        isSelected = _ref15.isSelected;
    return createElement(Fragment, null, createElement("div", {
      className: "toolbelt-field"
    }, createElement(ToolbeltFieldLabel, {
      required: required,
      label: label,
      description: description,
      setAttributes: setAttributes,
      isSelected: isSelected
    }), createElement(TextareaControl, {
      disabled: true
    })), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Field Settings', 'wp-toolbelt')
    }, createElement(TextControl, {
      label: __('Label', 'wp-toolbelt'),
      value: label,
      onChange: function onChange(value) {
        return setAttributes({
          label: value
        });
      }
    }))));
  }
  /**
   * Toolbelt Multi Option Field.
   *
   * A field used to display multiple input types. It supports radio, checkbox,
   * and select elements.
   */


  function ToolbeltFieldMultiple(_ref16) {
    var instanceId = _ref16.instanceId,
        required = _ref16.required,
        description = _ref16.description,
        label = _ref16.label,
        isSelected = _ref16.isSelected,
        setAttributes = _ref16.setAttributes,
        options = _ref16.options,
        layout = _ref16.layout,
        type = _ref16.type;

    /**
     * Set the state focus state.
     *
     * I have written this as three variables rather than the shorter
     * `[x, y] = useState` since this works without bundling.
     */
    var focusState = useState(-1);
    var inFocus = focusState[0];
    var setInFocus = focusState[1];
    /**
     * Ensure there is at least one option so we have something to start from.
     */

    if (!options.length) {
      options = [''];
    }
    /**
     * Add a new option to the bottom of the list and set focus to that option.
     */


    var addNewOption = function addNewOption() {
      /**
       * Use options.slice to get a copy of the array rather than a reference
       * to the array.
       *
       * This allows us to edit clean data and not modify the original array
       * unintentionally.
       *
       * We will update the array later with setAttributes.
       */
      var newOptions = options.slice(0);
      newOptions.push('');
      setAttributes({
        options: newOptions
      });
      setInFocus(options.length);
    };
    /**
     * Add an option.
     */


    var updateOption = function updateOption(index, value) {
      if (!index && index !== 0) {
        return;
      }

      var optionsList = options.slice(0);
      optionsList[index] = value;
      setAttributes({
        options: optionsList
      });
      setInFocus(index);
    };
    /**
     * Remove an option.
     */


    var deleteOption = function deleteOption(index) {
      var optionsList = options.slice(0);
      var newOptions = optionsList.slice(0, index).concat(optionsList.slice(index + 1, optionsList.length));
      setAttributes({
        options: newOptions
      });

      if (index > 0) {
        setInFocus(index - 1);
      }
    };

    var keyPress = function keyPress(event, index) {
      if (event.key === 'Enter') {
        addNewOption();
        event.preventDefault();
        return;
      }

      if (event.key === 'Backspace' && event.target.value === '') {
        deleteOption(index);
        event.preventDefault();
        return;
      }
    };

    var itemLayout = layout;

    if (!layout) {
      itemLayout = 'vertical';
    }

    return createElement(Fragment, null, createElement(ToolbeltFieldLabel, {
      required: required,
      label: label,
      description: description,
      setAttributes: setAttributes,
      isSelected: isSelected
    }), createElement("ol", {
      className: "toolbelt-field-multiple toolbelt-field-multiple-".concat(type, " toolbelt-field-multiple-layout-").concat(itemLayout),
      id: "toolbelt-field-multiple-".concat(instanceId)
    }, options.map(function (option, index) {
      return createElement(ToolbeltMultiOption, {
        type: type,
        key: index,
        index: index,
        option: option,
        isSelected: isSelected,
        inFocus: inFocus,
        updateOption: updateOption,
        deleteOption: deleteOption,
        keyPress: keyPress
      });
    })), isSelected && createElement(Button, {
      className: "toolbelt-field-multiple__add-option",
      icon: "insert",
      label: __('Insert option', 'wp-toolbelt'),
      onClick: addNewOption
    }, __('Add option', 'wp-toolbelt')), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Field Settings', 'wp-toolbelt')
    }, createElement(TextControl, {
      label: __('Label', 'wp-toolbelt'),
      value: label,
      onChange: function onChange(value) {
        return setAttributes({
          label: value
        });
      }
    }), (type === 'radio' || type === 'checkbox') && createElement(RadioControl, {
      label: __('Layout', 'wp-toolbelt'),
      options: [{
        label: __('Vertical', 'wp-toolbelt'),
        value: 'vertical'
      }, {
        label: __('Horizontal', 'wp-toolbelt'),
        value: 'horizontal'
      }],
      onChange: function onChange(new_layout) {
        setAttributes({
          layout: new_layout
        });
      },
      selected: itemLayout
    }))));
  }
  /**
   * Toolbelt Option element.
   */


  function ToolbeltMultiOption(_ref17) {
    var isSelected = _ref17.isSelected,
        option = _ref17.option,
        type = _ref17.type,
        updateOption = _ref17.updateOption,
        deleteOption = _ref17.deleteOption,
        keyPress = _ref17.keyPress,
        index = _ref17.index,
        inFocus = _ref17.inFocus;
    var thisRef = createRef();
    useEffect(function () {
      if (!thisRef || !thisRef.current) {
        return;
      }

      if (index === inFocus) {
        thisRef.current.focus();
      }
    });
    return createElement("li", {
      className: "toolbelt-option"
    }, type && type !== 'select' && createElement("input", {
      className: "toolbelt-option-type",
      type: type,
      disabled: true
    }), isSelected && createElement(Fragment, null, createElement("input", {
      type: "text",
      className: "toolbelt-option-input",
      value: option,
      placeholder: __('Write option…', 'toolbelt'),
      ref: thisRef,
      onChange: function onChange(event) {
        updateOption(index, event.target.value);
      },
      onKeyDown: function onKeyDown(event) {
        keyPress(event, index);
      }
    }), createElement(Button, {
      className: "toolbelt-option-remove",
      icon: "trash",
      label: __('Remove option', 'jetpack'),
      onClick: function onClick() {
        deleteOption(index);
      }
    })), !isSelected && createElement("label", {
      className: "toolbelt-field-label-text"
    }, option, "\xA0"));
  }

  registerBlockType('toolbelt/contact-form', settings);
  wp.blocks.registerBlockVariation('toolbelt/contact-form', {
    name: 'feedback',
    title: __('TB Feedback Form', 'wp-toolbelt'),
    attributes: {
      layout: 'feedback'
    }
  });
  wp.blocks.registerBlockVariation('toolbelt/contact-form', {
    name: 'nps',
    title: __('TB Net Promoter Score (NPS) Form', 'wp-toolbelt'),
    attributes: {
      layout: 'nps'
    }
  });
  childBlocks.forEach(function (childBlock) {
    return registerBlockType("toolbelt/".concat(childBlock.name), childBlock.settings);
  });
})();