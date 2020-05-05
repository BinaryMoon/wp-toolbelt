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
      SVG = _wp$components.SVG;
  var __ = wp.i18n.__;
  var BlockIcon = wp.blockEditor.BlockIcon;
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

    /* Five columns - 16/16/16/16/16. */
    sixEqual: createElement("svg", {
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
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "10.330",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "20.660",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "30.990",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "41.320",
      y: "0",
      width: "7",
      height: "30",
      fill: "#6d6a6f"
    }), createElement("rect", {
      x: "51.650",
      y: "0",
      width: "7",
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
    /* 2 column layouts. */
    2: [{
      name: __('2 Columns - 50/50', 'atomic-blocks'),
      key: 'ab-2-col-equal',
      col: 2,
      icon: icons.twoEqual
    }, {
      name: __('2 Columns - 75/25', 'atomic-blocks'),
      key: 'ab-2-col-wideleft',
      col: 2,
      icon: icons.twoLeftWide
    }, {
      name: __('2 Columns - 25/75', 'atomic-blocks'),
      key: 'ab-2-col-wideright',
      col: 2,
      icon: icons.twoRightWide
    }],

    /* 3 column layouts. */
    3: [{
      name: __('3 Columns - 33/33/33', 'atomic-blocks'),
      key: 'ab-3-col-equal',
      col: 3,
      icon: icons.threeEqual
    }, {
      name: __('3 Columns - 25/50/25', 'atomic-blocks'),
      key: 'ab-3-col-widecenter',
      col: 3,
      icon: icons.threeWideCenter
    }, {
      name: __('3 Columns - 50/25/25', 'atomic-blocks'),
      key: 'ab-3-col-wideleft',
      col: 3,
      icon: icons.threeWideLeft
    }, {
      name: __('3 Columns - 25/25/50', 'atomic-blocks'),
      key: 'ab-3-col-wideright',
      col: 3,
      icon: icons.threeWideRight
    }],

    /* 4 column layouts. */
    4: [{
      name: __('4 Columns - 25/25/25/25', 'atomic-blocks'),
      key: 'ab-4-col-equal',
      col: 4,
      icon: icons.fourEqual
    }, {
      name: __('4 Columns - 40/20/20/20', 'atomic-blocks'),
      key: 'ab-4-col-wideleft',
      col: 4,
      icon: icons.fourLeft
    }, {
      name: __('4 Columns - 20/20/20/40', 'atomic-blocks'),
      key: 'ab-4-col-wideright',
      col: 4,
      icon: icons.fourRight
    }],

    /* 5 column layouts. */
    5: [{
      name: __('5 Columns', 'atomic-blocks'),
      key: 'ab-5-col-equal',
      col: 5,
      icon: icons.fiveEqual
    }],

    /* 6 column layouts. */
    6: [{
      name: __('6 Columns', 'atomic-blocks'),
      key: 'ab-6-col-equal',
      col: 6,
      icon: icons.sixEqual
    }]
  };

  var gridEdit = function gridEdit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var columns = attributes.columns;
    var ALLOWED_BLOCKS = ['core/column'];
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
    }, {
      name: __('6 Columns', 'toolbelt'),
      key: 'six-column',
      columns: 6,
      icon: icons.sixEqual
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
      }, columnOptions.map(function (_ref) {
        var name = _ref.name,
            key = _ref.key,
            icon = _ref.icon,
            columns = _ref.columns;
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
      className: className ? className : undefined
    }, createElement(InnerBlocks, {
      allowedBlocks: ALLOWED_BLOCKS
    }))];
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
      pattern: {
        type: 'string'
      }
    },
    supports: {
      align: ['full', 'wide']
    },
    save: function save() {},

    /**
     * Edit the settings.
     */
    edit: gridEdit
  });
  registerBlockType('toolbelt/layout-column', {
    title: __('Layout Grid Column', 'wp-toolbelt'),
    description: __('Flexible content display', 'wp-toolbelt'),
    keywords: [__('toolbelt', 'wp-toolbelt'), __('layout grid columns', 'wp-toolbelt')],
    icon: 'table',
    category: 'wp-toolbelt',
    parent: ['toolbelt/layout-grid'],
    attributes: {},
    save: function save() {},

    /**
     * Edit the settings.
     */
    edit: function edit(props) {
      var attributes = props.attributes,
          setAttributes = props.setAttributes,
          instanceId = props.instanceId;
      var url = attributes.url;
      return createElement("div", {
        className: "toolbelt-layout-column"
      });
    }
  });
})();