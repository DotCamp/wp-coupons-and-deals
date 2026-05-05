import { __ } from "@wordpress/i18n";
import templatesImage from "./images/templates.png";
import hideCouponImage from "./images/hide-coupon.png";

export const PROMO_CONFIG = {
  code: "",
  text: "",
};

export const PRO_FEATURES = [
  {
    name: "templates",
    title: __("Premium Templates", "wp-coupons-and-deals"),
    image: templatesImage,
    description: __(
      "unlock 9 additional coupon layouts — from affiliate promos to seasonal deals — without any custom code.",
      "wp-coupons-and-deals",
    ),
  },
  {
    name: "hide-coupon",
    title: __("Hidden Coupon Flow", "wp-coupons-and-deals"),
    image: hideCouponImage,
    description: __(
      "mask coupon codes on the frontend and reveal them in a popup that encourages clicks, copies, and conversions.",
      "wp-coupons-and-deals",
    ),
  },
];

export function getFeatureInfo(featureKey) {
  return PRO_FEATURES.find((f) => f.name === featureKey);
}

export function getUpsellFeature(featureKey) {
  return getFeatureInfo(featureKey) || PRO_FEATURES[0];
}
