/**
 * Wordpress Dependencies
 */
import { uniqueId, isEmpty } from "lodash";
import { useBlockProps } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";

/**
 * Internal Dependencies
 */
import DefaultTemplate from "./templates/default-template/EditDefaultTemplate";
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

  const wrapperStyles = {
    backgroundColor: !isEmpty(attributes?.wrapperBackgroundColor)
      ? attributes.wrapperBackgroundColor
      : attributes?.wrapperGradientBackground,
    "padding-top": !isEmpty(paddingObj?.top) ? paddingObj?.top : "25px",
    "padding-right": !isEmpty(paddingObj?.right) ? paddingObj?.right : "25px",
    "padding-bottom": !isEmpty(paddingObj?.bottom)
      ? paddingObj?.bottom
      : "25px",
    "padding-left": !isEmpty(paddingObj?.left) ? paddingObj?.left : "25px",
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
      : "2px dashed #000000",
    borderLeft: !isValueEmpty(getSingleSideBorderValue(wrapperBorder, "left"))
      ? getSingleSideBorderValue(wrapperBorder, "left")
      : "2px dashed #000000",
    borderRight: !isValueEmpty(getSingleSideBorderValue(wrapperBorder, "right"))
      ? getSingleSideBorderValue(wrapperBorder, "right")
      : "2px dashed #000000",
    borderBottom: !isValueEmpty(
      getSingleSideBorderValue(wrapperBorder, "bottom")
    )
      ? getSingleSideBorderValue(wrapperBorder, "bottom")
      : "2px dashed #000000",
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
  return (
    <>
      <div {...blockProps}>
        {template === "template-default" && <DefaultTemplate {...props} />}
      </div>
      <Inspector {...props} />
    </>
  );
}
export default Edit;
