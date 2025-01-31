/**
 * Wordpress Dependencies
 */
import { uniqueId, isEmpty } from "lodash";
import { BlockControls, useBlockProps } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";
import { ToolbarButton } from "@wordpress/components";
import { MediaReplaceFlow } from "@wordpress/block-editor";
/**
 * Internal Dependencies
 */
import {
  DefaultTemplate,
  TemplateNine,
  TemplateOne,
  TemplateSeven,
  TemplateSix,
  TemplateThree,
  TemplateTwo,
} from "./templates/";
import Inspector from "./inspector";
import classNames from "classnames";

import "./editor.scss";
import {
  generateStyles,
  getBorderCSS,
  getSingleSideBorderValue,
  getSpacingCss,
  isValueEmpty,
} from "./styling-helpers";

function Edit(props) {
  const { attributes, setAttributes } = props;
  const {
    template,
    hideCoupon,
    couponId,
    couponType,
    padding,
    margin,
  } = attributes;
  const wrapperBorder = getBorderCSS(attributes.wrapperBorder);

  const paddingObj = getSpacingCss(attributes.padding);
  const marginObj = getSpacingCss(attributes.margin);
  const borderStyles = {
    "template-default": "2px dashed #000000",
    "template-one": "1px solid #d1d1d1",
    "template-two": "1px solid #d1d1d1",
    "template-three": "1px solid #d1d1d1",
    "template-six": "2px solid #18e06e",
    "template-seven": "2px solid #9b59b6",
    "template-nine": "2px dashed #000000",
  };
  const separatorColor = isEmpty(attributes.separatorColor)
    ? "#cccccc"
    : attributes.separatorColor;
  const separatorStyles = {
    "--wpcd-coupon-separator-color": separatorColor,
  };
  const defaultPadding = template === "template-three" ? "0" : "25px";
  const wrapperStyles = {
    backgroundColor: !isEmpty(attributes?.wrapperBackgroundColor)
      ? attributes.wrapperBackgroundColor
      : attributes?.wrapperGradientBackground,
    "padding-top": !isEmpty(paddingObj?.top) ? paddingObj?.top : defaultPadding,
    "padding-right": !isEmpty(paddingObj?.right)
      ? paddingObj?.right
      : defaultPadding,
    "padding-bottom": !isEmpty(paddingObj?.bottom)
      ? paddingObj?.bottom
      : defaultPadding,
    "padding-left": !isEmpty(paddingObj?.left)
      ? paddingObj?.left
      : defaultPadding,
    "margin-top": marginObj?.top,
    "margin-right": marginObj?.right,
    "margin-bottom": marginObj?.bottom,
    "margin-left": marginObj?.left,
    "border-top-left-radius": attributes.wrapperBorderRadius?.topLeft,
    "border-top-right-radius": attributes.wrapperBorderRadius?.topRight,
    "border-bottom-left-radius": attributes.wrapperBorderRadius?.bottomLeft,
    "border-bottom-right-radius": attributes.wrapperBorderRadius?.bottomRight,
    borderTop: !isValueEmpty(getSingleSideBorderValue(wrapperBorder, "top"))
      ? getSingleSideBorderValue(wrapperBorder, "top")
      : borderStyles[template],
    borderLeft: !isValueEmpty(getSingleSideBorderValue(wrapperBorder, "left"))
      ? getSingleSideBorderValue(wrapperBorder, "left")
      : borderStyles[template],
    borderRight: !isValueEmpty(getSingleSideBorderValue(wrapperBorder, "right"))
      ? getSingleSideBorderValue(wrapperBorder, "right")
      : borderStyles[template],
    borderBottom: !isValueEmpty(
      getSingleSideBorderValue(wrapperBorder, "bottom")
    )
      ? getSingleSideBorderValue(wrapperBorder, "bottom")
      : borderStyles[template],
    ...(template === "template-one" ? separatorStyles : {}),
  };

  const blockProps = useBlockProps({
    className: classNames(`wpcd-coupon-wrapper wpcd-coupon-${template}`, {
      ["wpcd-coupon-hidden"]: hideCoupon && couponType !== "deal",
      ["wpcd-coupon-type-deal"]: couponType === "deal",
      "has-padding": !isValueEmpty(padding),
      "has-margin": !isValueEmpty(margin),
    }),
    style: generateStyles(wrapperStyles),
  });
  useEffect(() => {
    if (isEmpty(couponId) && hideCoupon) {
      setAttributes({ couponId: uniqueId().toString() });
    }
  }, [hideCoupon]);

  const onSelectImage = (media) => {
    if (media) {
      setAttributes({
        couponImage: media,
      });
    }
  };
  const onRemoveImage = () => {
    setAttributes({
      couponImage: {},
    });
  };
  const imageUrl = attributes.couponImage?.url;
  const imageId = attributes.couponImage?.id;
  const shouldShowImageControl =
    template !== "template-default" && template !== "template-three";
  const templates = {
    "template-default": <DefaultTemplate {...props} />,
    "template-one": <TemplateOne {...props} />,
    "template-two": <TemplateTwo {...props} />,
    "template-three": <TemplateThree {...props} />,
    "template-six": <TemplateSix {...props} />,
    "template-seven": <TemplateSeven {...props} />,
    "template-nine": <TemplateNine {...props} />,
  };
  return (
    <>
      {shouldShowImageControl && (
        <BlockControls group="other">
          <MediaReplaceFlow
            mediaId={imageId}
            name={imageUrl ? "Replace Image" : "Select Image"}
            mediaUrl={imageUrl}
            allowedTypes={["image"]}
            accept="image/*"
            onSelect={onSelectImage}
            onSelectURL={(url) =>
              setAttributes({ imageUrl: url, imageId: null })
            }
          />
          {imageUrl && (
            <ToolbarButton label="Remove Image" onClick={onRemoveImage}>
              Remove Image
            </ToolbarButton>
          )}
        </BlockControls>
      )}
      <div {...blockProps}>{templates[template]}</div>
      <Inspector {...props} />
    </>
  );
}
export default Edit;
