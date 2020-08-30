"use strict";

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var createElement = wp.element.createElement;
  var _wp$blockEditor = wp.blockEditor,
      AlignmentToolbar = _wp$blockEditor.AlignmentToolbar,
      BlockControls = _wp$blockEditor.BlockControls,
      InspectorControls = _wp$blockEditor.InspectorControls,
      PanelColorSettings = _wp$blockEditor.PanelColorSettings;
  var _wp$components = wp.components,
      RangeControl = _wp$components.RangeControl,
      PanelBody = _wp$components.PanelBody,
      Path = _wp$components.Path,
      SVG = _wp$components.SVG;
  var ENTER = wp.keycodes.ENTER;
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x,
      sprintf = _wp$i18n.sprintf;

  var getColor = function getColor(props) {
    return props && props.color ? props.color : 'currentColor';
  };

  var getClassName = function getClassName(props) {
    return props && props.className ? props.className : '';
  };

  var StarIcon = function StarIcon(props) {
    var color = getColor(props);
    var className = getClassName(props);
    return createElement(SVG, {
      xmlns: "http://www.w3.org/2000/svg",
      width: "24",
      height: "24",
      viewBox: "0 0 24 24",
      color: color
    }, createElement(Path, {
      className: className,
      fill: color,
      stroke: color,
      d: "M12,17.3l6.2,3.7l-1.6-7L22,9.2l-7.2-0.6L12,2L9.2,8.6L2,9.2L7.5,14l-1.6,7L12,17.3z"
    }));
  };

  var Rating = function Rating(_ref) {
    var id = _ref.id,
        setRating = _ref.setRating,
        children = _ref.children;

    var setNewRating = function setNewRating(newRating) {
      return function () {
        return setRating(newRating);
      };
    };

    var maybeSetNewRating = function maybeSetNewRating(newRating) {
      return function (_ref2) {
        var keyCode = _ref2.keyCode;
        return keyCode === ENTER ? setRating(newRating) : null;
      };
    };

    return createElement("span", {
      className: "toolbelt-ratings-button",
      "data-position": id,
      tabIndex: 0,
      role: "button",
      onClick: setNewRating(id),
      onKeyDown: maybeSetNewRating(id)
    }, children);
  };

  var edit = function edit(props) {
    var className = props.className,
        setAttributes = props.setAttributes,
        _props$attributes = props.attributes,
        align = _props$attributes.align,
        color = _props$attributes.color,
        rating = _props$attributes.rating,
        maxRating = _props$attributes.maxRating;

    var setNewMaxRating = function setNewMaxRating(newMaxRating) {
      return setAttributes({
        maxRating: newMaxRating
      });
    };

    var setNewColor = function setNewColor(newColor) {
      return setAttributes({
        color: newColor
      });
    };

    var setNewRating = function setNewRating(newRating) {
      /**
       * If the same star is clicked more than once then we make it a half
       * star.
       */
      if (newRating === rating) {
        /**
         * If the number rounded up = the current rating, then they are a
         * whole number, so let's subtract half to make it a half star.
         */
        if (Math.ceil(rating) === rating) {
          // Whole number.
          newRating = newRating - 0.5;
        }
      }

      setAttributes({
        rating: newRating
      });
    };

    return [createElement(BlockControls, null, createElement(AlignmentToolbar, {
      value: align,
      onChange: function onChange(nextAlign) {
        return setAttributes({
          align: nextAlign
        });
      }
    })), createElement("div", {
      className: className,
      style: {
        textAlign: align
      }
    }, range(1, maxRating + 1).map(function (position) {
      return createElement(Rating, {
        key: position,
        id: position,
        setRating: setNewRating
      }, createElement("span", null, createElement(StarIcon, {
        color: color,
        className: rating >= position - 0.5 ? null : 'is-rating-unfilled'
      })), createElement("span", null, createElement(StarIcon, {
        color: color,
        className: rating >= position ? null : 'is-rating-unfilled'
      })));
    })), createElement(InspectorControls, null, createElement(PanelBody, {
      title: __('Settings', 'wp-toolbelt')
    }, createElement(RangeControl, {
      label: __('Highest rating', 'wp-toolbelt'),
      value: maxRating,
      onChange: setNewMaxRating,
      min: 2,
      max: 10
    }), createElement(PanelColorSettings, {
      title: __('Color Settings', 'wp-toolbelt'),
      initialOpen: true,
      colorSettings: [{
        value: color,
        onChange: setNewColor,
        label: __('Color', 'wp-toolbelt')
      }]
    })))];
  };
  /**
   * Save the data.
   * This data is only used in the editor or as a fallback. It's not actually
   * displayed on the front end because that's rendered with PHP.
   */


  var save = function save(props) {
    var className = props.className,
        _props$attributes2 = props.attributes,
        align = _props$attributes2.align,
        rating = _props$attributes2.rating,
        maxRating = _props$attributes2.maxRating,
        color = _props$attributes2.color;
    var fallbackSymbol = '⭐';
    var rating_text = sprintf(__('Rating %d out of %d', 'wp-toolbelt'), rating, maxRating);
    return createElement("figure", {
      className: className,
      style: {
        textAlign: align
      }
    }, range(1, rating + 1).map(function (position) {
      return createElement("span", {
        key: position
      }, fallbackSymbol);
    }), createElement("span", {
      "class": "screen-reader-text"
    }, rating_text));
  };

  var range = function range(start, end) {
    var step = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;
    var index = -1;
    var length = Math.max(Math.ceil((end - start) / step), 0);
    var result = Array(length);

    while (length--) {
      result[++index] = start;
      start += step;
    }

    return result;
  };

  registerBlockType('toolbelt/star-rating', {
    title: __('Star Rating', 'wp-toolbelt'),
    icon: StarIcon,
    description: __('Add star ratings.', 'wp-toolbelt'),
    category: 'wp-toolbelt',
    keywords: [_x('star stars rating rate', 'block search term', 'wp-toolbelt'), _x('toolbelt', 'block search term', 'wp-toolbelt')],
    attributes: {
      rating: {
        type: 'number',
        "default": 1
      },
      maxRating: {
        type: 'number',
        "default": 5
      },
      color: {
        type: 'string'
      },
      align: {
        type: 'string',
        "default": 'left'
      }
    },
    edit: edit,
    save: save
  });
})();