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
      Placeholder = _wp$components.Placeholder,
      TextControl = _wp$components.TextControl,
      ButtonGroup = _wp$components.ButtonGroup,
      Button = _wp$components.Button,
      Tooltip = _wp$components.Tooltip,
      Path = _wp$components.Path,
      SVG = _wp$components.SVG,
      PanelBody = _wp$components.PanelBody,
      RangeControl = _wp$components.RangeControl,
      ToggleControl = _wp$components.ToggleControl,
      SelectControl = _wp$components.SelectControl;
  var __ = wp.i18n.__;
  var _wp$blockEditor = wp.blockEditor,
      BlockIcon = _wp$blockEditor.BlockIcon,
      InnerBlocks = _wp$blockEditor.InnerBlocks,
      InspectorControls = _wp$blockEditor.InspectorControls,
      PanelColorSettings = _wp$blockEditor.PanelColorSettings,
      ContrastChecker = _wp$blockEditor.ContrastChecker,
      withColors = _wp$blockEditor.withColors;
  /**
   * Column layout icons.
   */

  var icons = {
    /* Two columns - 50/50. */
    twoEqual: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "33",
      y: "0",
      width: "29",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "0",
      y: "0",
      width: "29",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Two columns - 75/25. */
    twoLeftWide: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "43",
      y: "0",
      width: "16",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "0",
      y: "0",
      width: "39",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Two columns - 25/75. */
    twoRightWide: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "20",
      y: "0",
      width: "39",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "0",
      y: "0",
      width: "16",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three columns - 33/33/33. */
    threeEqual: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "17.500",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "21.500",
      y: "0",
      width: "17.500",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "43",
      y: "0",
      width: "17.500",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three column - 25/50/25. */
    threeWideCenter: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "11",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "15",
      y: "0",
      width: "31",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "50",
      y: "0",
      width: "11",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three column - 50/25/25. */
    threeWideLeft: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "30",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "34",
      y: "0",
      width: "11",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "49",
      y: "0",
      width: "11",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three column - 25/25/50. */
    threeWideRight: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "11",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "15",
      y: "0",
      width: "11",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "30",
      y: "0",
      width: "30",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Four column - 25/25/25/25. */
    fourEqual: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "12",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "16",
      y: "0",
      width: "12",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "32",
      y: "0",
      width: "12",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "48",
      y: "0",
      width: "12",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Four column - 40/20/20/20. */
    fourLeft: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "21",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "25",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "38",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "51",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Four column - 20/20/20/40. */
    fourRight: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "12.800",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "25.600",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "38.400",
      y: "0",
      width: "21",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Five columns - 20/20/20/20/20. */
    fiveEqual: createElement("svg", {
      viewBox: "0 0 60 30",
      height: "26",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "0",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "12.400",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "24.800",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "37.200",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "49.600",
      y: "0",
      width: "9",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Block icon. */
    blockIcon: createElement("svg", {
      viewBox: "0 0 60 34",
      height: "34",
      xmlns: "http://www.w3.org/2000/svg",
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinejoin: "round",
      strokeMiterlimit: "1.414"
    }, createElement("rect", {
      x: "38",
      y: "0",
      width: "12",
      height: "34",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "22",
      y: "0",
      width: "12",
      height: "34",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "6",
      y: "0",
      width: "12",
      height: "34",
      fill: "#6d6a6f"
    }))
  };
  var columnLayouts = {
    /**
     * 2 column layouts.
     */
    2: [{
      // 0.
      name: __('2 Columns - 50/50', 'wp-toolbelt'),
      icon: icons.twoEqual
    }, {
      // 1.
      name: __('2 Columns - 75/25', 'wp-toolbelt'),
      icon: icons.twoLeftWide
    }, {
      // 2.
      name: __('2 Columns - 25/75', 'wp-toolbelt'),
      icon: icons.twoRightWide
    }],

    /**
     * 3 column layouts.
     */
    3: [{
      // 0.
      name: __('3 Columns - 33/33/33', 'wp-toolbelt'),
      icon: icons.threeEqual
    }, {
      // 1.
      name: __('3 Columns - 25/50/25', 'wp-toolbelt'),
      icon: icons.threeWideCenter
    }, {
      // 2.
      name: __('3 Columns - 50/25/25', 'wp-toolbelt'),
      icon: icons.threeWideLeft
    }, {
      // 3.
      name: __('3 Columns - 25/25/50', 'wp-toolbelt'),
      icon: icons.threeWideRight
    }],

    /**
     * 4 column layouts.
     */
    4: [{
      // 0.
      name: __('4 Columns - 25/25/25/25', 'wp-toolbelt'),
      icon: icons.fourEqual
    }, {
      // 1.
      name: __('4 Columns - 40/20/20/20', 'wp-toolbelt'),
      icon: icons.fourLeft
    }, {
      // 2.
      name: __('4 Columns - 20/20/20/40', 'wp-toolbelt'),
      icon: icons.fourRight
    }],

    /**
     * 5 column layouts.
     */
    5: [{
      name: __('5 Columns', 'wp-toolbelt'),
      icon: icons.fiveEqual
    }]
  };

  var gridInspector = function gridInspector(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var columns = attributes.columns,
        layout = attributes.layout,
        textColor = attributes.textColor,
        backgroundColor = attributes.backgroundColor;
    var layouts = [];

    if (columnLayouts[columns]) {
      layouts = columnLayouts[columns];
    }

    return createElement(InspectorControls, null, layouts && createElement(PanelBody, {
      title: __('General', 'wp-toolbelt'),
      initialOpen: true,
      className: "toolbelt-column-select-panel"
    }, createElement("p", null, __('Column Layout', 'wp-toolbelt')), createElement("div", {
      className: "toolbelt-grid-buttongroup"
    }, layouts.map(function (_ref, index) {
      var name = _ref.name,
          icon = _ref.icon;
      var class_name = 'toolbelt-grid-button';

      if (index === layout) {
        class_name += ' toolbelt-selected';
      }

      return createElement(Button, {
        key: 'col' + index,
        className: class_name,
        isSmall: true,
        "data-index": index,
        onClick: function onClick() {
          setAttributes({
            layout: index
          }); //this.setState( { selectLayout: false } );
        }
      }, icon);
    }))), createElement(PanelColorSettings, {
      title: __('Color Settings', 'wp-toolbelt'),
      initialOpen: false,
      colorSettings: [{
        value: textColor,
        onChange: function onChange(newColor) {
          return setAttributes({
            textColor: newColor
          });
        },
        label: __('Text Color', 'wp-toolbelt')
      }, {
        value: backgroundColor,
        onChange: function onChange(newColor) {
          return setAttributes({
            backgroundColor: newColor
          });
        },
        label: __('Background Color', 'wp-toolbelt')
      }]
    }));
  };

  var getColumnsTemplate = function getColumnsTemplate(columns) {
    var index = -1;
    var result = Array(columns);

    while (++index < columns) {
      result[index] = ['core/column'];
    }

    return result;
  };

  var getWrapperClass = function getWrapperClass(props) {
    var _props$attributes = props.attributes,
        columns = _props$attributes.columns,
        layout = _props$attributes.layout,
        textColor = _props$attributes.textColor,
        backgroundColor = _props$attributes.backgroundColor;
    var className = ['wp-block-toolbelt-layout-grid'];
    var grid_column = 2;
    var grid_layout = 0;

    if (columns) {
      grid_column = columns;
    }

    if (layout) {
      grid_layout = layout;
    }

    className.push("toolbelt-grid-layout-".concat(grid_column, "-").concat(grid_layout));

    if (backgroundColor) {
      className.push('has-background');
    }

    if (textColor) {
      className.push('has-text-color');
    }

    return className.join(' ');
  };

  var gridEdit = function gridEdit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var columns = attributes.columns,
        layout = attributes.layout,
        textColor = attributes.textColor,
        backgroundColor = attributes.backgroundColor;
    var ALLOWED_BLOCKS = ['core/column'];
    console.log(attributes);
    var columnOptions = [{
      name: __('2 Columns', 'toolbelt'),
      key: 'two-column',
      columns: 2,
      icon: icons.twoEqual
    }, {
      name: __('3 Columns', 'toolbelt'),
      key: 'three-column',
      columns: 3,
      icon: icons.threeEqual
    }, {
      name: __('4 Columns', 'toolbelt'),
      key: 'four-column',
      columns: 4,
      icon: icons.fourEqual
    }, {
      name: __('5 Columns', 'toolbelt'),
      key: 'five-column',
      columns: 5,
      icon: icons.fiveEqual
    }];

    if (!columns) {
      return [createElement(Placeholder, {
        key: "placeholder",
        icon: "editor-table",
        label: __('Column Count', 'toolbelt'),
        instructions: __('Select the number of columns for this layout.', 'toolbelt'),
        className: 'toolbelt-layout-grid-placeholder'
      }, createElement(ButtonGroup, {
        "aria-label": __('Select Number of Columns', 'toolbelt'),
        className: "toolbelt-column-selector-group"
      }, columnOptions.map(function (_ref2) {
        var name = _ref2.name,
            key = _ref2.key,
            icon = _ref2.icon,
            columns = _ref2.columns;
        return createElement(Tooltip, {
          text: name,
          key: key
        }, createElement(Button, {
          className: "toolbelt-column-selector-button",
          onClick: function onClick() {
            return setAttributes({
              columns: columns
            });
          }
        }, icon));
      })))];
    }

    return [createElement("div", {
      className: getWrapperClass(props),
      style: {
        backgroundColor: backgroundColor,
        color: textColor
      }
    }, createElement(InnerBlocks, {
      template: getColumnsTemplate(columns),
      templateLock: "all",
      allowedBlocks: ALLOWED_BLOCKS,
      orientation: "horizontal"
    })), gridInspector(props)];
  };

  var gridSave = function gridSave(props) {
    var attributes = props.attributes;
    var backgroundColor = attributes.backgroundColor,
        textColor = attributes.textColor;
    return createElement("div", {
      className: getWrapperClass(props),
      style: {
        backgroundColor: backgroundColor,
        color: textColor
      }
    }, createElement(InnerBlocks.Content, null));
  }; //


  registerBlockType('toolbelt/layout-grid', {
    title: __('Layout Grid', 'wp-toolbelt'),
    description: __('Flexible content display', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('layout grid columns', 'wp-toolbelt')],
    icon: 'editor-table',
    category: 'wp-toolbelt',
    attributes: {
      columns: {
        type: 'int'
      },
      layout: {
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
    save: gridSave,
    edit: gridEdit
  });
})();