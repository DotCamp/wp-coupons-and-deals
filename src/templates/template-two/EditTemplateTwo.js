import { __ } from "@wordpress/i18n";
import {
  generateStyles,
  getBackgroundColorVar,
  getBorderCSS,
  getSingleSideBorderValue,
} from "../../styling-helpers";
import { RichText } from "@wordpress/block-editor";
import { useState, useEffect } from "@wordpress/element";
import { isEmpty } from "lodash";

function generateTemplateOneHtml(props) {
  const [countdown, setCountdown] = useState("");

  const { attributes, setAttributes } = props;
  const couponType = attributes.couponType || "default";
  const discount = attributes.discount || "";
  const title = attributes.title || "";
  const description = attributes.description || "";
  const code = attributes.code || "";
  const expiredDateText = attributes.expiredDateText || "Expired";
  const expirationDate = attributes.expirationDate || "";
  const doesNotExpireText = attributes.doesNotExpireText || "";
  const isDoesNotExpire = attributes.isDoesNotExpire || false;
  const dealButtonText = attributes.dealButtonText || "";
  const couponCodeBorder = getBorderCSS(attributes.codeBorder);

  useEffect(() => {
    const updateCountdown = () => {
      const now = new Date().getTime();
      const distance = new Date(expirationDate).getTime() - now;

      if (distance < 0) {
        setCountdown(expiredDateText);
        return;
      }

      const weeks = Math.floor(distance / (1000 * 60 * 60 * 24 * 7));
      const days = Math.floor(
        (distance % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24)
      );
      const hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      setCountdown(
        `${weeks} weeks ${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`
      );
    };

    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);

    return () => clearInterval(interval);
  }, [expirationDate]);

  const titleStyles = {
    fontSize: attributes.titleFontSize || "21px",
    color: attributes.titleColor || "#000000",
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

  const descriptionStyles = {
    fontSize: attributes.descriptionFontSize || "16px",
    color: attributes.descriptionColor || "#000000",
  };

  const codeHoverBgColor = getBackgroundColorVar(
    attributes,
    "codeHoverBackgroundColor",
    "codeHoverGradientBackground"
  );
  const codeHoverStyles = {
    "--wpcd-coupon-code-bg-hover-color": codeHoverBgColor,
    "--wpcd-coupon-code-hover-color": attributes.codeHoverColor || "",
  };
  const borderStyle = attributes.hideCoupon
    ? "2px solid #56b151"
    : "2px dashed #ccc";
  const codeStyles = {
    ...codeHoverStyles,
    "--wpcd-coupon-code-button-text": attributes.couponCodeButtonText
      ? attributes.couponCodeButtonText
      : "",
    fontSize: attributes.codeFontSize || "",
    "--wpcd-coupon-code-color": attributes.codeColor || "",
    "--wpcd-coupon-code-bg-color": getBackgroundColorVar(
      attributes,
      "codeBackgroundColor",
      "codeGradientBackground"
    ),
    borderTopLeftRadius: attributes.codeBorderRadius?.topLeft || "2px",
    borderTopRightRadius: attributes.codeBorderRadius?.topRight || "2px",
    borderBottomLeftRadius: attributes.codeBorderRadius?.bottomLeft || "2px",
    borderBottomRightRadius: attributes.codeBorderRadius?.bottomRight || "2px",
    borderTop:
      getSingleSideBorderValue(couponCodeBorder, "top") ||
      (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderLeft:
      getSingleSideBorderValue(couponCodeBorder, "left") ||
      (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderRight:
      getSingleSideBorderValue(couponCodeBorder, "right") ||
      (couponType === "deal" ? "2px solid #56b151" : borderStyle),
    borderBottom:
      getSingleSideBorderValue(couponCodeBorder, "bottom") ||
      (couponType === "deal" ? "2px solid #56b151" : borderStyle),
  };
  const expirationDateStyles = {
    "--wpcd-coupon-expiration-date-font-size":
      attributes.expirationDateFontSize || "14px",
    "--wpcd-coupon-expired-date-font-size":
      attributes.expiredDateFontSize || "14px",
    "--wpcd-coupon-expiration-date-color":
      attributes.expirationDateColor || "green",
    "--wpcd-coupon-expired-date-color": attributes.expiredDateColor || "red",
  };
  const separatorColor = attributes.separatorColor || "#cccccc";
  const separatorStyles = {
    borderTop: `1px solid ${separatorColor}`,
    borderBottom: `1px solid ${separatorColor}`,
  };
  const navigationAttrs = {};
  if (!attributes.hideCoupon) {
    navigationAttrs.rel = "nofollow noopener";
    navigationAttrs.target = "_blank";
  }
  const couponDefaultImage =
    "http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png";
  const imageUrl = attributes.couponImage?.url || couponDefaultImage;

  return (
    <div className="wpcd-coupon-inner__wrapper wpcd-coupon-columns">
      <div className="wpcd-coupon-details-wrapper wpcd-coupon-column-1">
        <div className="wpcd-coupon-header">
          <div className="wpcd-coupon-image-wrapper">
            <figure className="wpcd-coupon-two-image">
              <img src={imageUrl} alt="Coupon" />
            </figure>
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
              </div>
            </div>
          </div>
          <div className="wpcd-coupon-content-wrapper">
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
            <div
              className="wpcd-coupon-content"
              style={generateStyles(separatorStyles)}
            >
              <div
                className={`wpcd-coupon-expiration-date${
                  isDoesNotExpire ? " wpcd-coupon-does-not-expire" : ""
                }${
                  countdown === expiredDateText ? " wpcd-coupon-expired" : ""
                }`}
                style={generateStyles(expirationDateStyles)}
              >
                {!isDoesNotExpire ? (
                  <>
                    {countdown !== expiredDateText && <span>Expire On: </span>}
                    <span>{countdown}</span>
                  </>
                ) : (
                  <span>{doesNotExpireText}</span>
                )}
              </div>
              <div className="wpcd-coupon-code">
                {couponType !== "deal" ? (
                  <a
                    style={generateStyles(codeStyles)}
                    {...navigationAttrs}
                    className={`wpcd-coupon-button${
                      attributes.hideCoupon ? " wpcd-popup-button" : ""
                    }`}
                    title="Click To Copy Coupon"
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
                            fillRule="evenodd"
                            d="M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z"
                            clipRule="evenodd"
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
                ) : (
                  <a
                    rel="nofollow noopener"
                    target="_blank"
                    className="wpcd-coupon-button"
                    style={generateStyles(codeStyles)}
                    title="Click To Claim This Deal"
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
            <RichText
              className="wpcd-coupon-description"
              value={description}
              tagName="p"
              onChange={(newValue) => setAttributes({ description: newValue })}
              placeholder={__("Description here", "wp-coupons-and-deals")}
              style={generateStyles(descriptionStyles)}
            />
          </div>
        </div>
      </div>
    </div>
  );
}
export default generateTemplateOneHtml;
