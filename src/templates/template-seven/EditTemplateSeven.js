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

function TemplateSeven(props) {
  const [countdown, setCountdown] = useState("");

  const { attributes, setAttributes } = props;
  const couponType = attributes.couponType || "default";
  const discount = attributes.discount || "";
  const title = attributes.title || "";
  const description = attributes.description || "";
  const code = attributes.code || "";
  const expirationDate = attributes.expirationDate || "";
  const expiredDateText = attributes.expiredDateText || "";
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
      ? "24px"
      : attributes?.discountFontSize,
    color: isEmpty(attributes?.discountColor)
      ? "#ffffff"
      : attributes?.discountColor,
    backgroundColor: discountBgColor,
  };

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
  const borderStyle = "2px solid #9b59b6'";
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
      (couponType === "deal" ? "2px solid #9b59b6" : borderStyle),
    borderLeft:
      getSingleSideBorderValue(couponCodeBorder, "left") ||
      (couponType === "deal" ? "2px solid #9b59b6" : borderStyle),
    borderRight:
      getSingleSideBorderValue(couponCodeBorder, "right") ||
      (couponType === "deal" ? "2px solid #9b59b6" : borderStyle),
    borderBottom:
      getSingleSideBorderValue(couponCodeBorder, "bottom") ||
      (couponType === "deal" ? "2px solid #9b59b6" : borderStyle),
  };
  const expirationDateStyles = {
    "--wpcd-coupon-expiration-date-font-size":
      attributes.expirationDateFontSize || "14px",
    "--wpcd-coupon-expired-date-font-size":
      attributes.expiredDateFontSize || "14px",
    "--wpcd-coupon-expiration-date-color":
      attributes.expirationDateColor || "#000000",
    "--wpcd-coupon-expired-date-color": attributes.expiredDateColor || "red",
  };
  const separatorColor = attributes.separatorColor || "#000000";
  const separatorStyles = {
    borderTop: `1px dashed ${separatorColor}`,
    borderBottom: `1px dashed ${separatorColor}`,
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
            <figure className="wpcd-coupon-seven-image">
              <img src={imageUrl} alt="Coupon" />
            </figure>
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
              <RichText
                className="wpcd-coupon-description"
                value={description}
                tagName="p"
                onChange={(newValue) =>
                  setAttributes({ description: newValue })
                }
                placeholder={__("Description here", "wp-coupons-and-deals")}
                style={generateStyles(descriptionStyles)}
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
            </div>
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
                data-coupon_code={`${
                  !isEmpty(attributes.code) ? attributes.code : ""
                }`}
              >
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
                data-coupon_code={`${
                  !isEmpty(attributes.dealButtonText)
                    ? attributes.dealButtonText
                    : ""
                }`}
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
      </div>
    </div>
  );
}
export default TemplateSeven;
