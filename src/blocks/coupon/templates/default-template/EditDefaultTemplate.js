/**
 * Wordpress Dependencies
 */
import { __ } from "@wordpress/i18n";
import { RichText } from "@wordpress/block-editor";

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

  return (
    <div className="ub-coupon-inner__wrapper">
      <div className="ub-coupon-discount-wrapper">
        <div className="ub-coupon-discount-inner__wrapper">
          <RichText
            className="ub-coupon-discount"
            value={discount}
            tagName="div"
            onChange={(newValue) => setAttributes({ discount: newValue })}
            placeholder={__("100%", "ultimate-blocks-pro")}
          />
          <RichText
            tagName="div"
            className="ub-coupon-name"
            value={couponDealLabel}
            onChange={(newValue) =>
              setAttributes({ couponDealLabel: newValue })
            }
            placeholder={__("Coupon", "ultimate-blocks-pro")}
          />
        </div>
      </div>

      <div className="ub-coupon-details-wrapper">
        <div className="ub-coupon-header">
          <div className="ub-coupon-title-wrapper">
            <RichText
              className="ub-coupon-title"
              value={title}
              tagName="h3"
              onChange={(newValue) => setAttributes({ title: newValue })}
              placeholder={__("Title here", "ultimate-blocks-pro")}
            />
          </div>
          <div className="ub-coupon-code">
            {couponType !== "deal" && (
              <a
                rel="nofollow noopener"
                target="_blank"
                data-clipboard-text={code}
                className="ub-coupon-button"
                title={__("Click To Copy Coupon", "ultimate-blocks-pro")}
              >
                <span className="ub-coupon-icon">
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
                  placeholder={__("SAMPLECODE", "ultimate-blocks-pro")}
                />
              </a>
            )}
            {couponType === "deal" && (
              <a
                rel="nofollow noopener"
                target="_blank"
                className="ub-coupon-button"
                title={__("Click To Claim This Deal", "ultimate-blocks-pro")}
              >
                <RichText
                  value={dealButtonText}
                  tagName="span"
                  onChange={(newValue) =>
                    setAttributes({ dealButtonText: newValue })
                  }
                  placeholder={__("Get Deal", "ultimate-blocks-pro")}
                />
              </a>
            )}
          </div>
        </div>
        <div className="ub-coupon-content">
          <div className="ub-coupon-description">
            <RichText
              value={description}
              tagName="p"
              onChange={(newValue) => setAttributes({ description: newValue })}
              placeholder={__("Description here", "ultimate-blocks-pro")}
            />
          </div>
          <div
            className={`ub-coupon-expiration-date${
              isDoesNotExpire ? " ub-coupon-does-not-expire" : ""
            }`}
          >
            {!isDoesNotExpire && (
              <>
                <span>{__("Expire On ", "ultimate-blocks-pro")}</span>
                <span>{expirationDate}</span>
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
                  "ultimate-blocks-pro"
                )}
              />
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
export default DefaultTemplate;
