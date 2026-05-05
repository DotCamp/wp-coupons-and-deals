class UBCoupon {
  constructor(wrapper) {
    this.wrapper = wrapper;
    this.expirationDateWrapper = this.wrapper.querySelector(
      ".wpcd-coupon-expiration-date"
    );
    this.copyButton = this.wrapper.querySelector(
      ".wpcd-coupon-button:not(.wpcd-popup-button)"
    );
    this.showCodeButton = this.wrapper.querySelector(
      ".wpcd-coupon-button.wpcd-popup-button"
    );

    this.expirationDate = new Date(
      this.wrapper.dataset.expiration_date
    ).getTime();
    this.expiredDateText = this.wrapper.dataset.expired_date_text;
    this.couponCode = this.wrapper.dataset.coupon_code;
    this.couponId = this.wrapper.getAttribute("data-coupon_id");
    this.init();
  }

  init() {
    this.checkExpirationDate();
    this.setupCopyButton();
    this.handleTemplateTwoExpirationDate();
    if (
      this.wrapper.classList.contains("wpcd-coupon-hidden") &&
      this.showCodeButton
    ) {
      if (this.wasRecentlyRevealed()) {
        this.revealCouponInline(false);
      } else {
        this.handleShowCode();
      }
    }
  }

  handleTemplateTwoExpirationDate() {
    if (
      !this.wrapper.classList.contains("wpcd-coupon-template-two") &&
      !this.wrapper.classList.contains("wpcd-coupon-template-seven") &&
      !this.wrapper.classList.contains("wpcd-coupon-template-six")
    ) {
      return;
    }

    if (
      this.expirationDateWrapper.classList.contains(
        "wpcd-coupon-does-not-expire"
      )
    ) {
      return;
    }

    const secondSpan = this.expirationDateWrapper.querySelectorAll("span")[1];
    if (!secondSpan) return;

    const updateCountdown = () => {
      const now = new Date().getTime();
      const distance = this.expirationDate - now;

      if (distance < 0) {
        secondSpan.textContent = this.expiredDateText;
        return;
      }

      const weeks = Math.floor(distance / (1000 * 60 * 60 * 24 * 7));
      const days = Math.floor(
        (distance % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24)
      );
      const hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      secondSpan.textContent = `${weeks} weeks ${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
    };

    updateCountdown();
    setInterval(updateCountdown, 1000);
  }

  wasRecentlyRevealed() {
    try {
      const revealed = JSON.parse(
        localStorage.getItem("wpcd_revealed") || "{}"
      );
      const timestamp = revealed[this.couponId];
      if (!timestamp) return false;
      return Date.now() - timestamp < 30 * 60 * 1000;
    } catch (e) {
      return false;
    }
  }

  markCouponAsRevealed() {
    try {
      const revealed = JSON.parse(
        localStorage.getItem("wpcd_revealed") || "{}"
      );
      revealed[this.couponId] = Date.now();
      localStorage.setItem("wpcd_revealed", JSON.stringify(revealed));
    } catch (e) {}
  }

  handleShowCode() {
    this.showCodeButton.addEventListener("click", (e) => {
      e.preventDefault();
      const navigationLink = this.showCodeButton.getAttribute("href");
      this.copyToClipboard();
      this.markCouponAsRevealed();
      this.revealCouponInline(true);
      if (navigationLink) {
        const a = document.createElement("a");
        a.href = navigationLink;
        a.rel = "nofollow noopener";
        a.target = "_blank";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
      }
    }, { once: true });
  }

  revealCouponInline(showCopied) {
    this.wrapper.classList.remove("wpcd-coupon-hidden");
    this.showCodeButton.classList.remove("wpcd-popup-button");
    this.showCodeButton.setAttribute("rel", "nofollow noopener");
    this.showCodeButton.setAttribute("target", "_blank");
    this.copyButton = this.showCodeButton;
    this.showCodeButton = null;

    if (showCopied) {
      this.copyButton.innerText = "Copied!";
      setTimeout(() => {
        this.copyButton.innerText = this.couponCode;
        this.setupCopyButton();
      }, 1000);
    } else {
      this.setupCopyButton();
    }
  }

  checkExpirationDate() {
    if (
      this.expirationDateWrapper.classList.contains(
        "wpcd-coupon-does-not-expire"
      )
    ) {
      return;
    }
    const currentDate = Date.now();
    const isDateExpired = currentDate > this.expirationDate;

    if (isDateExpired) {
      this.expirationDateWrapper.textContent = this.expiredDateText;
      this.expirationDateWrapper.classList.add("wpcd-coupon-expired");
    }
  }

  setupCopyButton() {
    if (!this.copyButton) return;
    const copyButtonText = this.copyButton.innerText;
    this.copyButton.addEventListener("click", () => {
      this.copyButton.innerText = "Copied!";
      this.copyToClipboard();
      setTimeout(() => {
        this.copyButton.innerText = copyButtonText.trim();
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
    ".wpcd-coupon-wrapper:not(.wpcd-coupon-type-deal)"
  );
  couponWrappers.forEach((wrapper) => {
    new UBCoupon(wrapper);
  });
});
