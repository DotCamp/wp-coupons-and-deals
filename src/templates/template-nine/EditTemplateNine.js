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

function TemplateNine(props) {
  const { attributes, setAttributes } = props;
  const { title, code, couponType, dealButtonText } = attributes;

  const couponCodeBorder = getBorderCSS(attributes.codeBorder);
  const separatorBorder = getBorderCSS(attributes.separatorBorder);

  let titleStyles = {
    fontSize: isEmpty(attributes?.titleFontSize)
      ? "21px"
      : attributes?.titleFontSize,
    color: isEmpty(attributes?.titleColor) ? "#000000" : attributes?.titleColor,
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

  return (
    <div className="wpcd-coupon-inner__wrapper">
      <RichText
        className="wpcd-coupon-title"
        value={title}
        tagName="h3"
        onChange={(newValue) => setAttributes({ title: newValue })}
        placeholder={__("Title here", "wp-coupons-and-deals")}
        style={generateStyles(titleStyles)}
      />
      <div className="wpcd-coupon-code">
        {couponType !== "deal" && (
          <a
            rel="nofollow noopener"
            target="_blank"
            data-clipboard-text={code}
            className="wpcd-coupon-button"
            title={__("Click To Copy Coupon", "wp-coupons-and-deals")}
            style={generateStyles(codeStyles)}
          >
            <span className="wpcd-coupon-icon">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
              >
                <g fill="currentColor">
                  <path
                    fill-rule="evenodd"
                    d="M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z"
                    clip-rule="evenodd"
                  />
                  <path d="M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z" />
                </g>
              </svg>
            </span>
            <RichText
              value={code}
              tagName="span"
              onChange={(newValue) => setAttributes({ code: newValue })}
              placeholder={__("SAMPLECODE", "wp-coupons-and-deals")}
            />
          </a>
        )}
        {couponType === "deal" && (
          <a
            rel="nofollow noopener"
            target="_blank"
            className="wpcd-coupon-button"
            style={generateStyles(codeStyles)}
            title={__("Click To Claim This Deal", "wp-coupons-and-deals")}
          >
            <RichText
              value={dealButtonText}
              tagName="span"
              onChange={(newValue) =>
                setAttributes({ dealButtonText: newValue })
              }
              placeholder={__("Get Deal", "wp-coupons-and-deals")}
            />
          </a>
        )}
      </div>
    </div>
  );
}
export default TemplateNine;
