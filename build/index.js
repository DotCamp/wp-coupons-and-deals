/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/StylingControls/BorderControl/index.js":
/*!****************************************************!*\
  !*** ./src/StylingControls/BorderControl/index.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _styling_helpers__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../styling-helpers */ "./src/styling-helpers.js");

/**
 * WordPress Dependencies
 */






function BorderControl({
  borderLabel,
  attrBorderKey,
  borderRadiusLabel,
  attrBorderRadiusKey,
  isShowBorder = true,
  isShowBorderRadius = true,
  showDefaultBorder = false,
  showDefaultBorderRadius = false
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => select("core/block-editor").getBlockAttributes(clientId));
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useDispatch)("core/block-editor");
  const setAttributes = newAttributes => {
    updateBlockAttributes(clientId, newAttributes);
  };
  const {
    defaultColors
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    return {
      defaultColors: select("core/block-editor")?.getSettings()?.__experimentalFeatures?.color?.palette?.default
    };
  });
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, isShowBorder && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showDefaultBorder,
    resetAllFilter: () => setAttributes({
      [attrBorderKey]: {}
    }),
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[attrBorderKey]),
    label: borderLabel,
    onDeselect: () => {
      setAttributes({
        [attrBorderKey]: {}
      });
    }
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalBorderBoxControl, {
    enableAlpha: true,
    size: "__unstable-large",
    colors: defaultColors,
    label: borderLabel,
    onChange: newBorder => {
      setAttributes({
        [attrBorderKey]: newBorder
      });
    },
    value: attributes[attrBorderKey]
  })), isShowBorderRadius && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showDefaultBorderRadius,
    resetAllFilter: () => setAttributes({
      [attrBorderRadiusKey]: {}
    }),
    label: borderRadiusLabel,
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[attrBorderRadiusKey]),
    onDeselect: () => {
      setAttributes({
        [attrBorderRadiusKey]: {}
      });
    }
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.BaseControl.VisualLabel, {
    as: "legend"
  }, borderRadiusLabel), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-border-radius-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalBorderRadiusControl, {
    values: attributes[attrBorderRadiusKey],
    onChange: newBorderRadius => {
      const splitted = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_6__.splitBorderRadius)(newBorderRadius);
      setAttributes({
        [attrBorderRadiusKey]: splitted
      });
    }
  }))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (BorderControl);

/***/ }),

/***/ "./src/StylingControls/ColorSettings/ColorSettings.js":
/*!************************************************************!*\
  !*** ./src/StylingControls/ColorSettings/ColorSettings.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */





/**
 *
 * @param {object} props - Color settings with gradients props
 * @param {string} props.label - Component Label
 * @param {string} props.attrKey - Attribute key for color
 *
 */
function ColorSettings(props) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)("core/block-editor");
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return select("core/block-editor").getBlockAttributes(clientId);
  });
  const setAttributes = newAttributes => updateBlockAttributes(clientId, newAttributes);
  const colorGradientSettings = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalUseMultipleOriginColorsAndGradients)();
  const {
    defaultColors
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return {
      defaultColors: select("core/block-editor")?.getSettings()?.__experimentalFeatures?.color?.palette?.default
    };
  });
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalColorGradientSettingsDropdown, {
    ...colorGradientSettings,
    enableAlpha: true,
    panelId: clientId,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Color Settings", "wp-coupons-and-deals"),
    popoverProps: {
      placement: "left start"
    },
    settings: [{
      clearable: true,
      resetAllFilter: () => setAttributes({
        [props.attrKey]: null
      }),
      colorValue: attributes[props.attrKey],
      colors: defaultColors,
      label: props.label,
      onColorChange: newValue => setAttributes({
        [props.attrKey]: newValue
      })
    }]
  });
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ColorSettings);

/***/ }),

/***/ "./src/StylingControls/ColorSettings/ColorSettingsWithGradient.js":
/*!************************************************************************!*\
  !*** ./src/StylingControls/ColorSettings/ColorSettingsWithGradient.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */





/**
 *
 * @param {object} props - Color settings with gradients props
 * @param {string} props.label - Component Label
 * @param {string} props.attrBackgroundKey - Attribute key for background color
 * @param {string} props.attrGradientKey - Attribute key for gradient background color
 *
 */
function ColorSettingsWithGradient(props) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)("core/block-editor");
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return select("core/block-editor").getBlockAttributes(clientId);
  });
  const setAttributes = newAttributes => updateBlockAttributes(clientId, newAttributes);
  const colorGradientSettings = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalUseMultipleOriginColorsAndGradients)();
  const {
    defaultColors,
    defaultGradients
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return {
      defaultColors: select("core/block-editor")?.getSettings()?.__experimentalFeatures?.color?.palette?.default,
      defaultGradients: select("core/block-editor")?.getSettings()?.__experimentalFeatures?.color?.gradients?.default
    };
  });
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalColorGradientSettingsDropdown, {
    ...colorGradientSettings,
    enableAlpha: true,
    panelId: clientId,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Color Settings", "wp-coupons-and-deals"),
    popoverProps: {
      placement: "left start"
    },
    settings: [{
      clearable: true,
      resetAllFilter: () => setAttributes({
        [props.attrBackgroundKey]: null,
        [props.attrGradientKey]: null
      }),
      colorValue: attributes[props.attrBackgroundKey],
      gradientValue: attributes[props.attrGradientKey],
      colors: defaultColors,
      gradients: defaultGradients,
      label: props.label,
      onColorChange: newValue => setAttributes({
        [props.attrBackgroundKey]: newValue
      }),
      onGradientChange: newValue => setAttributes({
        [props.attrGradientKey]: newValue
      })
    }]
  });
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ColorSettingsWithGradient);

/***/ }),

/***/ "./src/StylingControls/ColorSettings/index.js":
/*!****************************************************!*\
  !*** ./src/StylingControls/ColorSettings/index.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ColorSettings: () => (/* reexport safe */ _ColorSettings__WEBPACK_IMPORTED_MODULE_0__["default"]),
/* harmony export */   ColorSettingsWithGradient: () => (/* reexport safe */ _ColorSettingsWithGradient__WEBPACK_IMPORTED_MODULE_1__["default"])
/* harmony export */ });
/* harmony import */ var _ColorSettings__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ColorSettings */ "./src/StylingControls/ColorSettings/ColorSettings.js");
/* harmony import */ var _ColorSettingsWithGradient__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ColorSettingsWithGradient */ "./src/StylingControls/ColorSettings/ColorSettingsWithGradient.js");



/***/ }),

/***/ "./src/StylingControls/FontSizePicker/index.js":
/*!*****************************************************!*\
  !*** ./src/StylingControls/FontSizePicker/index.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);

/**
 * WordPress Dependencies
 */






function CustomFontSizePicker({
  attrKey,
  label,
  withReset = false,
  withSlider = true,
  showDefaultFontSize = true
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.useBlockEditContext)();
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => select("core/block-editor").getSelectedBlock().attributes);
  const {
    fontSizes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    return {
      fontSizes: select("core/block-editor")?.getSettings()?.fontSizes
    };
  });
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useDispatch)("core/block-editor");
  const setAttributes = newAttributes => {
    updateBlockAttributes(clientId, newAttributes);
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showDefaultFontSize,
    resetAllFilter: () => setAttributes({
      [attrKey]: {}
    }),
    label: label,
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[attrKey]),
    onDeselect: () => {
      setAttributes({
        [attrKey]: ""
      });
    }
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.BaseControl, {
    label: label
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.FontSizePicker, {
    withReset: withReset,
    size: "__unstable-large",
    __nextHasNoMarginBottom: true,
    fontSizes: fontSizes,
    withSlider: withSlider,
    value: attributes[attrKey],
    onChange: newSize => setAttributes({
      [attrKey]: newSize
    })
  }))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CustomFontSizePicker);

/***/ }),

/***/ "./src/StylingControls/SelectControl/index.js":
/*!****************************************************!*\
  !*** ./src/StylingControls/SelectControl/index.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);

/**
 * WordPress dependencies
 */


function UBSelectControl({
  label,
  value,
  onChange = () => {},
  options
}) {
  const displayValue = value !== null && value !== void 0 ? value : "auto";
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SelectControl, {
    label: label,
    value: displayValue,
    options: options,
    onChange: onChange,
    size: "__unstable-large",
    __nextHasNoMarginBottom: true
  });
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (UBSelectControl);

/***/ }),

/***/ "./src/StylingControls/SpacingControl/index.js":
/*!*****************************************************!*\
  !*** ./src/StylingControls/SpacingControl/index.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */



function SpacingControl({
  label,
  attrKey,
  minimumCustomValue = 0,
  sides = ["top", "right", "bottom", "left"]
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockEditContext)();
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => select("core/block-editor").getSelectedBlock().attributes);
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useDispatch)("core/block-editor");
  const setAttributes = newAttributes => {
    updateBlockAttributes(clientId, newAttributes);
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.__experimentalSpacingSizesControl, {
    minimumCustomValue: minimumCustomValue,
    allowReset: true,
    label: label,
    values: attributes[attrKey],
    sides: sides,
    onChange: newValue => {
      setAttributes({
        [attrKey]: newValue
      });
    }
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SpacingControl);

/***/ }),

/***/ "./src/StylingControls/SpacingControlWIthToolsPanel/index.js":
/*!*******************************************************************!*\
  !*** ./src/StylingControls/SpacingControlWIthToolsPanel/index.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);

/**
 * WordPress Dependencies
 */





function SpacingControlWithToolsPanel({
  label,
  attrKey,
  showByDefault = false,
  minimumCustomValue = 0,
  sides = ["top", "right", "bottom", "left"]
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => select("core/block-editor").getBlockAttributes(clientId));
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useDispatch)("core/block-editor");
  const setAttributes = newAttributes => {
    updateBlockAttributes(clientId, newAttributes);
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showByDefault,
    resetAllFilter: () => {
      setAttributes({
        [attrKey]: {}
      });
    },
    className: "tools-panel-item-spacing",
    label: label,
    onDeselect: () => setAttributes({
      [attrKey]: {}
    }),
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[attrKey])
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalSpacingSizesControl, {
    minimumCustomValue: minimumCustomValue,
    allowReset: true,
    label: label,
    values: attributes[attrKey],
    sides: sides,
    onChange: newValue => {
      setAttributes({
        [attrKey]: newValue
      });
    }
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SpacingControlWithToolsPanel);

/***/ }),

/***/ "./src/StylingControls/TabsPanelControl/index.js":
/*!*******************************************************!*\
  !*** ./src/StylingControls/TabsPanelControl/index.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function TabsPanelControl({
  tabs
}) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TabPanel, {
    className: "wpcd-tab-panels",
    tabs: tabs
  }, tab => tab.component);
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (TabsPanelControl);

/***/ }),

/***/ "./src/StylingControls/ToggleGroupControl/index.js":
/*!*********************************************************!*\
  !*** ./src/StylingControls/ToggleGroupControl/index.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */




/**
 *
 * @param {string} label - Group control label
 * @param {Array} options - Group control available options
 * @param {string} attributeKey - Attribute key
 * @param {boolean} [isBlock=false] - Toggle group control prop
 * @param {boolean} [isAdaptiveWidth=false] - Toggle group control prop
 * @param {Function} [null] - call back function when attribute is update
 */
function CustomToggleGroupControl({
  label,
  options,
  attributeKey,
  isBlock = false,
  isAdaptiveWidth = false,
  callBack = () => null
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockEditContext)();
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)("core/block-editor");
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return select("core/block-editor").getBlockAttributes(clientId);
  });
  const setAttributes = newAttributes => {
    callBack(newAttributes);
    updateBlockAttributes(clientId, newAttributes);
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalToggleGroupControl, {
    label: label,
    isBlock: isBlock,
    isAdaptiveWidth: isAdaptiveWidth,
    __nextHasNoMarginBottom: true,
    value: attributes[attributeKey],
    onChange: newValue => {
      setAttributes({
        [attributeKey]: newValue
      });
    }
  }, options.map(({
    value,
    icon = null,
    label
  }) => {
    return icon ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalToggleGroupControlOptionIcon, {
      key: value,
      value: value,
      icon: icon,
      label: label
    }) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalToggleGroupControlOption, {
      key: value,
      value: value,
      label: label
    });
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CustomToggleGroupControl);

/***/ }),

/***/ "./src/StylingControls/index.js":
/*!**************************************!*\
  !*** ./src/StylingControls/index.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   BorderControl: () => (/* reexport safe */ _BorderControl__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   ColorSettings: () => (/* reexport safe */ _ColorSettings__WEBPACK_IMPORTED_MODULE_0__.ColorSettings),
/* harmony export */   ColorSettingsWithGradient: () => (/* reexport safe */ _ColorSettings__WEBPACK_IMPORTED_MODULE_0__.ColorSettingsWithGradient),
/* harmony export */   CustomFontSizePicker: () => (/* reexport safe */ _FontSizePicker__WEBPACK_IMPORTED_MODULE_2__["default"]),
/* harmony export */   CustomToggleGroupControl: () => (/* reexport safe */ _ToggleGroupControl__WEBPACK_IMPORTED_MODULE_3__["default"]),
/* harmony export */   SpacingControl: () => (/* reexport safe */ _SpacingControl__WEBPACK_IMPORTED_MODULE_4__["default"]),
/* harmony export */   SpacingControlWithToolsPanel: () => (/* reexport safe */ _SpacingControlWIthToolsPanel__WEBPACK_IMPORTED_MODULE_5__["default"]),
/* harmony export */   TabsPanelControl: () => (/* reexport safe */ _TabsPanelControl__WEBPACK_IMPORTED_MODULE_6__["default"]),
/* harmony export */   UBSelectControl: () => (/* reexport safe */ _SelectControl__WEBPACK_IMPORTED_MODULE_7__["default"])
/* harmony export */ });
/* harmony import */ var _ColorSettings__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ColorSettings */ "./src/StylingControls/ColorSettings/index.js");
/* harmony import */ var _BorderControl__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BorderControl */ "./src/StylingControls/BorderControl/index.js");
/* harmony import */ var _FontSizePicker__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FontSizePicker */ "./src/StylingControls/FontSizePicker/index.js");
/* harmony import */ var _ToggleGroupControl__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ToggleGroupControl */ "./src/StylingControls/ToggleGroupControl/index.js");
/* harmony import */ var _SpacingControl__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./SpacingControl */ "./src/StylingControls/SpacingControl/index.js");
/* harmony import */ var _SpacingControlWIthToolsPanel__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./SpacingControlWIthToolsPanel */ "./src/StylingControls/SpacingControlWIthToolsPanel/index.js");
/* harmony import */ var _TabsPanelControl__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./TabsPanelControl */ "./src/StylingControls/TabsPanelControl/index.js");
/* harmony import */ var _SelectControl__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./SelectControl */ "./src/StylingControls/SelectControl/index.js");









/***/ }),

/***/ "./src/components/HideCouponSettings.js":
/*!**********************************************!*\
  !*** ./src/components/HideCouponSettings.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);



function HideCouponSettings({
  attributes,
  setAttributes
}) {
  const {
    couponPopupCopyButtonText,
    couponPopupOfferText,
    couponCodeButtonText
  } = attributes;
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("HIDDEN COUPON TEXT", "wp-coupons-and-deals"),
    value: couponCodeButtonText,
    onChange: newValue => setAttributes({
      couponCodeButtonText: newValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Copy Button Text", "wp-coupons-and-deals"),
    value: couponPopupCopyButtonText,
    onChange: newValue => setAttributes({
      couponPopupCopyButtonText: newValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("POPUP OFFER BUTTON TEXT", "wp-coupons-and-deals"),
    value: couponPopupOfferText,
    onChange: newValue => setAttributes({
      couponPopupOfferText: newValue
    })
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HideCouponSettings);

/***/ }),

/***/ "./src/components/TabsPanelControl.js":
/*!********************************************!*\
  !*** ./src/components/TabsPanelControl.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function TabsPanelControl({
  normalStateLabel,
  hoverStateLabel,
  normalState,
  hoverState
}) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TabPanel, {
    className: "wpcd-tab-panels",
    tabs: [{
      name: "normalState",
      title: normalStateLabel
    }, {
      name: "hoverState",
      title: hoverStateLabel
    }]
  }, tab => tab.name === "normalState" ? normalState : hoverState);
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (TabsPanelControl);

/***/ }),

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _templates___WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./templates/ */ "./src/templates/index.js");
/* harmony import */ var _inspector__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./inspector */ "./src/inspector.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");
/* harmony import */ var _styling_helpers__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./styling-helpers */ "./src/styling-helpers.js");

/**
 * Wordpress Dependencies
 */




/**
 * Internal Dependencies
 */





function Edit(props) {
  const {
    attributes,
    setAttributes
  } = props;
  const {
    template,
    hideCoupon,
    couponId,
    couponType,
    padding,
    margin
  } = attributes;
  const wrapperBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getBorderCSS)(attributes.wrapperBorder);
  const paddingObj = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSpacingCss)(attributes.padding);
  const marginObj = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSpacingCss)(attributes.margin);
  const borderStyles = {
    "template-default": "2px dashed #000000",
    "template-one": "1px solid #d1d1d1",
    "template-two": "1px solid #d1d1d1"
  };
  const wrapperStyles = {
    backgroundColor: !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes?.wrapperBackgroundColor) ? attributes.wrapperBackgroundColor : attributes?.wrapperGradientBackground,
    "padding-top": !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(paddingObj?.top) ? paddingObj?.top : "25px",
    "padding-right": !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(paddingObj?.right) ? paddingObj?.right : "25px",
    "padding-bottom": !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(paddingObj?.bottom) ? paddingObj?.bottom : "25px",
    "padding-left": !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(paddingObj?.left) ? paddingObj?.left : "25px",
    "margin-top": marginObj?.top,
    "margin-right": marginObj?.right,
    "margin-bottom": marginObj?.bottom,
    "margin-left": marginObj?.left,
    "border-top-left-radius": attributes.wrapperBorderRadius?.topLeft,
    "border-top-right-radius": attributes.wrapperBorderRadius?.topRight,
    "border-bottom-left-radius": attributes.wrapperBorderRadius?.bottomLeft,
    "border-bottom-right-radius": attributes.wrapperBorderRadius?.bottomRight,
    borderTop: !(0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "top")) ? (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "top") : borderStyles[template],
    borderLeft: !(0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "left")) ? (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "left") : borderStyles[template],
    borderRight: !(0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "right")) ? (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "right") : borderStyles[template],
    borderBottom: !(0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "bottom")) ? (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.getSingleSideBorderValue)(wrapperBorder, "bottom") : borderStyles[template]
  };
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)({
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(`wpcd-coupon-wrapper wpcd-coupon-${template}`, {
      ["wpcd-coupon-hidden"]: hideCoupon && couponType !== "deal",
      ["wpcd-coupon-type-deal"]: couponType === "deal",
      "has-padding": !(0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.isValueEmpty)(padding),
      "has-margin": !(0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.isValueEmpty)(margin)
    }),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_8__.generateStyles)(wrapperStyles)
  });
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useEffect)(() => {
    if ((0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(couponId) && hideCoupon) {
      setAttributes({
        couponId: (0,lodash__WEBPACK_IMPORTED_MODULE_1__.uniqueId)().toString()
      });
    }
  }, [hideCoupon]);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, template === "template-default" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_templates___WEBPACK_IMPORTED_MODULE_4__.DefaultTemplate, {
    ...props
  }), template === "template-one" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_templates___WEBPACK_IMPORTED_MODULE_4__.TemplateOne, {
    ...props
  }), template === "template-two" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_templates___WEBPACK_IMPORTED_MODULE_4__.TemplateTwo, {
    ...props
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_inspector__WEBPACK_IMPORTED_MODULE_5__["default"], {
    ...props
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Edit);

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_2__.name, {
  ..._block_json__WEBPACK_IMPORTED_MODULE_2__,
  edit: _edit__WEBPACK_IMPORTED_MODULE_3__["default"],
  save: () => null,
  icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "24",
    height: "24",
    viewBox: "0 0 24 24",
    fill: "none",
    xmlns: "http://www.w3.org/2000/svg"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("rect", {
    width: "24",
    height: "24",
    fill: "white"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fillRule: "evenodd",
    clipRule: "evenodd",
    d: "M5.47272 4.62474C4.97028 4.39547 4.3771 4.61692 4.14783 5.11936L3.28967 6.99999H10.678L5.47272 4.62474ZM20.7104 17H13.322L18.5273 19.3753C19.0298 19.6045 19.6229 19.3831 19.8522 18.8806L20.7104 17Z",
    fill: "#E11B4C"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fillRule: "evenodd",
    clipRule: "evenodd",
    d: "M2 9C2 8.44771 2.44772 8 3 8H8.5V9C8.5 9.27614 8.72386 9.5 9 9.5C9.27614 9.5 9.5 9.27614 9.5 9V8H21C21.5523 8 22 8.44771 22 9V10C20.8954 10 20 10.8954 20 12C20 13.1046 20.8954 14 22 14V15C22 15.5523 21.5523 16 21 16H9.5V15C9.5 14.7239 9.27614 14.5 9 14.5C8.72386 14.5 8.5 14.7239 8.5 15V16H3C2.44772 16 2 15.5523 2 15V14C3.10457 14 4 13.1046 4 12C4 10.8954 3.10457 10 2 10V9ZM9 10.5C9.27614 10.5 9.5 10.7239 9.5 11V13C9.5 13.2761 9.27614 13.5 9 13.5C8.72386 13.5 8.5 13.2761 8.5 13V11C8.5 10.7239 8.72386 10.5 9 10.5ZM17.3611 10.3458C17.5521 10.1464 17.5453 9.82985 17.3458 9.63886C17.1464 9.44788 16.8298 9.45475 16.6389 9.6542L12.5056 13.9708C12.3146 14.1702 12.3214 14.4867 12.5209 14.6777C12.7203 14.8687 13.0368 14.8618 13.2278 14.6624L17.3611 10.3458ZM15 10C15 10.5523 14.5523 11 14 11C13.4477 11 13 10.5523 13 10C13 9.44771 13.4477 9 14 9C14.5523 9 15 9.44771 15 10ZM16 15C16.5523 15 17 14.5523 17 14C17 13.4477 16.5523 13 16 13C15.4477 13 15 13.4477 15 14C15 14.5523 15.4477 15 16 15Z",
    fill: "#E11B4C"
  })),
  example: {
    viewportWidth: 900,
    attributes: {
      template: "default",
      discount: "100%",
      title: "Sample Coupon Code 2023",
      description: "This is a little description of the coupon code or deal. Just to let users know some additional details.",
      code: "SAMPLECODE",
      expiredDateText: "Expired",
      couponDealLabel: "Coupon",
      navigationLink: "",
      expirationDate: "10/30/2024",
      hideCoupon: false,
      couponCodeButtonText: "Show Code"
    }
  }
});

/***/ }),

/***/ "./src/inspector.js":
/*!**************************!*\
  !*** ./src/inspector.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _StylingControls__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./StylingControls */ "./src/StylingControls/index.js");
/* harmony import */ var _components_HideCouponSettings__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/HideCouponSettings */ "./src/components/HideCouponSettings.js");
/* harmony import */ var _components_TabsPanelControl__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/TabsPanelControl */ "./src/components/TabsPanelControl.js");

/**
 * Wordpress Dependencies
 */




/**
 * Internal Imports
 */



const IS_PRO = WPCD_CFG.IS_PRO === "true";
function Inspector(props) {
  const {
    attributes,
    setAttributes
  } = props;
  const {
    navigationLink,
    expiredDateText,
    expirationDate,
    hideCoupon,
    isDoesNotExpire,
    couponType
  } = attributes;
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useEffect)(() => {
    if (!IS_PRO) {
      setAttributes({
        hideCoupon: false,
        template: "default"
      });
    }
  }, []);
  const normalStateColors = (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "titleColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Title Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "descriptionColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Description Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "codeColor",
    label: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Color", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "discountColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Discount Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "couponDealLabelColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Coupon/Deal Label Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "expirationDateColor",
    label: isDoesNotExpire ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Doesn't Expire Color", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expiration Date Color", "wp-coupons-and-deals")
  }), !isDoesNotExpire && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "expiredDateColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expired Date Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "codeBackgroundColor",
    attrGradientKey: "codeGradientBackground",
    label: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Background", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Background", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "couponDealLabelBackgroundColor",
    attrGradientKey: "couponDealLabelGradientBackground",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Coupon/Deal Background", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "wrapperBackgroundColor",
    attrGradientKey: "wrapperGradientBackground",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Wrapper Background", "wp-coupons-and-deals")
  }), hideCoupon && IS_PRO && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "couponPopupOfferButtonColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Navigation Button Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "couponPopupCopyButtonColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Copy Button Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "couponPopupCodeFieldColor",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Coupon Field Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "couponPopupOfferButtonBgColor",
    attrGradientKey: "couponPopupOfferButtonBgGradient",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Navigation Button Background", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "couponPopupCopyButtonBgColor",
    attrGradientKey: "couponPopupCopyButtonBgGradient",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Copy Button Background", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "couponPopupCodeFieldBgColor",
    attrGradientKey: "couponPopupCodeFieldBgGradient",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Coupon Field Background", "wp-coupons-and-deals")
  })));
  const hoverStateColors = (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettings, {
    attrKey: "codeHoverColor",
    label: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Hover Color", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Hover Color", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.ColorSettingsWithGradient, {
    attrBackgroundKey: "codeHoverBackgroundColor",
    attrGradientKey: "codeHoverGradientBackground",
    label: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Hover Background", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Hover Background", "wp-coupons-and-deals")
  }));
  const couponTypes = [{
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Coupon", "wp-coupons-and-deals"),
    value: "coupon"
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Deal", "wp-coupons-and-deals"),
    value: "deal"
  }];
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("General", "wp-coupons-and-deals")
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Disabled, {
    isDisabled: !IS_PRO
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.UBSelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(`Template${!IS_PRO ? " (Pro)" : ""}`, "wp-coupons-and-deals"),
    options: [{
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Default", "wp-coupons-and-deals"),
      value: "template-default"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template One", "wp-coupons-and-deals"),
      value: "template-one"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Two", "wp-coupons-and-deals"),
      value: "template-two"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Three", "wp-coupons-and-deals"),
      value: "template-three"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Four", "wp-coupons-and-deals"),
      value: "template-four"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Five", "wp-coupons-and-deals"),
      value: "template-five"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Six", "wp-coupons-and-deals"),
      value: "template-six"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Seven", "wp-coupons-and-deals"),
      value: "template-seven"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Eight", "wp-coupons-and-deals"),
      value: "template-eight"
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Template Nine", "wp-coupons-and-deals"),
      value: "template-nine"
    }],
    value: attributes.template,
    onChange: newTemplate => setAttributes({
      template: newTemplate
    })
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("br", null), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomToggleGroupControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Coupon Type", "wp-coupons-and-deals"),
    isBlock: true,
    options: couponTypes,
    attributeKey: "couponType"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Link To Navigate On Copy (Affiliate Link)", "wp-coupons-and-deals"),
    type: "url",
    value: navigationLink,
    onChange: newLink => setAttributes({
      navigationLink: newLink
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Doesn't Expire", "wp-coupons-and-deals"),
    checked: isDoesNotExpire,
    onChange: () => setAttributes({
      isDoesNotExpire: !isDoesNotExpire
    })
  }), !isDoesNotExpire && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expired Date Label", "wp-coupons-and-deals"),
    value: expiredDateText,
    help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("This text will show when coupon date is expired.", "wp-coupons-and-deals"),
    onChange: newLink => setAttributes({
      expiredDateText: newLink
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.BaseControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expiration Date", "wp-coupons-and-deals")
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.DatePicker, {
    currentDate: expirationDate,
    onChange: newDate => {
      setAttributes({
        expirationDate: newDate
      });
    }
  }))), couponType !== "deal" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Disabled, {
    isDisabled: !IS_PRO
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(`Hide Coupon${!IS_PRO ? " (Pro)" : ""}`, "wp-coupons-and-deals"),
    checked: hideCoupon,
    onChange: () => setAttributes({
      hideCoupon: !hideCoupon
    })
  }), hideCoupon && IS_PRO && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_HideCouponSettings__WEBPACK_IMPORTED_MODULE_6__["default"], {
    ...props
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "color"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_TabsPanelControl__WEBPACK_IMPORTED_MODULE_7__["default"], {
    normalStateLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Normal", "wp-coupons-and-deals"),
    hoverStateLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Hover", "wp-coupons-and-deals"),
    normalState: normalStateColors,
    hoverState: hoverStateColors
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "typography"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "discountFontSize",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Discount Font Size", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "couponDealLabelFontSize",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Coupon/Deal Label Font Size", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "titleFontSize",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Title Font Size", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "descriptionFontSize",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Description Font Size", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "codeFontSize",
    label: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Font Size", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Font Size", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "expirationDateFontSize",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expiration Date Font Size", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.CustomFontSizePicker, {
    attrKey: "expiredDateFontSize",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expired Date Font Size", "wp-coupons-and-deals")
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "border"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.BorderControl, {
    showDefaultBorder: true,
    showDefaultBorderRadius: true,
    attrBorderKey: "wrapperBorder",
    attrBorderRadiusKey: "wrapperBorderRadius",
    borderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Wrapper Border", "wp-coupons-and-deals"),
    borderRadiusLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Wrapper Border Radius", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.BorderControl, {
    showDefaultBorder: true,
    showDefaultBorderRadius: true,
    attrBorderKey: "codeBorder",
    attrBorderRadiusKey: "codeBorderRadius",
    borderLabel: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Border", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Border", "wp-coupons-and-deals"),
    borderRadiusLabel: couponType !== "deal" ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Code Border Radius", "wp-coupons-and-deals") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal Border Radius", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.BorderControl, {
    showDefaultBorder: true,
    showDefaultBorderRadius: true,
    isShowBorderRadius: false,
    attrBorderKey: "separatorBorder",
    borderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Separator Border", "wp-coupons-and-deals")
  }), hideCoupon && couponType !== "deal" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.BorderControl, {
    showDefaultBorder: true,
    showDefaultBorderRadius: true,
    isShowBorderRadius: false,
    attrBorderKey: "couponPopupCodeFieldBorder",
    borderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Popup Coupon Field Border", "wp-coupons-and-deals")
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "dimensions"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.SpacingControlWithToolsPanel, {
    showByDefault: true,
    attrKey: "padding",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Padding", "wp-coupons-and-deals")
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_StylingControls__WEBPACK_IMPORTED_MODULE_5__.SpacingControlWithToolsPanel, {
    minimumCustomValue: -Infinity,
    showByDefault: true,
    attrKey: "margin",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Margin", "wp-coupons-and-deals")
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Inspector);

/***/ }),

/***/ "./src/styling-helpers.js":
/*!********************************!*\
  !*** ./src/styling-helpers.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   generateStyles: () => (/* binding */ generateStyles),
/* harmony export */   getBackgroundColorVar: () => (/* binding */ getBackgroundColorVar),
/* harmony export */   getBorderCSS: () => (/* binding */ getBorderCSS),
/* harmony export */   getBorderVariablesCss: () => (/* binding */ getBorderVariablesCss),
/* harmony export */   getSingleSideBorderValue: () => (/* binding */ getSingleSideBorderValue),
/* harmony export */   getSpacingCss: () => (/* binding */ getSpacingCss),
/* harmony export */   getSpacingPresetCssVar: () => (/* binding */ getSpacingPresetCssVar),
/* harmony export */   hasMixedValues: () => (/* binding */ hasMixedValues),
/* harmony export */   isValueEmpty: () => (/* binding */ isValueEmpty),
/* harmony export */   isValueSpacingPreset: () => (/* binding */ isValueSpacingPreset),
/* harmony export */   splitBorderRadius: () => (/* binding */ splitBorderRadius)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);

function hasSplitBorders(border = {}) {
  const sides = ["top", "right", "bottom", "left"];
  for (const side in border) {
    if (sides.includes(side)) {
      return true;
    }
  }
  return false;
}
/**
 * Checks is given value is a spacing preset.
 *
 * @param {string} value Value to check
 *
 * @return {boolean} Return true if value is string in format var:preset|spacing|.
 */
function isValueSpacingPreset(value) {
  if (!value?.includes) {
    return false;
  }
  return value === "0" || value.includes("var:preset|spacing|");
}

/**
 * Converts a spacing preset into a custom value.
 *
 * @param {string} value Value to convert.
 *
 * @return {string | undefined} CSS var string for given spacing preset value.
 */
function getSpacingPresetCssVar(value) {
  if (!value) {
    return;
  }
  const slug = value.match(/var:preset\|spacing\|(.+)/);
  if (!slug) {
    return value;
  }
  return `var(--wp--preset--spacing--${slug[1]})`;
}
function getSpacingCss(object) {
  let css = {};
  for (const [key, value] of Object.entries(object)) {
    if (isValueSpacingPreset(value)) {
      css[key] = getSpacingPresetCssVar(value);
    } else {
      css[key] = value;
    }
  }
  return css;
}

/**
 * Function that's help you to generate splitted or non splitted border CSS.
 * @param {object} object border attributes
 *
 * @return {{ css:object }} A css object
 */
const getBorderCSS = object => {
  let css = {};
  if (!hasSplitBorders(object)) {
    css["top"] = object;
    css["right"] = object;
    css["bottom"] = object;
    css["left"] = object;
    return css;
  }
  return object;
};
/**
 *  Check values are mixed.
 * @param {any} values - value string or object
 * @returns true | false
 */
function hasMixedValues(values = {}) {
  return typeof values === "string";
}
function splitBorderRadius(value) {
  const isValueMixed = hasMixedValues(value);
  const splittedBorderRadius = {
    topLeft: value,
    topRight: value,
    bottomLeft: value,
    bottomRight: value
  };
  return isValueMixed ? splittedBorderRadius : value;
}
function getSingleSideBorderValue(border, side) {
  var _border$side$width, _border$side$style, _border$side$color;
  const hasWidth = !(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(border[side]?.width);
  return `${(_border$side$width = border[side]?.width) !== null && _border$side$width !== void 0 ? _border$side$width : ""} ${hasWidth && (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(border[side]?.style) ? "solid" : (_border$side$style = border[side]?.style) !== null && _border$side$style !== void 0 ? _border$side$style : ""} ${hasWidth && (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(border[side]?.color) ? "" : (_border$side$color = border[side]?.color) !== null && _border$side$color !== void 0 ? _border$side$color : ""}`.trim();
}
function getBorderVariablesCss(border, slug) {
  const borderInFourDimension = getBorderCSS(border);
  const borderSides = ["top", "right", "bottom", "left"];
  let borders = {};
  for (let i = 0; i < borderSides.length; i++) {
    const side = borderSides[i];
    const sideProperty = [`--wpcd-${slug}-border-${side}`];
    const sideValue = getSingleSideBorderValue(borderInFourDimension, side);
    borders[sideProperty] = sideValue;
  }
  return borders;
}
const isValueEmpty = style => {
  return (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isUndefined)(style) || style === false || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(style) === "" || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(style) === "undefined" || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(style) === "undefined undefined undefined" || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(style);
};
function generateStyles(styles) {
  return (0,lodash__WEBPACK_IMPORTED_MODULE_0__.omitBy)(styles, value => isValueEmpty(value));
}
function getBackgroundColorVar(attributes, bgColorAttrKey, gradientAttrKey) {
  if (!(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(attributes[bgColorAttrKey])) {
    return attributes[bgColorAttrKey];
  } else if (!(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(attributes[gradientAttrKey])) {
    return attributes[gradientAttrKey];
  } else {
    return "";
  }
}

/***/ }),

/***/ "./src/templates/default-template/EditDefaultTemplate.js":
/*!***************************************************************!*\
  !*** ./src/templates/default-template/EditDefaultTemplate.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _styling_helpers__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../styling-helpers */ "./src/styling-helpers.js");

/**
 * Wordpress Dependencies
 */




function DefaultTemplate(props) {
  const {
    attributes,
    setAttributes
  } = props;
  const {
    discount,
    title,
    description,
    code,
    couponDealLabel,
    expirationDate,
    doesNotExpireText,
    isDoesNotExpire,
    couponType,
    dealButtonText
  } = attributes;
  const couponCodeBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getBorderCSS)(attributes.codeBorder);
  const separatorBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getBorderCSS)(attributes.separatorBorder);
  let titleStyles = {
    fontSize: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.titleFontSize) ? "21px" : attributes?.titleFontSize,
    color: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.titleColor) ? "#000000" : attributes?.titleColor
  };
  let discountStyles = {
    fontSize: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.discountFontSize) ? "20px" : attributes?.discountFontSize,
    color: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.discountColor) ? "#000000" : attributes?.discountColor
  };
  const dealLabelBgColor = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getBackgroundColorVar)(attributes, "couponDealLabelBackgroundColor", "couponDealLabelGradientBackground");
  let couponDealLabelStyles = {
    fontSize: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.couponDealLabelFontSize) ? "12px" : attributes?.couponDealLabelFontSize,
    color: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.couponDealLabelColor) ? "#ffffff" : attributes?.couponDealLabelColor,
    backgroundColor: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(dealLabelBgColor) ? "#56b151" : dealLabelBgColor
  };
  let descriptionStyles = {
    fontSize: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.descriptionFontSize) ? "16px" : attributes?.descriptionFontSize,
    color: (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.descriptionColor) ? "#000000" : attributes?.descriptionColor
  };
  const codeHoverBgColor = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getBackgroundColorVar)(attributes, "codeHoverBackgroundColor", "codeHoverGradientBackground");
  let codeHoverStyles = {
    "--wpcd-coupon-code-bg-hover-color": codeHoverBgColor,
    "--wpcd-coupon-code-hover-color": attributes?.codeHoverColor
  };
  const borderStyle = attributes.hideCoupon ? "2px solid #56b151" : "2px dashed #ccc";
  let codeStyles = {
    ...codeHoverStyles,
    "--wpcd-coupon-code-button-text": `"${attributes?.couponCodeButtonText}"`,
    fontSize: attributes?.codeFontSize,
    "--wpcd-coupon-code-color": attributes?.codeColor,
    "--wpcd-coupon-code-bg-color": (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getBackgroundColorVar)(attributes, "codeBackgroundColor", "codeGradientBackground"),
    "border-top-left-radius": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes.codeBorderRadius?.topLeft) ? " 2px" : attributes.codeBorderRadius?.topLeft,
    "border-top-right-radius": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes.codeBorderRadius?.topRight) ? " 2px" : attributes.codeBorderRadius?.topRight,
    "border-bottom-left-radius": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes.codeBorderRadius?.bottomLeft) ? " 2px" : attributes.codeBorderRadius?.bottomLeft,
    "border-bottom-right-radius": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes.codeBorderRadius?.bottomRight) ? " 2px" : attributes.codeBorderRadius?.bottomRight,
    borderTop: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "top")) ? couponType === "deal" ? "2px solid #56b151" : borderStyle : (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "top"),
    borderLeft: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "left")) ? couponType === "deal" ? "2px solid #56b151" : borderStyle : (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "left"),
    borderRight: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "right")) ? couponType === "deal" ? "2px solid #56b151" : borderStyle : (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "right"),
    borderBottom: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.isValueEmpty)((0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "bottom")) ? couponType === "deal" ? "2px solid #56b151" : borderStyle : (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.getSingleSideBorderValue)(couponCodeBorder, "bottom")
  };
  let expirationDateStyles = {
    "--wpcd-coupon-expiration-date-font-size": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.expirationDateFontSize) ? "14px" : attributes?.expirationDateFontSize,
    "--wpcd-coupon-expired-date-font-size": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.expiredDateFontSize) ? "14px" : attributes?.expiredDateFontSize,
    "--wpcd-coupon-expiration-date-color": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.expirationDateColor) ? "green" : attributes?.expirationDateColor,
    "--wpcd-coupon-expired-date-color": (0,lodash__WEBPACK_IMPORTED_MODULE_3__.isEmpty)(attributes?.expiredDateColor) ? "red" : attributes?.expiredDateColor
  };
  const date = new Date(expirationDate);
  const expirationDateInLocalString = date.toLocaleDateString();
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-inner__wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-discount-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-discount-inner__wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    className: "wpcd-coupon-discount",
    value: discount,
    tagName: "div",
    onChange: newValue => setAttributes({
      discount: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("100%", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(discountStyles)
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    tagName: "div",
    className: "wpcd-coupon-name",
    value: couponDealLabel,
    onChange: newValue => setAttributes({
      couponDealLabel: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Coupon", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(couponDealLabelStyles)
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-details-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-header"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-title-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    className: "wpcd-coupon-title",
    value: title,
    tagName: "h3",
    onChange: newValue => setAttributes({
      title: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Title here", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(titleStyles)
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-code"
  }, couponType !== "deal" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    rel: "nofollow noopener",
    target: "_blank",
    "data-clipboard-text": code,
    className: "wpcd-coupon-button",
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Click To Copy Coupon", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(codeStyles)
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "wpcd-coupon-icon"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "24",
    height: "24",
    viewBox: "0 0 24 24"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    fill: "currentColor"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    "fill-rule": "evenodd",
    d: "M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z",
    "clip-rule": "evenodd"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z"
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    value: code,
    tagName: "span",
    onChange: newValue => setAttributes({
      code: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("SAMPLECODE", "wp-coupons-and-deals")
  })), couponType === "deal" && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    rel: "nofollow noopener",
    target: "_blank",
    className: "wpcd-coupon-button",
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(codeStyles),
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Click To Claim This Deal", "wp-coupons-and-deals")
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    value: dealButtonText,
    tagName: "span",
    onChange: newValue => setAttributes({
      dealButtonText: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal", "wp-coupons-and-deals")
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-content"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-description"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    value: description,
    tagName: "p",
    onChange: newValue => setAttributes({
      description: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Description here", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(descriptionStyles)
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `wpcd-coupon-expiration-date${isDoesNotExpire ? " wpcd-coupon-does-not-expire" : ""}`,
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_4__.generateStyles)(expirationDateStyles)
  }, !isDoesNotExpire && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Expire On ", "wp-coupons-and-deals")), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, expirationDateInLocalString)), isDoesNotExpire && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    value: doesNotExpireText,
    tagName: "span",
    onChange: newValue => setAttributes({
      doesNotExpireText: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Doesn't Expire Text Here", "wp-coupons-and-deals")
  })))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (DefaultTemplate);

/***/ }),

/***/ "./src/templates/index.js":
/*!********************************!*\
  !*** ./src/templates/index.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   DefaultTemplate: () => (/* reexport safe */ _default_template_EditDefaultTemplate__WEBPACK_IMPORTED_MODULE_0__["default"]),
/* harmony export */   TemplateOne: () => (/* reexport safe */ _template_one_EditTemplateOne__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   TemplateTwo: () => (/* reexport safe */ _template_two_EditTemplateTwo__WEBPACK_IMPORTED_MODULE_2__["default"])
/* harmony export */ });
/* harmony import */ var _default_template_EditDefaultTemplate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./default-template/EditDefaultTemplate */ "./src/templates/default-template/EditDefaultTemplate.js");
/* harmony import */ var _template_one_EditTemplateOne__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./template-one/EditTemplateOne */ "./src/templates/template-one/EditTemplateOne.js");
/* harmony import */ var _template_two_EditTemplateTwo__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./template-two/EditTemplateTwo */ "./src/templates/template-two/EditTemplateTwo.js");




/***/ }),

/***/ "./src/templates/template-one/EditTemplateOne.js":
/*!*******************************************************!*\
  !*** ./src/templates/template-one/EditTemplateOne.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _styling_helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../styling-helpers */ "./src/styling-helpers.js");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);




function generateTemplateOneHtml(props) {
  const {
    attributes,
    setAttributes
  } = props;
  const couponType = attributes.couponType || "default";
  const discount = attributes.discount || "";
  const title = attributes.title || "";
  const description = attributes.description || "";
  const code = attributes.code || "";
  const couponDealLabel = attributes.couponDealLabel || "";
  const expirationDate = attributes.expirationDate || "";
  const doesNotExpireText = attributes.doesNotExpireText || "";
  const isDoesNotExpire = attributes.isDoesNotExpire || false;
  const dealButtonText = attributes.dealButtonText || "";
  const couponCodeBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBorderCSS)(attributes.codeBorder);
  const separatorBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBorderCSS)(attributes.separatorBorder);
  const titleStyles = {
    fontSize: attributes.titleFontSize || "21px",
    color: attributes.titleColor || "#000000"
  };
  const discountStyles = {
    fontSize: attributes.discountFontSize || "20px",
    color: attributes.discountColor || "#000000"
  };
  const dealLabelBgColor = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBackgroundColorVar)(attributes, "couponDealLabelBackgroundColor", "couponDealLabelGradientBackground");
  const descriptionStyles = {
    fontSize: attributes.descriptionFontSize || "16px",
    color: attributes.descriptionColor || "#000000"
  };
  const codeHoverBgColor = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBackgroundColorVar)(attributes, "codeHoverBackgroundColor", "codeHoverGradientBackground");
  const codeHoverStyles = {
    "--wpcd-coupon-code-bg-hover-color": codeHoverBgColor,
    "--wpcd-coupon-code-hover-color": attributes.codeHoverColor || ""
  };
  const borderStyle = attributes.hideCoupon ? "2px solid #56b151" : "2px dashed #ccc";
  const codeStyles = {
    ...codeHoverStyles,
    "--wpcd-coupon-code-button-text": attributes.couponCodeButtonText ? attributes.couponCodeButtonText : "",
    fontSize: attributes.codeFontSize || "",
    "--wpcd-coupon-code-color": attributes.codeColor || "",
    "--wpcd-coupon-code-bg-color": (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBackgroundColorVar)(attributes, "codeBackgroundColor", "codeGradientBackground"),
    borderTopLeftRadius: attributes.codeBorderRadius?.topLeft || "2px",
    borderTopRightRadius: attributes.codeBorderRadius?.topRight || "2px",
    borderBottomLeftRadius: attributes.codeBorderRadius?.bottomLeft || "2px",
    borderBottomRightRadius: attributes.codeBorderRadius?.bottomRight || "2px",
    borderTop: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "top") || (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderLeft: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "left") || (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderRight: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "right") || (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderBottom: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "bottom") || (couponType === "deal" ? "2px solid #56b151" : borderStyle)
  };
  const expirationDateStyles = {
    "--wpcd-coupon-expiration-date-font-size": attributes.expirationDateFontSize || "14px",
    "--wpcd-coupon-expired-date-font-size": attributes.expiredDateFontSize || "14px",
    "--wpcd-coupon-expiration-date-color": attributes.expirationDateColor || "green",
    "--wpcd-coupon-expired-date-color": attributes.expiredDateColor || "red"
  };
  const couponDefaultImage = "http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png";
  const navigationAttrs = {};
  if (!attributes.hideCoupon) {
    navigationAttrs.rel = "nofollow noopener";
    navigationAttrs.target = "_blank";
  }
  const date = new Date(expirationDate);
  const expirationDateInLocalString = date.toLocaleDateString();
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-inner__wrapper wpcd-coupon-columns"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-details-wrapper wpcd-coupon-column-1"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-header"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("figure", {
    className: "wpcd-coupon-one-image"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: couponDefaultImage,
    alt: "Coupon"
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-content-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-title-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    className: "wpcd-coupon-title",
    value: title,
    tagName: "h3",
    onChange: newValue => setAttributes({
      title: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Title here", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(titleStyles)
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    className: "wpcd-coupon-description",
    value: description,
    tagName: "p",
    onChange: newValue => setAttributes({
      description: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Description here", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(descriptionStyles)
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-column-2"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-content"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-discount-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-discount-inner__wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    className: "wpcd-coupon-discount",
    value: discount,
    tagName: "div",
    onChange: newValue => setAttributes({
      discount: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("100%", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(discountStyles)
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-code"
  }, couponType !== "deal" ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(codeStyles),
    ...navigationAttrs,
    className: `wpcd-coupon-button${attributes.hideCoupon ? " wpcd-popup-button" : ""}`,
    title: "Click To Copy Coupon"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "wpcd-coupon-icon"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "24",
    height: "24",
    viewBox: "0 0 24 24"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    fill: "currentColor"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fillRule: "evenodd",
    d: "M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z",
    clipRule: "evenodd"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z"
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    value: code,
    tagName: "span",
    onChange: newValue => setAttributes({
      code: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("SAMPLECODE", "wp-coupons-and-deals")
  })) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    rel: "nofollow noopener",
    target: "_blank",
    className: "wpcd-coupon-button",
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(codeStyles),
    title: "Click To Claim This Deal"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    value: dealButtonText,
    tagName: "span",
    onChange: newValue => setAttributes({
      dealButtonText: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal", "wp-coupons-and-deals")
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `wpcd-coupon-expiration-date${isDoesNotExpire ? " wpcd-coupon-does-not-expire" : ""}`,
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(expirationDateStyles)
  }, !isDoesNotExpire ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, "Expire On "), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, expirationDateInLocalString)) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, doesNotExpireText)))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (generateTemplateOneHtml);

/***/ }),

/***/ "./src/templates/template-two/EditTemplateTwo.js":
/*!*******************************************************!*\
  !*** ./src/templates/template-two/EditTemplateTwo.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _styling_helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../styling-helpers */ "./src/styling-helpers.js");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__);





function generateTemplateOneHtml(props) {
  const [countdown, setCountdown] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useState)("");
  const {
    attributes,
    setAttributes
  } = props;
  const couponType = attributes.couponType || "default";
  const discount = attributes.discount || "";
  const title = attributes.title || "";
  const description = attributes.description || "";
  const code = attributes.code || "";
  const expirationDate = attributes.expirationDate || "";
  const doesNotExpireText = attributes.doesNotExpireText || "";
  const isDoesNotExpire = attributes.isDoesNotExpire || false;
  const dealButtonText = attributes.dealButtonText || "";
  const couponCodeBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBorderCSS)(attributes.codeBorder);
  const separatorBorder = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBorderCSS)(attributes.separatorBorder);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useEffect)(() => {
    const updateCountdown = () => {
      const now = new Date().getTime();
      const distance = new Date(expirationDate).getTime() - now;
      if (distance < 0) {
        setCountdown(expiredDateText);
        return;
      }
      const weeks = Math.floor(distance / (1000 * 60 * 60 * 24 * 7));
      const days = Math.floor(distance % (1000 * 60 * 60 * 24 * 7) / (1000 * 60 * 60 * 24));
      const hours = Math.floor(distance % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
      const minutes = Math.floor(distance % (1000 * 60 * 60) / (1000 * 60));
      const seconds = Math.floor(distance % (1000 * 60) / 1000);
      setCountdown(`${weeks} weeks ${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`);
    };
    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);
    return () => clearInterval(interval);
  }, [expirationDate]);
  const titleStyles = {
    fontSize: attributes.titleFontSize || "21px",
    color: attributes.titleColor || "#000000"
  };
  const discountStyles = {
    fontSize: attributes.discountFontSize || "20px",
    color: attributes.discountColor || "#000000"
  };
  const dealLabelBgColor = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBackgroundColorVar)(attributes, "couponDealLabelBackgroundColor", "couponDealLabelGradientBackground");
  const descriptionStyles = {
    fontSize: attributes.descriptionFontSize || "16px",
    color: attributes.descriptionColor || "#000000"
  };
  const codeHoverBgColor = (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBackgroundColorVar)(attributes, "codeHoverBackgroundColor", "codeHoverGradientBackground");
  const codeHoverStyles = {
    "--wpcd-coupon-code-bg-hover-color": codeHoverBgColor,
    "--wpcd-coupon-code-hover-color": attributes.codeHoverColor || ""
  };
  const borderStyle = attributes.hideCoupon ? "2px solid #56b151" : "2px dashed #ccc";
  const codeStyles = {
    ...codeHoverStyles,
    "--wpcd-coupon-code-button-text": attributes.couponCodeButtonText ? attributes.couponCodeButtonText : "",
    fontSize: attributes.codeFontSize || "",
    "--wpcd-coupon-code-color": attributes.codeColor || "",
    "--wpcd-coupon-code-bg-color": (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getBackgroundColorVar)(attributes, "codeBackgroundColor", "codeGradientBackground"),
    borderTopLeftRadius: attributes.codeBorderRadius?.topLeft || "2px",
    borderTopRightRadius: attributes.codeBorderRadius?.topRight || "2px",
    borderBottomLeftRadius: attributes.codeBorderRadius?.bottomLeft || "2px",
    borderBottomRightRadius: attributes.codeBorderRadius?.bottomRight || "2px",
    borderTop: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "top") || (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderLeft: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "left") || (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderRight: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "right") || (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderBottom: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.getSingleSideBorderValue)(couponCodeBorder, "bottom") || (couponType === "deal" ? "2px solid #56b151" : borderStyle)
  };
  const expirationDateStyles = {
    "--wpcd-coupon-expiration-date-font-size": attributes.expirationDateFontSize || "14px",
    "--wpcd-coupon-expired-date-font-size": attributes.expiredDateFontSize || "14px",
    "--wpcd-coupon-expiration-date-color": attributes.expirationDateColor || "green",
    "--wpcd-coupon-expired-date-color": attributes.expiredDateColor || "red"
  };
  const couponDefaultImage = "http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png";
  const navigationAttrs = {};
  if (!attributes.hideCoupon) {
    navigationAttrs.rel = "nofollow noopener";
    navigationAttrs.target = "_blank";
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-inner__wrapper wpcd-coupon-columns"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-details-wrapper wpcd-coupon-column-1"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-header"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-image-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("figure", {
    className: "wpcd-coupon-one-image"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: couponDefaultImage,
    alt: "Coupon"
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-discount-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-discount-inner__wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    className: "wpcd-coupon-discount",
    value: discount,
    tagName: "div",
    onChange: newValue => setAttributes({
      discount: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("100%", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(discountStyles)
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-content-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-title-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    className: "wpcd-coupon-title",
    value: title,
    tagName: "h3",
    onChange: newValue => setAttributes({
      title: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Title here", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(titleStyles)
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-content"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `wpcd-coupon-expiration-date${isDoesNotExpire ? " wpcd-coupon-does-not-expire" : ""}`,
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(expirationDateStyles)
  }, !isDoesNotExpire ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, "Expire On: "), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, countdown)) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, doesNotExpireText)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wpcd-coupon-code"
  }, couponType !== "deal" ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(codeStyles),
    ...navigationAttrs,
    className: `wpcd-coupon-button${attributes.hideCoupon ? " wpcd-popup-button" : ""}`,
    title: "Click To Copy Coupon"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "wpcd-coupon-icon"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "24",
    height: "24",
    viewBox: "0 0 24 24"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    fill: "currentColor"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fillRule: "evenodd",
    d: "M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z",
    clipRule: "evenodd"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z"
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    value: code,
    tagName: "span",
    onChange: newValue => setAttributes({
      code: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("SAMPLECODE", "wp-coupons-and-deals")
  })) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    rel: "nofollow noopener",
    target: "_blank",
    className: "wpcd-coupon-button",
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(codeStyles),
    title: "Click To Claim This Deal"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    value: dealButtonText,
    tagName: "span",
    onChange: newValue => setAttributes({
      dealButtonText: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Get Deal", "wp-coupons-and-deals")
  })))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    className: "wpcd-coupon-description",
    value: description,
    tagName: "p",
    onChange: newValue => setAttributes({
      description: newValue
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Description here", "wp-coupons-and-deals"),
    style: (0,_styling_helpers__WEBPACK_IMPORTED_MODULE_2__.generateStyles)(descriptionStyles)
  })))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (generateTemplateOneHtml);

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/***/ ((module) => {

"use strict";
module.exports = window["lodash"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = '';

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (arg) {
				classes = appendClass(classes, parseValue(arg));
			}
		}

		return classes;
	}

	function parseValue (arg) {
		if (typeof arg === 'string' || typeof arg === 'number') {
			return arg;
		}

		if (typeof arg !== 'object') {
			return '';
		}

		if (Array.isArray(arg)) {
			return classNames.apply(null, arg);
		}

		if (arg.toString !== Object.prototype.toString && !arg.toString.toString().includes('[native code]')) {
			return arg.toString();
		}

		var classes = '';

		for (var key in arg) {
			if (hasOwn.call(arg, key) && arg[key]) {
				classes = appendClass(classes, key);
			}
		}

		return classes;
	}

	function appendClass (value, newClass) {
		if (!newClass) {
			return value;
		}
	
		if (value) {
			return value + ' ' + newClass;
		}
	
		return value + newClass;
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ ((module) => {

"use strict";
module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"wpcd/coupon","title":"Coupon","category":"wpcd","description":"Add coupon boxes to boost your affiliate sales.","keywords":["coupon","deal"],"attributes":{"template":{"type":"string","default":"template-default"},"padding":{"type":"object","default":{}},"margin":{"type":"object","default":{}},"discount":{"type":"string","default":"100%"},"title":{"type":"string","default":"Sample Coupon Code 2023"},"description":{"type":"string","default":"This is a little description of the coupon code or deal. Just to let users know some additional details."},"code":{"type":"string","default":"SAMPLECODE"},"expiredDateText":{"type":"string","default":"Expired"},"couponDealLabel":{"type":"string","default":"Coupon"},"navigationLink":{"type":"string","default":""},"expirationDate":{"type":"string","default":"10/30/2024"},"titleColor":{"type":"string","default":null},"descriptionColor":{"type":"string","default":null},"codeColor":{"type":"string","default":null},"discountColor":{"type":"string","default":null},"couponDealLabelColor":{"type":"string","default":null},"codeHoverColor":{"type":"string","default":null},"expirationDateColor":{"type":"string","default":null},"expiredDateColor":{"type":"string","default":null},"couponDealLabelBackgroundColor":{"type":"string","default":null},"couponDealLabelGradientBackground":{"type":"string","default":null},"codeBackgroundColor":{"type":"string","default":null},"codeGradientBackground":{"type":"string","default":null},"codeHoverBackgroundColor":{"type":"string","default":null},"codeHoverGradientBackground":{"type":"string","default":null},"wrapperBackgroundColor":{"type":"string","default":null},"wrapperGradientBackground":{"type":"string","default":null},"wrapperBorder":{"type":"object","default":{}},"wrapperBorderRadius":{"type":"object","default":{}},"codeBorder":{"type":"object","default":{}},"codeBorderRadius":{"type":"object","default":{}},"separatorBorder":{"type":"object","default":{}},"discountFontSize":{"type":"string","default":""},"couponDealLabelFontSize":{"type":"string","default":""},"titleFontSize":{"type":"string","default":""},"descriptionFontSize":{"type":"string","default":""},"codeFontSize":{"type":"string","default":""},"expirationDateFontSize":{"type":"string","default":""},"expiredDateFontSize":{"type":"string","default":""},"hideCoupon":{"type":"boolean","default":false},"couponId":{"type":"string","default":""},"couponPopupOfferButtonColor":{"type":"string","default":null},"couponPopupCopyButtonColor":{"type":"string","default":null},"couponPopupCodeFieldColor":{"type":"string","default":null},"couponPopupOfferButtonBgColor":{"type":"string","default":null},"couponPopupCopyButtonBgColor":{"type":"string","default":null},"couponPopupCodeFieldBgColor":{"type":"string","default":null},"couponPopupOfferButtonBgGradient":{"type":"string","default":null},"couponPopupCopyButtonBgGradient":{"type":"string","default":null},"couponPopupCodeFieldBgGradient":{"type":"string","default":null},"couponPopupCodeFieldBorder":{"type":"object","default":{}},"couponCodeButtonText":{"type":"string","default":"Show Code"},"couponPopupCopyButtonText":{"type":"string","default":"Copy"},"couponPopupOfferText":{"type":"string","default":"Go To Offer"},"doesNotExpireText":{"type":"string","default":"Doesn\'t Expire"},"couponType":{"type":"string","default":"coupon"},"dealButtonText":{"type":"string","default":"Get Deal"},"isDoesNotExpire":{"type":"boolean","default":false}},"supports":{"align":true},"editorScript":"wpcd-block-script","editorStyle":"wpcd-editor-style","viewScript":"wpcd-frontend-script","style":["wpcd-frontend-style"]}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkwp_coupons_and_deals"] = globalThis["webpackChunkwp_coupons_and_deals"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map