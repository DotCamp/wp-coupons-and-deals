class UBCoupon {
  constructor(wrapper) {
    this.wrapper = wrapper;
    this.expirationDateWrapper = this.wrapper.querySelector(
      ".ub-coupon-expiration-date"
    );
    this.copyButton = this.wrapper.querySelector(
      ".ub-coupon-button:not(.ub-popup-button)"
    );
    this.showCodeButton = this.wrapper.querySelector(
      ".ub-coupon-button.ub-popup-button"
    );

    this.expirationDate = new Date(
      this.wrapper.dataset.expiration_date
    ).getTime();
    this.expiredDateText = this.wrapper.dataset.expired_date_text;
    this.couponCode = this.wrapper.dataset.coupon_code;
    this.init();
  }

  init() {
    this.checkExpirationDate();
    this.setupCopyButton();
    this.handleHiddenCoupon();
    const url = new URL(location);
    const couponIdParam = url?.searchParams?.get("ub_coupon");
    if (
      this.wrapper.classList.contains("ub-coupon-hidden") &&
      this.showCodeButton &&
      !couponIdParam
    ) {
      this.handleShowCode();
    }
  }
  handleShowCode() {
    this.showCodeButton.addEventListener("click", () => {
      const couponId = this.wrapper.getAttribute("data-coupon_id");
      const url = new URL(location);
      url.searchParams.set("ub_coupon", couponId);
      window.open(url, "_blank");
    });
  }

  handleHiddenCoupon() {
    if (!this.wrapper.classList.contains("ub-coupon-hidden")) {
      return;
    }
    const url = new URL(location);
    const couponId = url?.searchParams?.get("ub_coupon");
    if (!couponId || couponId === "null") {
      return;
    }
    const couponPopup = document.getElementById(couponId);
    const couponTargetButton = this.wrapper.querySelector(
      ".ub-coupon-button.ub-popup-button"
    );
    couponTargetButton.removeAttribute("href");

    couponTargetButton.classList.add("ub-coupon-popup-opened");

    couponPopup.style.display = "block";
    const closeButton = couponPopup.querySelector(
      ".ub-coupon-popup-close-button"
    );
    closeButton.addEventListener("click", () => {
      couponPopup.style.display = "none";
    });
  }

  checkExpirationDate() {
    const currentDate = Date.now();
    const isDateExpired = currentDate > this.expirationDate;

    if (isDateExpired) {
      this.expirationDateWrapper.textContent = this.expiredDateText;
      this.expirationDateWrapper.classList.add("ub-coupon-expired");
    }
  }
  setupCopyButton() {
    const copyButtonText = this.copyButton.innerText;
    this.copyButton.addEventListener("click", () => {
      this.copyButton.innerText = "Copied!";
      this.copyToClipboard();
      setTimeout(() => {
        this.copyButton.innerText = copyButtonText;
      }, 1000);
    });
  }

  async copyToClipboard() {
    const temporaryInput = document.createElement("input");
    temporaryInput.value = this.couponCode;
    temporaryInput.type = "text";
    document.body.appendChild(temporaryInput);
    temporaryInput.select();
    document.execCommand("Copy");
    document.body.removeChild(temporaryInput);
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const couponWrappers = document.querySelectorAll(
    ".ub-coupon-wrapper:not(.ub-coupon-type-deal)"
  );
  couponWrappers.forEach((wrapper) => {
    new UBCoupon(wrapper);
  });
});
