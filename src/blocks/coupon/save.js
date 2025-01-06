/**
 * Wordpress Dependencies
 */
import { isEmpty } from "lodash";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import DefaultTemplate from "./templates/default-template/SaveDefaultTemplate";
import { getStyles } from "./get-styles";
import HiddenCouponTemplate from "./templates/hidden-coupon-template/HiddenCouponTemplate";
import classNames from "classnames";
import { getStyleClass } from "./get-classes";

function Save(props) {
  const { attributes } = props;
  const {
    template,
    expiredDateText,
    expirationDate,
    code,
    hideCoupon,
    couponId,
    couponType,
  } = attributes;

  const blockProps = useBlockProps.save({
    className: classNames(`ub-coupon-wrapper ub-coupon-${template}-template`, {
      ["ub-coupon-hidden"]: hideCoupon && couponType !== "deal",
      ["ub-coupon-type-deal"]: couponType === "deal",
    }),
    style: getStyles(attributes),
    "data-expired_date_text": expiredDateText,
    "data-expiration_date": expirationDate,
    "data-coupon_code": code,
    "data-coupon_id": couponId,
  });

  return (
    <div {...blockProps}>
      {template === "default" && <DefaultTemplate {...props} />}

      {hideCoupon && <HiddenCouponTemplate {...props} />}
    </div>
  );
}
export default Save;
