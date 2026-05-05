import { __ } from "@wordpress/i18n";
import {
  createPortal,
  useState,
  useEffect,
  useCallback,
  useRef,
} from "@wordpress/element";
import { PRO_FEATURES, PROMO_CONFIG } from "./upsell-data";

const upsellIcon = (
  <svg
    width="18"
    height="18"
    viewBox="0 0 24 24"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M21.41 11.58L12.41 2.58C12.05 2.22 11.55 2 11 2H4C2.9 2 2 2.9 2 4V11C2 11.55 2.22 12.05 2.59 12.42L11.59 21.42C11.95 21.78 12.45 22 13 22C13.55 22 14.05 21.78 14.41 21.41L21.41 14.41C21.78 14.05 22 13.55 22 13C22 12.45 21.77 11.94 21.41 11.58ZM5.5 7C4.67 7 4 6.33 4 5.5C4 4.67 4.67 4 5.5 4C6.33 4 7 4.67 7 5.5C7 6.33 6.33 7 5.5 7Z"
      fill="currentColor"
    />
  </svg>
);

function execCommandCopy(text, onSuccess) {
  const el = document.createElement("textarea");
  el.value = text;
  el.style.cssText = "position:fixed;opacity:0;pointer-events:none;";
  document.body.appendChild(el);
  el.focus();
  el.select();
  try {
    if (document.execCommand("copy")) onSuccess();
  } catch (_) {}
  document.body.removeChild(el);
}

const ChevronLeft = () => (
  <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
  </svg>
);

const ChevronRight = () => (
  <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
  </svg>
);

const UPSELL_URL =
  WPCD_CFG?.UPSELL_URL || "https://wpcouponsdeals.com/pricing/";

function UpsellModal({ onClose, featureInfo }) {
  const { code: promoCode, text: promoText } = PROMO_CONFIG;
  const totalFeatures = PRO_FEATURES.length;

  const initialIndex = featureInfo
    ? PRO_FEATURES.findIndex((f) => f.name === featureInfo.name)
    : 0;

  const [activeIndex, setActiveIndex] = useState(
    initialIndex > -1 ? initialIndex : 0,
  );
  const [slideDirection, setSlideDirection] = useState("");
  const [slideKey, setSlideKey] = useState(0);
  const [copied, setCopied] = useState(false);
  const copyTimeoutRef = useRef(null);

  const handleCopyCode = useCallback(() => {
    if (!promoCode) return;
    const onSuccess = () => {
      setCopied(true);
      clearTimeout(copyTimeoutRef.current);
      copyTimeoutRef.current = setTimeout(() => setCopied(false), 2000);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard
        .writeText(promoCode)
        .then(onSuccess)
        .catch(() => execCommandCopy(promoCode, onSuccess));
    } else {
      execCommandCopy(promoCode, onSuccess);
    }
  }, [promoCode]);

  useEffect(() => () => clearTimeout(copyTimeoutRef.current), []);

  const goToPrev = useCallback(() => {
    setSlideDirection("slide-left");
    setSlideKey((k) => k + 1);
    setActiveIndex((prev) => (prev > 0 ? prev - 1 : totalFeatures - 1));
  }, [totalFeatures]);

  const goToNext = useCallback(() => {
    setSlideDirection("slide-right");
    setSlideKey((k) => k + 1);
    setActiveIndex((prev) => (prev < totalFeatures - 1 ? prev + 1 : 0));
  }, [totalFeatures]);

  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === "Escape") onClose();
      if (e.key === "ArrowLeft") goToPrev();
      if (e.key === "ArrowRight") goToNext();
    };
    document.addEventListener("keydown", handleKeyDown);
    return () => document.removeEventListener("keydown", handleKeyDown);
  }, [onClose, goToPrev, goToNext]);

  const currentFeature = PRO_FEATURES[activeIndex];

  return createPortal(
    <div className="wpcd-upsell-modal">
      <div className="wpcd-upsell-modal-backdrop" onClick={onClose}></div>

      <div className="wpcd-upsell-modal-outer">
        <button
          className="wpcd-upsell-nav wpcd-upsell-nav-prev"
          onClick={goToPrev}
          aria-label={__("Previous feature", "wp-coupons-and-deals")}
        >
          <ChevronLeft />
        </button>

        <div className="wpcd-upsell-modal-container">
          <div className="wpcd-upsell-modal-header">
            <span className="wpcd-upsell-modal-header-icon">{upsellIcon}</span>
            <span className="wpcd-upsell-modal-header-title">
              {currentFeature.title}
            </span>
          </div>

          <div className="wpcd-upsell-slide-wrapper">
            <div
              className={`wpcd-upsell-slide ${slideDirection}`}
              key={slideKey}
            >
              {currentFeature.image && (
                <img
                  className="wpcd-upsell-modal-image"
                  src={currentFeature.image}
                  alt={currentFeature.title}
                />
              )}
              {currentFeature.description && (
                <p className="wpcd-upsell-modal-description">
                  <strong>{currentFeature.title}</strong>{" "}
                  {currentFeature.description}
                </p>
              )}
              {promoCode && promoText && (
                <div className="wpcd-upsell-promo">
                  <span>{promoText}</span>
                  <button
                    className={`wpcd-upsell-promo-code${copied ? " is-copied" : ""}`}
                    onClick={handleCopyCode}
                    title={__("Click to copy", "wp-coupons-and-deals")}
                  >
                    <code>{promoCode}</code>
                    <span className="wpcd-upsell-promo-copy-label">
                      {copied
                        ? __("Copied!", "wp-coupons-and-deals")
                        : __("Copy", "wp-coupons-and-deals")}
                    </span>
                  </button>
                </div>
              )}
            </div>
          </div>

          <div className="wpcd-upsell-modal-footer">
            <button className="wpcd-upsell-modal-cancel" onClick={onClose}>
              {__("Cancel", "wp-coupons-and-deals")}
            </button>
            <a
              className="wpcd-upsell-modal-cta"
              href={UPSELL_URL}
              target="_blank"
              rel="noopener noreferrer"
            >
              {__("Get PRO", "wp-coupons-and-deals")}
            </a>
          </div>
        </div>

        <button
          className="wpcd-upsell-nav wpcd-upsell-nav-next"
          onClick={goToNext}
          aria-label={__("Next feature", "wp-coupons-and-deals")}
        >
          <ChevronRight />
        </button>
      </div>
    </div>,
    document.body,
  );
}

export default UpsellModal;
