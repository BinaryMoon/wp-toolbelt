"use strict";

(function () {
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x;
  var createElement = wp.element.createElement;
  var _wp$blockEditor = wp.blockEditor,
      InspectorControls = _wp$blockEditor.InspectorControls,
      InnerBlocks = _wp$blockEditor.InnerBlocks,
      PlainText = _wp$blockEditor.PlainText;
  var _wp$blocks = wp.blocks,
      getBlockType = _wp$blocks.getBlockType,
      registerBlockType = _wp$blocks.registerBlockType;
  var _wp$element = wp.element,
      Fragment = _wp$element.Fragment,
      Component = _wp$element.Component,
      createBlock = _wp$element.createBlock,
      createRef = _wp$element.createRef,
      useEffect = _wp$element.useEffect;
  var _wp$compose = wp.compose,
      compose = _wp$compose.compose,
      withInstanceId = _wp$compose.withInstanceId;
  var _wp$components = wp.components,
      BaseControl = _wp$components.BaseControl,
      Button = _wp$components.Button,
      IconButton = _wp$components.IconButton,
      PanelBody = _wp$components.PanelBody,
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
   * External dependencies
   */

  var ALLOWED_BLOCKS = ['toolbelt/markdown', 'core/paragraph', 'core/heading', 'core/separator', 'core/spacer', 'core/subhead'];

  var edit = function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var subject = attributes.subject,
        to = attributes.to,
        submitButtonText = attributes.submitButtonText;
    return [createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Email Feedback Settings', 'wp-toolbelt'),
      initialOpen: true
    }, createElement(TextControl, {
      label: __('Email address', 'wp-toolbelt'),
      value: to,
      placeholder: __('name@example.com', 'wp-toolbelt'),
      help: __('You can enter multiple email addresses separated by commas.', 'wp-toolbelt')
    }), createElement(TextControl, {
      label: __('Email subject line', 'wp-toolbelt'),
      value: subject,
      placeholder: __("Let's work together", 'wp-toolbelt')
    })), createElement(PanelBody, {
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
      value: "hi"
    }), createElement(TextareaControl, {
      label: __('Error Message'),
      value: "nope"
    }))), createElement(Fragment, null, createElement(Placeholder, {
      label: __('Form', 'wp-toolbelt'),
      icon: "email"
    }, createElement("form", null, createElement(TextControl, {
      label: __('Email address', 'wp-toolbelt'),
      value: to,
      placeholder: __('name@example.com', 'wp-toolbelt'),
      help: __('You can enter multiple email addresses separated by commas.', 'wp-toolbelt')
    }), createElement(TextControl, {
      label: __('Email subject line', 'wp-toolbelt'),
      value: subject,
      placeholder: __("Let's work together", 'wp-toolbelt')
    }), createElement("p", {
      className: "toolbelt-intro-message"
    }, __('(If you leave these blank, notifications will go to the author with the post or page title as the subject line.)', 'wp-toolbelt')))), createElement(InnerBlocks, {
      allowedBlocks: ALLOWED_BLOCKS,
      templateLock: false,
      template: [['toolbelt/field-name', {
        required: true,
        label: __('Name', 'wp-toolbelt')
      }], ['toolbelt/field-email', {
        required: true,
        label: __('Email Address', 'wp-toolbelt')
      }], ['toolbelt/field-textarea', {}]]
    }), createElement("button", {
      disabled: true
    }, submitButtonText))];
  };

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

  var settings = {
    title: __('Contact Form', 'wp-toolbelt'),
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
      customThankyou: {
        type: 'string',
        "default": ''
      },
      customThankyouMessage: {
        type: 'string',
        "default": ''
      },
      customThankyouRedirect: {
        type: 'string',
        "default": ''
      }
    },
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
  var FieldDefaults = {
    category: 'wp-toolbelt',
    parent: ['toolbelt/contact-form'],
    supports: {
      reusable: false,
      html: false
    },
    attributes: AttributeDefaults,
    // transforms: {
    // 	to: [
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-text' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-text', attributes ),
    // 		},
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-name' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-name', attributes ),
    // 		},
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-email' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-email', attributes ),
    // 		},
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-url' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-url', attributes ),
    // 		},
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-date' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-date', attributes ),
    // 		},
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-telephone' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-telephone', attributes ),
    // 		},
    // 		{
    // 			type: 'block',
    // 			blocks: [ 'toolbelt/field-textarea' ],
    // 			isMatch: ( { options } ) => !options.length,
    // 			transform: attributes => createBlock( 'toolbelt/field-textarea', attributes ),
    // 		},
    // 		// {
    // 		// 	type: 'block',
    // 		// 	blocks: [ 'toolbelt/field-checkbox-multiple' ],
    // 		// 	isMatch: ( { options } ) => 1 <= options.length,
    // 		// 	transform: attributes => createBlock( 'toolbelt/field-checkbox-multiple', attributes ),
    // 		// },
    // 		// {
    // 		// 	type: 'block',
    // 		// 	blocks: [ 'toolbelt/field-radio' ],
    // 		// 	isMatch: ( { options } ) => 1 <= options.length,
    // 		// 	transform: attributes => createBlock( 'toolbelt/field-radio', attributes ),
    // 		// },
    // 		// {
    // 		// 	type: 'block',
    // 		// 	blocks: [ 'toolbelt/field-select' ],
    // 		// 	isMatch: ( { options } ) => 1 <= options.length,
    // 		// 	transform: attributes => createBlock( 'toolbelt/field-select', attributes ),
    // 		// },
    // 	],
    // },
    save: function save() {
      return null;
    }
  };

  var getFieldLabel = function getFieldLabel(_ref) {
    var attributes = _ref.attributes,
        blockName = _ref.name;
    return null === attributes.label ? getBlockType(blockName).title : attributes.label;
  };

  var editField = function editField(type) {
    return function (props) {
      return createElement(ToolbeltField, {
        type: type,
        label: getFieldLabel(props),
        required: props.attributes.required,
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
        setAttributes: props.setAttributes,
        type: type,
        isSelected: props.isSelected,
        id: props.attributes.id
      });
    };
  };

  var childBlocks = [{
    name: 'field-text',
    settings: Object.assign({}, FieldDefaults, {
      title: __('Text', 'wp-toolbelt'),
      description: __('When you need just a small amount of text, add a text input.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M4 9h16v2H4V9zm0 4h10v2H4v-2z"
      })),
      edit: editField('text')
    })
  }, {
    name: 'field-name',
    settings: Object.assign({}, FieldDefaults, {
      title: __('Name', 'wp-toolbelt'),
      description: __('Introductions are important. Add an input for folks to add their name.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
      })),
      edit: editField('text')
    })
  }, {
    name: 'field-email',
    settings: Object.assign({}, FieldDefaults, {
      title: __('Email', 'wp-toolbelt'),
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
      title: __('Website', 'wp-toolbelt'),
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
      title: __('Date Picker', 'wp-toolbelt'),
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
      title: __('Telephone', 'wp-toolbelt'),
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
      title: __('Message', 'wp-toolbelt'),
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
      title: __('Checkbox', 'wp-toolbelt'),
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
      title: __('Checkbox Group', 'wp-toolbelt'),
      keywords: [__('Choose Multiple', 'wp-toolbelt'), __('Option', 'wp-toolbelt')],
      description: __('People love options. Add several checkbox items.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z"
      })),
      edit: editMultiField('checkbox'),
      attributes: Object.assign({}, FieldDefaults.attributes, {
        label: {
          type: 'string',
          "default": 'Choose several'
        }
      })
    })
  }, {
    name: 'field-radio',
    settings: Object.assign({}, FieldDefaults, {
      title: __('Radio', 'wp-toolbelt'),
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
      attributes: Object.assign({}, FieldDefaults.attributes, {
        label: {
          type: 'string',
          "default": 'Choose one'
        }
      })
    })
  }, {
    name: 'field-select',
    settings: Object.assign({}, FieldDefaults, {
      title: __('Select', 'wp-toolbelt'),
      keywords: [__('Choose', 'wp-toolbelt'), __('Dropdown', 'wp-toolbelt'), __('Option', 'wp-toolbelt')],
      description: __('Compact, but powerful. Add a select box with several items.', 'wp-toolbelt'),
      icon: renderMaterialIcon(createElement(Path, {
        d: "M3 17h18v2H3zm16-5v1H5v-1h14m2-2H3v5h18v-5zM3 6h18v2H3z"
      })),
      edit: editMultiField('select'),
      attributes: Object.assign({}, FieldDefaults.attributes, {
        label: {
          type: 'string',
          "default": 'Select one'
        }
      })
    })
  }];

  function ToolbeltFieldCheckbox(_ref2) {
    var label = _ref2.label,
        setAttributes = _ref2.setAttributes,
        defaultValue = _ref2.defaultValue,
        isSelected = _ref2.isSelected;
    return createElement(Fragment, null, createElement("div", {
      className: "toolbelt-field-checkbox"
    }, createElement("input", {
      className: "toolbelt-field-checkbox__checkbox",
      type: "checkbox",
      disabled: true,
      checked: defaultValue
    }), isSelected && createElement("input", {
      type: "text",
      className: "toolbelt-field-label-text",
      value: label,
      onChange: function onChange(value) {
        return setAttributes({
          label: value
        });
      }
    }), !isSelected && createElement("label", {
      className: "toolbelt-field-label-text"
    }, label)), createElement(InspectorControls, null, createElement(PanelBody, {
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

  function ToolbeltField(_ref3) {
    var type = _ref3.type,
        required = _ref3.required,
        label = _ref3.label,
        setAttributes = _ref3.setAttributes,
        defaultValue = _ref3.defaultValue,
        placeholder = _ref3.placeholder,
        isSelected = _ref3.isSelected;
    return createElement(Fragment, null, createElement("div", {
      className: 'toolbelt-field'
    }, createElement(ToolbeltFieldLabel, {
      required: required,
      label: label,
      setAttributes: setAttributes,
      isSelected: isSelected
    }), createElement(TextControl, {
      type: type,
      placeholder: placeholder,
      value: defaultValue,
      onChange: function onChange(value) {
        return setAttributes({
          placeholder: value
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

  function ToolbeltFieldLabel(_ref4) {
    var setAttributes = _ref4.setAttributes,
        label = _ref4.label,
        required = _ref4.required,
        isSelected = _ref4.isSelected;
    var thisRef = createRef();
    return createElement("div", {
      className: "toolbelt-field-label"
    }, isSelected && createElement("input", {
      type: "text",
      value: label,
      className: "toolbelt-field-label-text",
      onChange: function onChange(value) {
        setAttributes({
          label: value
        });
      },
      placeholder: __('Write label…', 'wp-toolbelt'),
      ref: thisRef
    }), !isSelected && createElement("label", {
      className: "toolbelt-field-label-text"
    }, label, "\xA0"), isSelected && createElement(ToggleControl, {
      label: __('Required', 'wp-toolbelt'),
      className: "toolbelt-field-label-required",
      checked: required,
      onChange: function onChange(value) {
        return setAttributes({
          required: value
        });
      }
    }), !isSelected && required && createElement("em", null, "(", __('Required', 'wp-toolbelt'), ")"));
  }

  ;

  function ToolbeltFieldTextarea(_ref5) {
    var required = _ref5.required,
        label = _ref5.label,
        setAttributes = _ref5.setAttributes,
        isSelected = _ref5.isSelected;
    return createElement(Fragment, null, createElement("div", {
      className: "toolbelt-field"
    }, createElement(ToolbeltFieldLabel, {
      required: required,
      label: label,
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

  function ToolbeltFieldMultiple(_ref6) {
    var instanceId = _ref6.instanceId,
        required = _ref6.required,
        label = _ref6.label,
        isSelected = _ref6.isSelected,
        setAttributes = _ref6.setAttributes,
        options = _ref6.options,
        type = _ref6.type;

    /**
     * Ensure there is at least one option so we have something to start from.
     */
    if (!options.length) {
      options = [__('Example', 'wp-toolbelt')];
    }

    var inFocus = 0;

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
      inFocus = options.length;
    };

    var updateOption = function updateOption(index, value) {
      if (!index) {
        return;
      }

      var optionsList = options.slice(0);
      optionsList[index] = value;
      setAttributes({
        options: optionsList
      });
    };

    var deleteOption = function deleteOption(index) {
      var optionsList = options.slice(0);
      var newOptions = optionsList.slice(0, index).concat(optionsList.slice(index + 1, optionsList.length));
      setAttributes({
        options: newOptions
      });
      inFocus = index - 1;
    };

    var keyPress = function keyPress(event, index) {
      if (event.key === 'Enter') {
        inFocus = index + 1; // addNewOption();

        event.preventDefault();
        return;
      }

      if (event.key === 'Backspace' && event.target.value === '') {
        deleteOption(index);
        event.preventDefault();
        return;
      }
    };

    return createElement(Fragment, null, createElement(ToolbeltFieldLabel, {
      required: required,
      label: label,
      setAttributes: setAttributes,
      isSelected: isSelected
    }), createElement("ol", {
      className: "toolbelt-field-multiple toolbelt-field-multiple-".concat(type),
      id: "toolbelt-field-multiple-".concat(instanceId)
    }, options.map(function (option, index) {
      return createElement(ToolbeltMultiOption, {
        type: type,
        key: index,
        option: option,
        index: index,
        isSelected: isSelected,
        inFocus: inFocus,
        updateOption: updateOption,
        deleteOption: deleteOption,
        keyPress: keyPress
      });
    })), isSelected && createElement(IconButton, {
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
    })))); // onChangeOption( key = null, option = null ) {
    // 	const newOptions = this.props.options.slice( 0 );
    // 	if ( null === option ) {
    // 		// Remove a key
    // 		newOptions.splice( key, 1 );
    // 		if ( key > 0 ) {
    // 			this.setState( { inFocus: key - 1 } );
    // 		}
    // 	} else {
    // 		// update a key
    // 		newOptions.splice( key, 1, option );
    // 		this.setState( { inFocus: key } ); // set the focus.
    // 	}
    // 	this.props.setAttributes( { options: newOptions } );
    // }
    // addNewOption( key = null ) {
    // 	const newOptions = this.props.options.slice( 0 );
    // 	let inFocus = 0;
    // 	if ( 'object' === typeof key ) {
    // 		newOptions.push( '' );
    // 		inFocus = newOptions.length - 1;
    // 	} else {
    // 		newOptions.splice( key + 1, 0, '' );
    // 		inFocus = key + 1;
    // 	}
    // 	this.setState( { inFocus: inFocus } );
    // 	this.props.setAttributes( { options: newOptions } );
    // }
    // render() {
    // 	const { type, instanceId, required, label, setAttributes, isSelected, id } = this.props;
    // 	let { options } = this.props;
    // 	let { inFocus } = this.state;
    // 	if ( !options.length ) {
    // 		options = [ '' ];
    // 		inFocus = 0;
    // 	}
    // }
  }

  function ToolbeltMultiOption(_ref7) {
    var isSelected = _ref7.isSelected,
        option = _ref7.option,
        type = _ref7.type,
        updateOption = _ref7.updateOption,
        deleteOption = _ref7.deleteOption,
        keyPress = _ref7.keyPress,
        index = _ref7.index,
        inFocus = _ref7.inFocus;
    var thisRef = createRef();
    console.log(inFocus, index);
    useEffect(function () {
      if (!thisRef || !thisRef.current) {
        return;
      }

      if (index === inFocus) {
        console.log('focus', index);
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
      onChange: function onChange(value) {
        updateOption(index, value);
      },
      onKeyDown: function onKeyDown(event) {
        keyPress(event, index);
      }
    }), createElement(IconButton, {
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
  childBlocks.forEach(function (childBlock) {
    return registerBlockType("toolbelt/".concat(childBlock.name), childBlock.settings);
  });
})();