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
import { getStyleClass } from "./get-classes";
import { getStyles } from "./get-styles";
import classNames from "classnames";

function Edit(props) {
  const { attributes, setAttributes } = props;
  const { template, hideCoupon, couponId, couponType } = attributes;

  const blockProps = useBlockProps({
    className: classNames(`ub-coupon-wrapper ub-coupon-${template}-template`, {
      ["ub-coupon-hidden"]: hideCoupon && couponType !== "deal",
      ["ub-coupon-type-deal"]: couponType === "deal",
      ...getStyleClass(attributes),
    }),
    style: getStyles(attributes),
  });
  useEffect(() => {
    if (isEmpty(couponId) && hideCoupon) {
      setAttributes({ couponId: uniqueId().toString() });
    }
  }, [hideCoupon]);
  return (
    <>
      <div {...blockProps}>
        {template === "default" && <DefaultTemplate {...props} />}
      </div>
      <Inspector {...props} />
    </>
  );
}
export default Edit;
