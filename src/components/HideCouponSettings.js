import { __ } from "@wordpress/i18n";
import { TextControl, TextareaControl } from "@wordpress/components";

function HideCouponSettings({ attributes, setAttributes }) {
  const {
    couponPopupCopyButtonText,
    couponPopupOfferText,
    couponCodeButtonText,
  } = attributes;
  return (
    <>
      <TextControl
        label={__("HIDDEN COUPON TEXT", "wp-coupons-and-deals")}
        value={couponCodeButtonText}
        onChange={(newValue) =>
          setAttributes({ couponCodeButtonText: newValue })
        }
      />
      <TextControl
        label={__("Popup Copy Button Text", "wp-coupons-and-deals")}
        value={couponPopupCopyButtonText}
        onChange={(newValue) =>
          setAttributes({ couponPopupCopyButtonText: newValue })
        }
      />
      <TextControl
        label={__("POPUP OFFER BUTTON TEXT", "wp-coupons-and-deals")}
        value={couponPopupOfferText}
        onChange={(newValue) =>
          setAttributes({ couponPopupOfferText: newValue })
        }
      />
    </>
  );
}
export default HideCouponSettings;
