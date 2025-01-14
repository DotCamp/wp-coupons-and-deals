/**
 * Wordpress Dependencies
 */
import { __ } from "@wordpress/i18n";
import {
  BaseControl,
  DatePicker,
  PanelBody,
  TextControl,
  ToggleControl,
  TabPanel,
} from "@wordpress/components";
import { InspectorControls } from "@wordpress/block-editor";
/**
 * Internal Imports
 */
import {
  ColorSettings,
  ColorSettingsWithGradient,
  BorderControl,
  CustomFontSizePicker,
  CustomToggleGroupControl,
  SpacingControlWithToolsPanel,
} from "./StylingControls";
import HideCouponSettings from "./components/HideCouponSettings";
import TabsPanelControl from "./components/TabsPanelControl";

function Inspector(props) {
  const { attributes, setAttributes } = props;
  const {
    navigationLink,
    expiredDateText,
    expirationDate,
    hideCoupon,
    isDoesNotExpire,
    couponType,
  } = attributes;
  const normalStateColors = (
    <>
      <ColorSettings
        attrKey="titleColor"
        label={__("Title Color", "wp-coupons-and-deals")}
      />
      <ColorSettings
        attrKey="descriptionColor"
        label={__("Description Color", "wp-coupons-and-deals")}
      />
      <ColorSettings
        attrKey="codeColor"
        label={
          couponType !== "deal"
            ? __("Code Color", "wp-coupons-and-deals")
            : __("Get Deal Color", "wp-coupons-and-deals")
        }
      />
      <ColorSettings
        attrKey="discountColor"
        label={__("Discount Color", "wp-coupons-and-deals")}
      />
      <ColorSettings
        attrKey="couponDealLabelColor"
        label={__("Coupon/Deal Label Color", "wp-coupons-and-deals")}
      />
      <ColorSettings
        attrKey="expirationDateColor"
        label={
          isDoesNotExpire
            ? __("Doesn't Expire Color", "wp-coupons-and-deals")
            : __("Expiration Date Color", "wp-coupons-and-deals")
        }
      />
      {!isDoesNotExpire && (
        <ColorSettings
          attrKey="expiredDateColor"
          label={__("Expired Date Color", "wp-coupons-and-deals")}
        />
      )}
      <ColorSettingsWithGradient
        attrBackgroundKey="codeBackgroundColor"
        attrGradientKey="codeGradientBackground"
        label={
          couponType !== "deal"
            ? __("Code Background", "wp-coupons-and-deals")
            : __("Get Deal Background", "wp-coupons-and-deals")
        }
      />
      <ColorSettingsWithGradient
        attrBackgroundKey="couponDealLabelBackgroundColor"
        attrGradientKey="couponDealLabelGradientBackground"
        label={__("Coupon/Deal Background", "wp-coupons-and-deals")}
      />
      <ColorSettingsWithGradient
        attrBackgroundKey="wrapperBackgroundColor"
        attrGradientKey="wrapperGradientBackground"
        label={__("Wrapper Background", "wp-coupons-and-deals")}
      />
      {hideCoupon && (
        <>
          <ColorSettings
            attrKey="couponPopupOfferButtonColor"
            label={__("Popup Navigation Button Color", "wp-coupons-and-deals")}
          />
          <ColorSettings
            attrKey="couponPopupCopyButtonColor"
            label={__("Popup Copy Button Color", "wp-coupons-and-deals")}
          />
          <ColorSettings
            attrKey="couponPopupCodeFieldColor"
            label={__("Popup Coupon Field Color", "wp-coupons-and-deals")}
          />
          <ColorSettingsWithGradient
            attrBackgroundKey="couponPopupOfferButtonBgColor"
            attrGradientKey="couponPopupOfferButtonBgGradient"
            label={__(
              "Popup Navigation Button Background",
              "wp-coupons-and-deals"
            )}
          />
          <ColorSettingsWithGradient
            attrBackgroundKey="couponPopupCopyButtonBgColor"
            attrGradientKey="couponPopupCopyButtonBgGradient"
            label={__("Popup Copy Button Background", "wp-coupons-and-deals")}
          />
          <ColorSettingsWithGradient
            attrBackgroundKey="couponPopupCodeFieldBgColor"
            attrGradientKey="couponPopupCodeFieldBgGradient"
            label={__("Popup Coupon Field Background", "wp-coupons-and-deals")}
          />
        </>
      )}
    </>
  );
  const hoverStateColors = (
    <>
      <ColorSettings
        attrKey="codeHoverColor"
        label={
          couponType !== "deal"
            ? __("Code Hover Color", "wp-coupons-and-deals")
            : __("Get Deal Hover Color", "wp-coupons-and-deals")
        }
      />

      <ColorSettingsWithGradient
        attrBackgroundKey="codeHoverBackgroundColor"
        attrGradientKey="codeHoverGradientBackground"
        label={
          couponType !== "deal"
            ? __("Code Hover Background", "wp-coupons-and-deals")
            : __("Get Deal Hover Background", "wp-coupons-and-deals")
        }
      />
    </>
  );
  const couponTypes = [
    {
      label: __("Coupon", "wp-coupons-and-deals"),
      value: "coupon",
    },
    {
      label: __("Deal", "wp-coupons-and-deals"),
      value: "deal",
    },
  ];
  return (
    <>
      <InspectorControls>
        <PanelBody title={__("General", "wp-coupons-and-deals")}>
          <CustomToggleGroupControl
            label={__("Coupon Type", "wp-coupons-and-deals")}
            isBlock
            options={couponTypes}
            attributeKey="couponType"
          />
          <TextControl
            label={__(
              "Link To Navigate On Copy (Affiliate Link)",
              "wp-coupons-and-deals"
            )}
            type="url"
            value={navigationLink}
            onChange={(newLink) => setAttributes({ navigationLink: newLink })}
          />
          <ToggleControl
            label={__("Doesn't Expire", "wp-coupons-and-deals")}
            checked={isDoesNotExpire}
            onChange={() =>
              setAttributes({ isDoesNotExpire: !isDoesNotExpire })
            }
          />
          {!isDoesNotExpire && (
            <>
              <TextControl
                label={__("Expired Date Label", "wp-coupons-and-deals")}
                value={expiredDateText}
                help={__(
                  "This text will show when coupon date is expired.",
                  "wp-coupons-and-deals"
                )}
                onChange={(newLink) =>
                  setAttributes({ expiredDateText: newLink })
                }
              />
              <BaseControl
                label={__("Expiration Date", "wp-coupons-and-deals")}
              >
                <DatePicker
                  currentDate={expirationDate}
                  onChange={(newDate) => {
                    const date = new Date(newDate);
                    setAttributes({
                      expirationDate: date.toLocaleDateString(),
                    });
                  }}
                />
              </BaseControl>
            </>
          )}
          {couponType !== "deal" && (
            <>
              <ToggleControl
                label={__("Hide Coupon", "wp-coupons-and-deals")}
                checked={hideCoupon}
                onChange={() => setAttributes({ hideCoupon: !hideCoupon })}
              />
              {hideCoupon && <HideCouponSettings {...props} />}
            </>
          )}
        </PanelBody>
      </InspectorControls>

      <InspectorControls group="color">
        <TabsPanelControl
          normalStateLabel={__("Normal", "wp-coupons-and-deals")}
          hoverStateLabel={__("Hover", "wp-coupons-and-deals")}
          normalState={normalStateColors}
          hoverState={hoverStateColors}
        />
      </InspectorControls>
      <InspectorControls group="typography">
        <CustomFontSizePicker
          attrKey="discountFontSize"
          label={__("Discount Font Size", "wp-coupons-and-deals")}
        />
        <CustomFontSizePicker
          attrKey="couponDealLabelFontSize"
          label={__("Coupon/Deal Label Font Size", "wp-coupons-and-deals")}
        />
        <CustomFontSizePicker
          attrKey="titleFontSize"
          label={__("Title Font Size", "wp-coupons-and-deals")}
        />
        <CustomFontSizePicker
          attrKey="descriptionFontSize"
          label={__("Description Font Size", "wp-coupons-and-deals")}
        />
        <CustomFontSizePicker
          attrKey="codeFontSize"
          label={
            couponType !== "deal"
              ? __("Code Font Size", "wp-coupons-and-deals")
              : __("Get Deal Font Size", "wp-coupons-and-deals")
          }
        />
        <CustomFontSizePicker
          attrKey="expirationDateFontSize"
          label={__("Expiration Date Font Size", "wp-coupons-and-deals")}
        />
        <CustomFontSizePicker
          attrKey="expiredDateFontSize"
          label={__("Expired Date Font Size", "wp-coupons-and-deals")}
        />
      </InspectorControls>
      <InspectorControls group="border">
        <BorderControl
          showDefaultBorder
          showDefaultBorderRadius
          attrBorderKey="wrapperBorder"
          attrBorderRadiusKey="wrapperBorderRadius"
          borderLabel={__("Wrapper Border", "wp-coupons-and-deals")}
          borderRadiusLabel={__(
            "Wrapper Border Radius",
            "wp-coupons-and-deals"
          )}
        />
        <BorderControl
          showDefaultBorder
          showDefaultBorderRadius
          attrBorderKey="codeBorder"
          attrBorderRadiusKey="codeBorderRadius"
          borderLabel={
            couponType !== "deal"
              ? __("Code Border", "wp-coupons-and-deals")
              : __("Get Deal Border", "wp-coupons-and-deals")
          }
          borderRadiusLabel={
            couponType !== "deal"
              ? __("Code Border Radius", "wp-coupons-and-deals")
              : __("Get Deal Border Radius", "wp-coupons-and-deals")
          }
        />
        <BorderControl
          showDefaultBorder
          showDefaultBorderRadius
          isShowBorderRadius={false}
          attrBorderKey="separatorBorder"
          borderLabel={__("Separator Border", "wp-coupons-and-deals")}
        />
        {hideCoupon && couponType !== "deal" && (
          <BorderControl
            showDefaultBorder
            showDefaultBorderRadius
            isShowBorderRadius={false}
            attrBorderKey="couponPopupCodeFieldBorder"
            borderLabel={__(
              "Popup Coupon Field Border",
              "wp-coupons-and-deals"
            )}
          />
        )}
      </InspectorControls>
      <InspectorControls group="dimensions">
        <SpacingControlWithToolsPanel
          showByDefault
          attrKey="padding"
          label={__("Padding", "wp-coupons-and-deals")}
        />
        <SpacingControlWithToolsPanel
          minimumCustomValue={-Infinity}
          showByDefault
          attrKey="margin"
          label={__("Margin", "wp-coupons-and-deals")}
        />
      </InspectorControls>
    </>
  );
}
export default Inspector;
