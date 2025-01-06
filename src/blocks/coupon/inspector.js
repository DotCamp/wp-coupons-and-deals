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
} from "../../components/StylingControls";
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
        label={__("Title Color", "ultimate-blocks-pro")}
      />
      <ColorSettings
        attrKey="descriptionColor"
        label={__("Description Color", "ultimate-blocks-pro")}
      />
      <ColorSettings
        attrKey="codeColor"
        label={
          couponType !== "deal"
            ? __("Code Color", "ultimate-blocks-pro")
            : __("Get Deal Color", "ultimate-blocks-pro")
        }
      />
      <ColorSettings
        attrKey="discountColor"
        label={__("Discount Color", "ultimate-blocks-pro")}
      />
      <ColorSettings
        attrKey="couponDealLabelColor"
        label={__("Coupon/Deal Label Color", "ultimate-blocks-pro")}
      />
      <ColorSettings
        attrKey="expirationDateColor"
        label={
          isDoesNotExpire
            ? __("Doesn't Expire Color", "ultimate-blocks-pro")
            : __("Expiration Date Color", "ultimate-blocks-pro")
        }
      />
      {!isDoesNotExpire && (
        <ColorSettings
          attrKey="expiredDateColor"
          label={__("Expired Date Color", "ultimate-blocks-pro")}
        />
      )}
      <ColorSettingsWithGradient
        attrBackgroundKey="codeBackgroundColor"
        attrGradientKey="codeGradientBackground"
        label={
          couponType !== "deal"
            ? __("Code Background", "ultimate-blocks-pro")
            : __("Get Deal Background", "ultimate-blocks-pro")
        }
      />
      <ColorSettingsWithGradient
        attrBackgroundKey="couponDealLabelBackgroundColor"
        attrGradientKey="couponDealLabelGradientBackground"
        label={__("Coupon/Deal Background", "ultimate-blocks-pro")}
      />
      <ColorSettingsWithGradient
        attrBackgroundKey="wrapperBackgroundColor"
        attrGradientKey="wrapperGradientBackground"
        label={__("Wrapper Background", "ultimate-blocks-pro")}
      />
      {hideCoupon && (
        <>
          <ColorSettings
            attrKey="couponPopupOfferButtonColor"
            label={__("Popup Navigation Button Color", "ultimate-blocks-pro")}
          />
          <ColorSettings
            attrKey="couponPopupCopyButtonColor"
            label={__("Popup Copy Button Color", "ultimate-blocks-pro")}
          />
          <ColorSettings
            attrKey="couponPopupCodeFieldColor"
            label={__("Popup Coupon Field Color", "ultimate-blocks-pro")}
          />
          <ColorSettingsWithGradient
            attrBackgroundKey="couponPopupOfferButtonBgColor"
            attrGradientKey="couponPopupOfferButtonBgGradient"
            label={__(
              "Popup Navigation Button Background",
              "ultimate-blocks-pro"
            )}
          />
          <ColorSettingsWithGradient
            attrBackgroundKey="couponPopupCopyButtonBgColor"
            attrGradientKey="couponPopupCopyButtonBgGradient"
            label={__("Popup Copy Button Background", "ultimate-blocks-pro")}
          />
          <ColorSettingsWithGradient
            attrBackgroundKey="couponPopupCodeFieldBgColor"
            attrGradientKey="couponPopupCodeFieldBgGradient"
            label={__("Popup Coupon Field Background", "ultimate-blocks-pro")}
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
            ? __("Code Hover Color", "ultimate-blocks-pro")
            : __("Get Deal Hover Color", "ultimate-blocks-pro")
        }
      />

      <ColorSettingsWithGradient
        attrBackgroundKey="codeHoverBackgroundColor"
        attrGradientKey="codeHoverGradientBackground"
        label={
          couponType !== "deal"
            ? __("Code Hover Background", "ultimate-blocks-pro")
            : __("Get Deal Hover Background", "ultimate-blocks-pro")
        }
      />
    </>
  );
  const couponTypes = [
    {
      label: __("Coupon", "ultimate-blocks-pro"),
      value: "coupon",
    },
    {
      label: __("Deal", "ultimate-blocks-pro"),
      value: "deal",
    },
  ];
  return (
    <>
      <InspectorControls>
        <PanelBody title={__("General", "ultimate-blocks-pro")}>
          <CustomToggleGroupControl
            label={__("Coupon Type", "ultimate-blocks-pro")}
            isBlock
            options={couponTypes}
            attributeKey="couponType"
          />
          <TextControl
            label={__(
              "Link To Navigate On Copy (Affiliate Link)",
              "ultimate-blocks-pro"
            )}
            type="url"
            value={navigationLink}
            onChange={(newLink) => setAttributes({ navigationLink: newLink })}
          />
          <ToggleControl
            label={__("Doesn't Expire", "ultimate-blocks-pro")}
            checked={isDoesNotExpire}
            onChange={() =>
              setAttributes({ isDoesNotExpire: !isDoesNotExpire })
            }
          />
          {!isDoesNotExpire && (
            <>
              <TextControl
                label={__("Expired Date Label", "ultimate-blocks-pro")}
                value={expiredDateText}
                help={__(
                  "This text will show when coupon date is expired.",
                  "ultimate-blocks-pro"
                )}
                onChange={(newLink) =>
                  setAttributes({ expiredDateText: newLink })
                }
              />
              <BaseControl label={__("Expiration Date", "ultimate-blocks-pro")}>
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
                label={__("Hide Coupon", "ultimate-blocks-pro")}
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
          normalStateLabel={__("Normal", "ultimate-blocks-pro")}
          hoverStateLabel={__("Hover", "ultimate-blocks-pro")}
          normalState={normalStateColors}
          hoverState={hoverStateColors}
        />
      </InspectorControls>
      <InspectorControls group="typography">
        <CustomFontSizePicker
          attrKey="discountFontSize"
          label={__("Discount Font Size", "ultimate-blocks-pro")}
        />
        <CustomFontSizePicker
          attrKey="couponDealLabelFontSize"
          label={__("Coupon/Deal Label Font Size", "ultimate-blocks-pro")}
        />
        <CustomFontSizePicker
          attrKey="titleFontSize"
          label={__("Title Font Size", "ultimate-blocks-pro")}
        />
        <CustomFontSizePicker
          attrKey="descriptionFontSize"
          label={__("Description Font Size", "ultimate-blocks-pro")}
        />
        <CustomFontSizePicker
          attrKey="codeFontSize"
          label={
            couponType !== "deal"
              ? __("Code Font Size", "ultimate-blocks-pro")
              : __("Get Deal Font Size", "ultimate-blocks-pro")
          }
        />
        <CustomFontSizePicker
          attrKey="expirationDateFontSize"
          label={__("Expiration Date Font Size", "ultimate-blocks-pro")}
        />
        <CustomFontSizePicker
          attrKey="expiredDateFontSize"
          label={__("Expired Date Font Size", "ultimate-blocks-pro")}
        />
      </InspectorControls>
      <InspectorControls group="border">
        <BorderControl
          showDefaultBorder
          showDefaultBorderRadius
          attrBorderKey="wrapperBorder"
          attrBorderRadiusKey="wrapperBorderRadius"
          borderLabel={__("Wrapper Border", "ultimate-blocks-pro")}
          borderRadiusLabel={__("Wrapper Border Radius", "ultimate-blocks-pro")}
        />
        <BorderControl
          showDefaultBorder
          showDefaultBorderRadius
          attrBorderKey="codeBorder"
          attrBorderRadiusKey="codeBorderRadius"
          borderLabel={
            couponType !== "deal"
              ? __("Code Border", "ultimate-blocks-pro")
              : __("Get Deal Border", "ultimate-blocks-pro")
          }
          borderRadiusLabel={
            couponType !== "deal"
              ? __("Code Border Radius", "ultimate-blocks-pro")
              : __("Get Deal Border Radius", "ultimate-blocks-pro")
          }
        />
        <BorderControl
          showDefaultBorder
          showDefaultBorderRadius
          isShowBorderRadius={false}
          attrBorderKey="separatorBorder"
          borderLabel={__("Separator Border", "ultimate-blocks-pro")}
        />
        {hideCoupon && couponType !== "deal" && (
          <BorderControl
            showDefaultBorder
            showDefaultBorderRadius
            isShowBorderRadius={false}
            attrBorderKey="couponPopupCodeFieldBorder"
            borderLabel={__("Popup Coupon Field Border", "ultimate-blocks-pro")}
          />
        )}
      </InspectorControls>
      <InspectorControls group="dimensions">
        <SpacingControlWithToolsPanel
          showByDefault
          attrKey="padding"
          label={__("Padding", "ultimate-blocks-pro")}
        />
        <SpacingControlWithToolsPanel
          minimumCustomValue={-Infinity}
          showByDefault
          attrKey="margin"
          label={__("Margin", "ultimate-blocks-pro")}
        />
      </InspectorControls>
    </>
  );
}
export default Inspector;
