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
  Disabled,
} from "@wordpress/components";
import { InspectorControls } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";
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
  UBSelectControl,
} from "./StylingControls";
import HideCouponSettings from "./components/HideCouponSettings";
import TabsPanelControl from "./components/TabsPanelControl";
const IS_PRO = WPCD_CFG?.IS_PRO === "true";
function Inspector(props) {
  const { attributes, setAttributes } = props;
  const {
    navigationLink,
    expiredDateText,
    expirationDate,
    hideCoupon,
    isDoesNotExpire,
    dealButtonText,
    template,
    couponType,
    secondExpirationDate,
    thirdExpirationDate,
    secondNavigationLink,
    thirdNavigationLink,
  } = attributes;
  useEffect(() => {
    if (!IS_PRO) {
      if (template !== "template-default") {
        setAttributes({ template: "template-default" });
      }
      if (hideCoupon) {
        setAttributes({ hideCoupon: false });
      }
    }
  }, []);
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
        attrKey="separatorColor"
        label={__("Separator Color", "wp-coupons-and-deals")}
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
        attrBackgroundKey="discountBgColor"
        attrGradientKey="discountBgGradientColor"
        label={__("Discount Background", "wp-coupons-and-deals")}
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
      {hideCoupon && IS_PRO && (
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
          <Disabled isDisabled={!IS_PRO}>
            <UBSelectControl
              label={__(
                `Template${!IS_PRO ? " (Pro)" : ""}`,
                "wp-coupons-and-deals"
              )}
              options={[
                {
                  label: __("Default", "wp-coupons-and-deals"),
                  value: "template-default",
                },
                {
                  label: __("Template One", "wp-coupons-and-deals"),
                  value: "template-one",
                },
                {
                  label: __("Template Two", "wp-coupons-and-deals"),
                  value: "template-two",
                },
                {
                  label: __("Template Three", "wp-coupons-and-deals"),
                  value: "template-three",
                },
                {
                  label: __("Template Four", "wp-coupons-and-deals"),
                  value: "template-four",
                },
                {
                  label: __("Template Five", "wp-coupons-and-deals"),
                  value: "template-five",
                },
                {
                  label: __("Template Six", "wp-coupons-and-deals"),
                  value: "template-six",
                },
                {
                  label: __("Template Seven", "wp-coupons-and-deals"),
                  value: "template-seven",
                },
                {
                  label: __("Template Eight", "wp-coupons-and-deals"),
                  value: "template-eight",
                },
                {
                  label: __("Template Nine", "wp-coupons-and-deals"),
                  value: "template-nine",
                },
              ]}
              value={attributes.template}
              onChange={(newTemplate) =>
                setAttributes({ template: newTemplate })
              }
            />
          </Disabled>
          <br></br>
          <CustomToggleGroupControl
            label={__("Coupon Type", "wp-coupons-and-deals")}
            isBlock
            options={couponTypes}
            attributeKey="couponType"
          />
          {couponType === "deal" && template === "template-seven" && (
            <TextControl
              label={__("Get Deal Text", "wp-coupons-and-deals")}
              onChange={(newValue) =>
                setAttributes({ dealButtonText: newValue })
              }
              value={dealButtonText}
            />
          )}
          <TextControl
            label={__(
              "Link To Navigate On Copy (Affiliate Link)",
              "wp-coupons-and-deals"
            )}
            type="url"
            value={navigationLink}
            onChange={(newLink) => setAttributes({ navigationLink: newLink })}
          />
          {template === "template-four" && (
            <>
              <TextControl
                label={__(
                  "Link To Navigate On Copy (Affiliate Link) (2nd)",
                  "wp-coupons-and-deals"
                )}
                type="url"
                value={secondNavigationLink}
                onChange={(newLink) =>
                  setAttributes({ secondNavigationLink: newLink })
                }
              />
              <TextControl
                label={__(
                  "Link To Navigate On Copy (Affiliate Link) (3rd)",
                  "wp-coupons-and-deals"
                )}
                type="url"
                value={thirdNavigationLink}
                onChange={(newLink) =>
                  setAttributes({ thirdNavigationLink: newLink })
                }
              />
            </>
          )}
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
                    setAttributes({
                      expirationDate: newDate,
                    });
                  }}
                />
              </BaseControl>
              {template === "template-four" && (
                <>
                  <BaseControl
                    label={__("Second Expiration Date", "wp-coupons-and-deals")}
                  >
                    <DatePicker
                      currentDate={secondExpirationDate}
                      onChange={(newDate) => {
                        setAttributes({
                          secondExpirationDate: newDate,
                        });
                      }}
                    />
                  </BaseControl>
                  <BaseControl
                    label={__("Third Expiration Date", "wp-coupons-and-deals")}
                  >
                    <DatePicker
                      currentDate={thirdExpirationDate}
                      onChange={(newDate) => {
                        setAttributes({
                          thirdExpirationDate: newDate,
                        });
                      }}
                    />
                  </BaseControl>
                </>
              )}
            </>
          )}
          {couponType !== "deal" && (
            <Disabled isDisabled={!IS_PRO}>
              <ToggleControl
                label={__(
                  `Hide Coupon${!IS_PRO ? " (Pro)" : ""}`,
                  "wp-coupons-and-deals"
                )}
                checked={hideCoupon}
                onChange={() => setAttributes({ hideCoupon: !hideCoupon })}
              />
              {hideCoupon && IS_PRO && <HideCouponSettings {...props} />}
            </Disabled>
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
