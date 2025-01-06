function HiddenCouponTemplate(props) {
  const { attributes } = props;
  const {
    code,
    couponId,
    navigationLink,
    couponPopupCopyButtonText,
    couponPopupOfferText,
    title,
    description,
  } = attributes;

  return (
    <div id={couponId} className="ub-coupon-popup">
      <div className="ub-coupon-popup-inner_wrapper">
        <div className="ub-coupon-popup-header">
          <p className="ub-coupon-popup-title">{title}</p>
          <span className="ub-coupon-popup-close-button">×</span>
        </div>
        <div className="ub-coupon-popup-content">
          <p className="ub-coupon-popup-description">{description}</p>
          <div className="ub-coupon-popup-code-wrapper">
            <span className="ub-coupon-popup-code">{code}</span>
            <span className="ub-coupon-button">
              {couponPopupCopyButtonText}
            </span>
          </div>
          <a
            href={navigationLink}
            rel="nofollow noopener"
            target="_blank"
            className="ub-coupon-go-to-offer"
          >
            {couponPopupOfferText}
          </a>
        </div>
      </div>
    </div>
  );
}
export default HiddenCouponTemplate;
