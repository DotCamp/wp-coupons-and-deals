/**
 * Wordpress Dependencies
 */
import { __ } from "@wordpress/i18n";
import { RichText } from "@wordpress/block-editor";
import { isEmpty } from "lodash";
import {
  generateStyles,
  getBackgroundColorVar,
  getBorderCSS,
  getSingleSideBorderValue,
  isValueEmpty,
} from "../../styling-helpers";

function DefaultTemplate(props) {
  const { attributes, setAttributes } = props;
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
    dealButtonText,
  } = attributes;

  const couponCodeBorder = getBorderCSS(attributes.codeBorder);
  const separator = isEmpty(attributes.separatorColor)
    ? "none"
    : `1px dashed ${attributes.separatorColor}`;
  const separatorStyles = {
    borderBottom: `1px dashed ${separator}`,
  };

  let titleStyles = {
    fontSize: isEmpty(attributes?.titleFontSize)
      ? "21px"
      : attributes?.titleFontSize,
    color: isEmpty(attributes?.titleColor) ? "#000000" : attributes?.titleColor,
  };
  const discountBgColor = getBackgroundColorVar(
    attributes,
    "discountBgColor",
    "discountBgGradientColor"
  );
  let discountStyles = {
    fontSize: isEmpty(attributes?.discountFontSize)
      ? "20px"
      : attributes?.discountFontSize,
    color: isEmpty(attributes?.discountColor)
      ? "#000000"
      : attributes?.discountColor,
    backgroundColor: discountBgColor,
  };

  const dealLabelBgColor = getBackgroundColorVar(
    attributes,
    "couponDealLabelBackgroundColor",
    "couponDealLabelGradientBackground"
  );
  let couponDealLabelStyles = {
    fontSize: isEmpty(attributes?.couponDealLabelFontSize)
      ? "12px"
      : attributes?.couponDealLabelFontSize,
    color: isEmpty(attributes?.couponDealLabelColor)
      ? "#ffffff"
      : attributes?.couponDealLabelColor,
    backgroundColor: isEmpty(dealLabelBgColor) ? "#56b151" : dealLabelBgColor,
  };

  let descriptionStyles = {
    fontSize: isEmpty(attributes?.descriptionFontSize)
      ? "16px"
      : attributes?.descriptionFontSize,
    color: isEmpty(attributes?.descriptionColor)
      ? "#000000"
      : attributes?.descriptionColor,
  };
  const codeHoverBgColor = getBackgroundColorVar(
    attributes,
    "codeHoverBackgroundColor",
    "codeHoverGradientBackground"
  );
  let codeHoverStyles = {
    "--wpcd-coupon-code-bg-hover-color": codeHoverBgColor,
    "--wpcd-coupon-code-hover-color": attributes?.codeHoverColor,
  };
  const borderStyle = attributes.hideCoupon
    ? "2px solid #56b151"
    : "2px dashed #ccc";
  let codeStyles = {
    ...codeHoverStyles,
    "--wpcd-coupon-code-button-text": `"${attributes?.couponCodeButtonText}"`,
    fontSize: attributes?.codeFontSize,
    "--wpcd-coupon-code-color": attributes?.codeColor,
    "--wpcd-coupon-code-bg-color": getBackgroundColorVar(
      attributes,
      "codeBackgroundColor",
      "codeGradientBackground"
    ),
    "border-top-left-radius": isEmpty(attributes.codeBorderRadius?.topLeft)
      ? " 2px"
      : attributes.codeBorderRadius?.topLeft,
    "border-top-right-radius": isEmpty(attributes.codeBorderRadius?.topRight)
      ? " 2px"
      : attributes.codeBorderRadius?.topRight,
    "border-bottom-left-radius": isEmpty(
      attributes.codeBorderRadius?.bottomLeft
    )
      ? " 2px"
      : attributes.codeBorderRadius?.bottomLeft,
    "border-bottom-right-radius": isEmpty(
      attributes.codeBorderRadius?.bottomRight
    )
      ? " 2px"
      : attributes.codeBorderRadius?.bottomRight,
    borderTop: isValueEmpty(getSingleSideBorderValue(couponCodeBorder, "top"))
      ? couponType === "deal"
        ? "2px solid #56b151"
        : borderStyle
      : getSingleSideBorderValue(couponCodeBorder, "top"),
    borderLeft: isValueEmpty(getSingleSideBorderValue(couponCodeBorder, "left"))
      ? couponType === "deal"
        ? "2px solid #56b151"
        : borderStyle
      : getSingleSideBorderValue(couponCodeBorder, "left"),
    borderRight: isValueEmpty(
      getSingleSideBorderValue(couponCodeBorder, "right")
    )
      ? couponType === "deal"
        ? "2px solid #56b151"
        : borderStyle
      : getSingleSideBorderValue(couponCodeBorder, "right"),
    borderBottom: isValueEmpty(
      getSingleSideBorderValue(couponCodeBorder, "bottom")
    )
      ? couponType === "deal"
        ? "2px solid #56b151"
        : borderStyle
      : getSingleSideBorderValue(couponCodeBorder, "bottom"),
  };
  const dealBgColor = getBackgroundColorVar(
    attributes,
    "dealButtonBackgroundColor",
    "dealButtonGradientBackground"
  );
  let dealButtonStyles = {
    ...codeHoverStyles,
    marginTop: "20px",
    "--wpcd-coupon-code-button-text": `"${attributes?.dealButtonText}"`,
    fontSize: attributes?.dealButtonFontSize,
    "--wpcd-coupon-code-color": attributes?.dealButtonColor ?? "#ffffff",
    "--wpcd-coupon-code-bg-color": isEmpty(dealBgColor)
      ? "#56b151"
      : dealBgColor,
    "border-top-left-radius": isEmpty(
      attributes.dealButtonBorderRadius?.topLeft
    )
      ? " 2px"
      : attributes.dealButtonBorderRadius?.topLeft,
    "border-top-right-radius": isEmpty(
      attributes.dealButtonBorderRadius?.topRight
    )
      ? " 2px"
      : attributes.dealButtonBorderRadius?.topRight,
    "border-bottom-left-radius": isEmpty(
      attributes.dealButtonBorderRadius?.bottomLeft
    )
      ? " 2px"
      : attributes.dealButtonBorderRadius?.bottomLeft,
    "border-bottom-right-radius": isEmpty(
      attributes.dealButtonBorderRadius?.bottomRight
    )
      ? " 2px"
      : attributes.dealButtonBorderRadius?.bottomRight,
    borderTop: isValueEmpty(getSingleSideBorderValue(couponCodeBorder, "top"))
      ? "2px solid #56b151"
      : getSingleSideBorderValue(couponCodeBorder, "top"),
    borderLeft: isValueEmpty(getSingleSideBorderValue(couponCodeBorder, "left"))
      ? "2px solid #56b151"
      : getSingleSideBorderValue(couponCodeBorder, "left"),
    borderRight: isValueEmpty(
      getSingleSideBorderValue(couponCodeBorder, "right")
    )
      ? "2px solid #56b151"
      : getSingleSideBorderValue(couponCodeBorder, "right"),
    borderBottom: isValueEmpty(
      getSingleSideBorderValue(couponCodeBorder, "bottom")
    )
      ? "2px solid #56b151"
      : getSingleSideBorderValue(couponCodeBorder, "bottom"),
  };

  let expirationDateStyles = {
    "--wpcd-coupon-expiration-date-font-size": isEmpty(
      attributes?.expirationDateFontSize
    )
      ? "14px"
      : attributes?.expirationDateFontSize,
    "--wpcd-coupon-expired-date-font-size": isEmpty(
      attributes?.expiredDateFontSize
    )
      ? "14px"
      : attributes?.expiredDateFontSize,
    "--wpcd-coupon-expiration-date-color": isEmpty(
      attributes?.expirationDateColor
    )
      ? "green"
      : attributes?.expirationDateColor,
    "--wpcd-coupon-expired-date-color": isEmpty(attributes?.expiredDateColor)
      ? "red"
      : attributes?.expiredDateColor,
  };
  const date = new Date(expirationDate);
  const expirationDateInLocalString = date
    .toLocaleDateString("en-GB")
    .replace(/\//g, "-");

  return (
    <div className="wpcd-coupon-inner__wrapper">
      <div className="wpcd-coupon-discount-wrapper">
        <div className="wpcd-coupon-discount-inner__wrapper">
          <RichText
            className="wpcd-coupon-discount"
            value={discount}
            tagName="div"
            onChange={(newValue) => setAttributes({ discount: newValue })}
            placeholder={__("100%", "wp-coupons-and-deals")}
            style={generateStyles(discountStyles)}
          />
          <RichText
            tagName="div"
            className="wpcd-coupon-name"
            value={couponDealLabel}
            onChange={(newValue) =>
              setAttributes({ couponDealLabel: newValue })
            }
            placeholder={__("Coupon", "wp-coupons-and-deals")}
            style={generateStyles(couponDealLabelStyles)}
          />
          <div
            className={`wpcd-coupon-expiration-date${
              isDoesNotExpire ? " wpcd-coupon-does-not-expire" : ""
            }`}
            style={generateStyles(expirationDateStyles)}
          >
            {!isDoesNotExpire && (
              <>
                <span>{__("Expire On: ", "wp-coupons-and-deals")}</span>
                <span>{expirationDateInLocalString}</span>
              </>
            )}
            {isDoesNotExpire && (
              <RichText
                value={doesNotExpireText}
                tagName="span"
                onChange={(newValue) =>
                  setAttributes({ doesNotExpireText: newValue })
                }
                placeholder={__(
                  "Doesn't Expire Text Here",
                  "wp-coupons-and-deals"
                )}
              />
            )}
          </div>
        </div>
      </div>

      <div className="wpcd-coupon-details-wrapper">
        <div
          className="wpcd-coupon-header"
          style={generateStyles(separatorStyles)}
        >
          <div className="wpcd-coupon-title-wrapper">
            <RichText
              className="wpcd-coupon-title"
              value={title}
              tagName="h3"
              onChange={(newValue) => setAttributes({ title: newValue })}
              placeholder={__("Title here", "wp-coupons-and-deals")}
              style={generateStyles(titleStyles)}
            />
          </div>
        </div>
        <div className="wpcd-coupon-content">
          <div className="wpcd-coupon-description">
            <RichText
              value={description}
              tagName="p"
              onChange={(newValue) => setAttributes({ description: newValue })}
              placeholder={__("Description here", "wp-coupons-and-deals")}
              style={generateStyles(descriptionStyles)}
            />
          </div>
        </div>
      </div>
      <div className="wpcd-coupon-code">
        <a
          rel="nofollow noopener"
          target="_blank"
          data-clipboard-text={code}
          className="wpcd-coupon-button"
          title={__("Click To Copy Coupon", "wp-coupons-and-deals")}
          style={generateStyles(codeStyles)}
        >
          <RichText
            value={code}
            tagName="span"
            onChange={(newValue) => setAttributes({ code: newValue })}
            placeholder={__("SAMPLECODE", "wp-coupons-and-deals")}
          />
        </a>
        <a
          rel="nofollow noopener"
          target="_blank"
          className="wpcd-coupon-button"
          style={generateStyles(dealButtonStyles)}
          title={__("Click To Claim This Deal", "wp-coupons-and-deals")}
        >
          <RichText
            value={dealButtonText}
            tagName="span"
            onChange={(newValue) => setAttributes({ dealButtonText: newValue })}
            placeholder={__("Get Deal", "wp-coupons-and-deals")}
          />
        </a>
      </div>
    </div>
  );
}
export default DefaultTemplate;
