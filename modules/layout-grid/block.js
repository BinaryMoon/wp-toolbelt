"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var _wp$element = wp.element,
      createElement = _wp$element.createElement,
      Fragment = _wp$element.Fragment,
      Component = _wp$element.Component;
  var select = wp.data.select;
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
      RadioControl = _wp$components.RadioControl,
      RangeControl = _wp$components.RangeControl,
      ToggleControl = _wp$components.ToggleControl,
      SelectControl = _wp$components.SelectControl;
  var __ = wp.i18n.__;
  var _wp$blockEditor = wp.blockEditor,
      BlockIcon = _wp$blockEditor.BlockIcon,
      InnerBlocks = _wp$blockEditor.InnerBlocks,
      InspectorControls = _wp$blockEditor.InspectorControls,
      PanelColorSettings = _wp$blockEditor.PanelColorSettings,
      ContrastChecker = _wp$blockEditor.ContrastChecker;
  /**
   * Column layout icons.
   */

  var iconHeader = {
    viewBox: '0 0 60 30',
    height: '26',
    xmlns: 'http://www.w3.org/2000/svg',
    fillRule: 'evenodd',
    clipRule: 'evenodd',
    strokeLinejoin: 'round',
    strokeMiterlimit: '1.414'
  };
  var icons = {
    /* Two columns - 50/50. */
    twoEqual: createElement("svg", iconHeader, createElement("rect", {
      x: "32",
      y: "0",
      width: "28",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "0",
      y: "0",
      width: "28",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Two columns - 75/25. */
    twoLeftWide: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "42",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "46",
      y: "0",
      width: "14",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Two columns - 25/75. */
    twoRightWide: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "14",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "18",
      y: "0",
      width: "42",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Two columns - 75/25. */
    twoLeftWideThird: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "37",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "41",
      y: "0",
      width: "18",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Two columns - 25/75. */
    twoRightWideThird: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "18",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "22",
      y: "0",
      width: "37",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three columns - 33/33/33. */
    threeEqual: createElement("svg", iconHeader, createElement("rect", {
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
    threeWideCenter: createElement("svg", iconHeader, createElement("rect", {
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

    /* Three column - 25/50/25. */
    threeWideCenterSmallLeft: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "8",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "12",
      y: "0",
      width: "25",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "41",
      y: "0",
      width: "17",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three column - 25/50/25. */
    threeWideCenterSmallCenter: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "25",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "29",
      y: "0",
      width: "8",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "41",
      y: "0",
      width: "17",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Three column - 50/25/25. */
    threeWideLeft: createElement("svg", iconHeader, createElement("rect", {
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
    threeWideRight: createElement("svg", iconHeader, createElement("rect", {
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
    fourEqual: createElement("svg", iconHeader, createElement("rect", {
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

    /* Four column - 50/16/16/16. */
    fourLeft: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "24",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "28",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "39",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "50",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Four column - 20/20/20/40. */
    fourRight: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "11",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "22",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "33",
      y: "0",
      width: "24",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Four column - 16/33/33/16. */
    fourCenter: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "11",
      y: "0",
      width: "15",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "30",
      y: "0",
      width: "15",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "49",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    })),

    /* Four column - 33/16/16/33. */
    fourOutside: createElement("svg", iconHeader, createElement("rect", {
      x: "0",
      y: "0",
      width: "15",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "19",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "30",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "41",
      y: "0",
      width: "15",
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
  /**
   * HTML for the generated column.
   *
   * @param {array} props The layout properties.
   * @return {string}
   */

  var colSave = function colSave(props) {
    return createElement("div", {
      className: getColClass(props)
    }, createElement(InnerBlocks.Content, null));
  };
  /**
   * Get the column classes.
   *
   * @param {array} props The layout properties.
   * @return {string}
   */


  var getColClass = function getColClass(props) {
    var className = props.className,
        attributes = props.attributes;
    var alignment = attributes.alignment;
    var classes = ['toolbelt-column-align-' + alignment];
    var newClassName = className;

    if (newClassName === undefined || newClassName === 'undefined') {
      newClassName = '';
    }

    newClassName = newClassName + ' ' + classes.join(' ');
    newClassName = newClassName.replace('undefined', '');
    return newClassName;
  };
  /**
   * HTML for editing the column properties.
   *
   * @param {array} props The layout properties.
   * @return {string}
   */


  var colEdit = function colEdit(props) {
    var className = props.className,
        clientId = props.clientId,
        attributes = props.attributes,
        setAttributes = props.setAttributes;
    var alignment = attributes.alignment;
    /**
     * Count the innerblocks.
     *
     * We use this to decide whether or not to display the large 'add block'
     * button on internal content.
     *
     * @see https://stackoverflow.com/questions/53345956/gutenberg-custom-block-add-elements-by-innerblocks-length
     */

    var blocks = select('core/editor').getBlocksByClientId(clientId)[0];
    var blockCount = 0;

    if (blocks) {
      blockCount = blocks.innerBlocks.length;
    }

    var hasChildBlocks = blockCount > 0;
    return [createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Column Layout', 'wp-toolbelt'),
      initialOpen: true
    }, createElement(RadioControl, {
      label: __('Alignment', 'wp-toolbelt'),
      selected: alignment,
      options: [{
        label: __('Top', 'wp-toolbelt'),
        value: 'top'
      }, {
        label: __('Middle', 'wp-toolbelt'),
        value: 'middle'
      }, {
        label: __('Bottom', 'wp-toolbelt'),
        value: 'bottom'
      }, {
        label: __('Space Between', 'wp-toolbelt'),
        value: 'space-between'
      }],
      onChange: function onChange(newAlignment) {
        return setAttributes({
          'alignment': newAlignment
        });
      }
    }))), createElement("div", {
      className: getColClass(props)
    }, createElement(InnerBlocks, {
      templateLock: false,
      renderAppender: hasChildBlocks ? undefined : function () {
        return createElement(InnerBlocks.ButtonBlockAppender, null);
      }
    }))];
  };

  registerBlockType('toolbelt/column', {
    title: __('TB Column', 'wp-toolbelt'),
    description: __('Columns for your layout.', 'wp-toolbelt'),
    parent: ['toolbelt/layout-grid'],
    styles: [{
      name: 'normal',
      label: __('Default', 'wp-toolbelt'),
      isDefault: true
    }, {
      name: 'border-top',
      label: __('Border Top', 'wp-toolbelt')
    }, {
      name: 'padded',
      label: __('Has Padding', 'wp-toolbelt')
    }],
    attributes: {
      alignment: {
        type: 'string',
        "default": 'top'
      }
    },
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
    save: colSave,
    edit: colEdit
  });
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
    }, {
      // 3.
      name: __('2 Columns - 66/33', 'wp-toolbelt'),
      icon: icons.twoLeftWideThird
    }, {
      // 4.
      name: __('2 Columns - 33/66', 'wp-toolbelt'),
      icon: icons.twoRightWideThird
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
    }, {
      // 4.
      name: __('3 Columns - 16/50/33', 'wp-toolbelt'),
      icon: icons.threeWideCenterSmallLeft
    }, {
      // 5.
      name: __('3 Columns - 16/15/33', 'wp-toolbelt'),
      icon: icons.threeWideCenterSmallCenter
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
    }, {
      // 3.
      name: __('4 Columns - 16/33/33/16', 'wp-toolbelt'),
      icon: icons.fourCenter
    }, {
      // 4.
      name: __('4 Columns - 33/16/16/33', 'wp-toolbelt'),
      icon: icons.fourOutside
    }]
  };
  /**
   * Create the React code for the inspector functionality.
   *
   * @param {array} props The block properties.
   * @param {array}
   */

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
      title: __('Column Layout', 'wp-toolbelt'),
      initialOpen: true,
      className: "toolbelt-column-select-panel"
    }, createElement("div", {
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
        title: name,
        onClick: function onClick() {
          setAttributes({
            layout: index
          });
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
  /**
   * Generate the html for the block template.
   *
   * @param {int} columns The number of columns.
   * @return {string}
   */


  var getColumnsTemplate = function getColumnsTemplate(columns) {
    var index = -1;
    var result = Array(columns);

    while (++index < columns) {
      result[index] = ['toolbelt/column'];
    }

    return result;
  };
  /**
   * Get the class list for the layout grid wrapper.
   *
   * @param {array} props The list of block properties.
   * @return {string}
   */


  var getWrapperClass = function getWrapperClass(props) {
    var attributes = props.attributes,
        className = props.className;
    var columns = attributes.columns,
        layout = attributes.layout,
        textColor = attributes.textColor,
        backgroundColor = attributes.backgroundColor;
    var classNames = ['wp-block-toolbelt-layout-grid', className];
    var grid_column = 2;
    var grid_layout = 0;

    if (columns) {
      grid_column = columns;
    }

    if (layout) {
      grid_layout = layout;
    }

    classNames.push("toolbelt-grid-layout-".concat(grid_column, "-").concat(grid_layout));

    if (backgroundColor) {
      classNames.push('has-background');
    }

    if (textColor) {
      classNames.push('has-text-color');
    }

    return classNames.join(' ');
  };
  /**
   * Create the React code for the editing functionality.
   *
   * @param {array} props The block properties.
   * @param {array}
   */


  var gridEdit = function gridEdit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var columns = attributes.columns,
        textColor = attributes.textColor,
        backgroundColor = attributes.backgroundColor;
    var ALLOWED_BLOCKS = ['toolbelt/column'];
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
      allowedBlocks: ALLOWED_BLOCKS
    })), gridInspector(props)];
  };
  /**
   * The saved html for the grid layout.
   *
   * @param {array} props The block properties.
   * @param {string}
   */


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
  };

  registerBlockType('toolbelt/layout-grid', {
    title: __('TB Layout Grid', 'wp-toolbelt'),
    description: __('Flexible content display', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('layout grid columns', 'wp-toolbelt')],
    icon: 'editor-table',
    category: 'wp-toolbelt',
    styles: [{
      name: 'normal',
      label: __('Default', 'wp-toolbelt'),
      isDefault: true
    }, {
      name: 'padded',
      label: __('Has Padding', 'wp-toolbelt')
    }],
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