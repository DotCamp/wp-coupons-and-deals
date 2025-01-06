/**
 * WordPress Dependencies
 */
import { isUndefined, trim, isEmpty, omitBy } from "lodash";
import {
  getBorderVariablesCss,
  getSpacingCss,
} from "../../utils/styling-helpers";
/**
 *
 * @param {Array} attributes
 *
 * @return {object} - Block styles
 */

export function getStyles(attributes) {
  const couponCodeBorderVariables = getBorderVariablesCss(
    attributes.codeBorder,
    "coupon-code"
  );
  const paddingObj = getSpacingCss(attributes.padding);
  const marginObj = getSpacingCss(attributes.margin);
  const wrapperBorderVariables = getBorderVariablesCss(
    attributes.wrapperBorder,
    "coupon-wrapper"
  );
  const separatorBorderVariables = getBorderVariablesCss(
    attributes.separatorBorder,
    "coupon-separator"
  );
  const couponPopupFiledBorderVariables = getBorderVariablesCss(
    attributes.couponPopupCodeFieldBorder,
    "coupon-popup-field"
  );
  const couponCodeBorderRadius = {
    "--ub-coupon-code-top-left-radius": attributes.codeBorderRadius?.topLeft,
    "--ub-coupon-code-top-right-radius": attributes.codeBorderRadius?.topRight,
    "--ub-coupon-code-bottom-left-radius":
      attributes.codeBorderRadius?.bottomLeft,
    "--ub-coupon-code-bottom-right-radius":
      attributes.codeBorderRadius?.bottomRight,
  };
  const wrapperBorderRadius = {
    "--ub-coupon-wrapper-top-left-radius":
      attributes.wrapperBorderRadius?.topLeft,
    "--ub-coupon-wrapper-top-right-radius":
      attributes.wrapperBorderRadius?.topRight,
    "--ub-coupon-wrapper-bottom-left-radius":
      attributes.wrapperBorderRadius?.bottomLeft,
    "--ub-coupon-wrapper-bottom-right-radius":
      attributes.wrapperBorderRadius?.bottomRight,
  };
  let styles = {
    "--ub-coupon-title-font-size": attributes?.titleFontSize,
    "--ub-coupon-discount-font-size": attributes?.discountFontSize,
    "--ub-coupon-deal-label-font-size": attributes?.couponDealLabelFontSize,
    "--ub-coupon-description-font-size": attributes?.descriptionFontSize,
    "--ub-coupon-code-font-size": attributes?.codeFontSize,
    "--ub-coupon-expiration-date-font-size": attributes?.expirationDateFontSize,
    "--ub-coupon-expired-date-font-size": attributes?.expiredDateFontSize,
    "--ub-coupon-code-bg-color": !isEmpty(attributes?.codeBackgroundColor)
      ? attributes.codeBackgroundColor
      : attributes?.codeGradientBackground,
    "--ub-coupon-popup-offer-bg-color": !isEmpty(
      attributes?.couponPopupOfferButtonBgColor
    )
      ? attributes.couponPopupOfferButtonBgColor
      : attributes?.couponPopupOfferButtonBgGradient,
    "--ub-coupon-popup-copy-bg-color": !isEmpty(
      attributes?.couponPopupCopyButtonBgColor
    )
      ? attributes.couponPopupCopyButtonBgColor
      : attributes?.couponPopupCopyButtonBgGradient,
    "--ub-coupon-popup-field-bg-color": !isEmpty(
      attributes?.couponPopupCodeFieldBgColor
    )
      ? attributes.couponPopupCodeFieldBgColor
      : attributes?.couponPopupCodeFieldBgGradient,

    "--ub-coupon-code-bg-hover-color": !isEmpty(
      attributes?.codeHoverBackgroundColor
    )
      ? attributes.codeHoverBackgroundColor
      : attributes?.codeHoverGradientBackground,
    "--ub-coupon-wrapper-bg-color": !isEmpty(attributes?.wrapperBackgroundColor)
      ? attributes.wrapperBackgroundColor
      : attributes?.wrapperGradientBackground,
    "--ub-coupon-deal-label-bg-color": !isEmpty(
      attributes?.couponDealLabelBackgroundColor
    )
      ? attributes.couponDealLabelBackgroundColor
      : attributes?.couponDealLabelGradientBackground,
    "--ub-coupon-popup-offer-color": attributes?.couponPopupOfferButtonColor,
    "--ub-coupon-popup-copy-color": attributes?.couponPopupCopyButtonColor,
    "--ub-coupon-popup-field-color": attributes?.couponPopupCodeFieldColor,
    "--ub-coupon-title-color": attributes?.titleColor,
    "--ub-coupon-description-color": attributes?.descriptionColor,
    "--ub-coupon-code-color": attributes?.codeColor,
    "--ub-coupon-code-hover-color": attributes?.codeHoverColor,
    "--ub-coupon-discount-color": attributes?.discountColor,
    "--ub-coupon-deal-label-color": attributes?.couponDealLabelColor,
    "--ub-coupon-expiration-date-color": attributes?.expirationDateColor,
    "--ub-coupon-expired-date-color": attributes?.expiredDateColor,
    "--ub-coupon-code-button-text": `"${attributes?.couponCodeButtonText}"`,
    "--ub-coupon-wrapper-padding-top": paddingObj?.top,
    "--ub-coupon-wrapper-padding-right": paddingObj?.right,
    "--ub-coupon-wrapper-padding-bottom": paddingObj?.bottom,
    "--ub-coupon-wrapper-padding-left": paddingObj?.left,
    "--ub-coupon-wrapper-margin-top": marginObj?.top,
    "--ub-coupon-wrapper-margin-right": marginObj?.right,
    "--ub-coupon-wrapper-margin-bottom": marginObj?.bottom,
    "--ub-coupon-wrapper-margin-left": marginObj?.left,
    ...couponCodeBorderRadius,
    ...couponCodeBorderVariables,
    ...wrapperBorderVariables,
    ...separatorBorderVariables,
    ...wrapperBorderRadius,
    ...couponPopupFiledBorderVariables,
  };

  return omitBy(styles, (value) => {
    return (
      isUndefined(value) ||
      value === false ||
      trim(value) === "" ||
      trim(value) === "undefined undefined undefined" ||
      isEmpty(value)
    );
  });
}
