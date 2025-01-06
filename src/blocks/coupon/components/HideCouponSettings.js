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
        label={__("HIDDEN COUPON TEXT", "ultimate-blocks-pro")}
        value={couponCodeButtonText}
        onChange={(newValue) =>
          setAttributes({ couponCodeButtonText: newValue })
        }
      />
      <TextControl
        label={__("Popup Copy Button Text", "ultimate-blocks-pro")}
        value={couponPopupCopyButtonText}
        onChange={(newValue) =>
          setAttributes({ couponPopupCopyButtonText: newValue })
        }
      />
      <TextControl
        label={__("POPUP OFFER BUTTON TEXT", "ultimate-blocks-pro")}
        value={couponPopupOfferText}
        onChange={(newValue) =>
          setAttributes({ couponPopupOfferText: newValue })
        }
      />
    </>
  );
}
export default HideCouponSettings;
