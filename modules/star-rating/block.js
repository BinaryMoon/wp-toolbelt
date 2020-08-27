"use strict";

var _element = require("@wordpress/element");

(function () {
  var registerBlockType = wp.blocks.registerBlockType;
  var createElement = wp.element.createElement;
  var InspectorControls = wp.blockEditor.InspectorControls;
  var _wp$components = wp.components,
      RangeControl = _wp$components.RangeControl,
      PanelBody = _wp$components.PanelBody,
      PanelColorSettings = _wp$components.PanelColorSettings;
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x;
  registerBlockType('toolbelt/star-rating', {
    title: __('Star Rating', 'wp-toolbelt'),
    icon: 'star',
    description: __('Add star ratings.', 'wp-toolbelt'),
    category: 'wp-toolbelt',
    keywords: [_x('star rating', 'block search term', 'wp-toolbelt'), _x('toolbelt', 'block search term', 'wp-toolbelt')],
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
    edit: function edit(props) {
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
        if (newRating === rating) {
          // Same number clicked twice.
          // Check if a half rating.
          if (Math.ceil(rating) === rating) {
            // Whole number.
            newRating = newRating - 0.5;
          }
        }

        setAttributes({
          rating: newRating
        });
      };

      return createElement(_element.Fragment, null, createElement(BlockControls, null, createElement(AlignmentToolbar, {
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
        }, createElement("span", null, createElement(Symbol, {
          className: rating >= position - 0.5 ? null : 'is-rating-unfilled',
          color: color
        })), createElement("span", null, createElement(Symbol, {
          className: rating >= position ? null : 'is-rating-unfilled',
          color: color
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
      }))));
    },
    save: function save() {
      return null;
    }
  });
})();