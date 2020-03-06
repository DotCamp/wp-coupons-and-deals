<script>
/* eslint-disable no-param-reassign */

import BaseTemplate from './BaseTemplate';

export default {
  mixins: [BaseTemplate],
  data() {
    return {
      values: {
        'coupon-title': '.wpcd-coupon-five-title',
        'coupon-code-text': '.coupon-code-button',
        'discount-text': '.wpcd-coupon-five-discount-text',
        wpcd_description: '.wpcd-coupon-description',
        'deal-button-text': '.deal-code-button',
        'template-five-theme': [
          {
            element: '.wpcd-template-five-exp',
            format: (val, el) => {
              el.style.backgroundColor = val;
            },
          },
          {
            element: '.wpcd-template-five',
            format: (val, el) => {
              el.style.borderColor = val;
            },
          },
          {
            element: '.wpcd-template-five-btn',
            format: (val, el) => {
              el.style.borderColor = val;
            },
          },
          {
            element: '.wpcd-deal-code .wpcd-template-five-btn',
            format: (val, el) => {
              el.style.borderColor = val;
            },
          },
          {
            element: '.coupon-code-button',
            format: (val, el) => {
              el.style.color = val;
            },
          },
          {
            element: '.deal-code-button',
            format: (val, el) => {
              el.style.color = val;
            },
          },
          {
            element: '.square_wpcd',
            format: (val, el) => {
              el.style.backgroundColor = val;
            },
          },
          {
            element: '.rectangle_wpcd',
            format: (val, el) => {
              el.style.borderLeftColor = val;
            },
          },
        ],
        'expire-date': [
          {
            element: '.with-expiration1   .wpcd-coupon-five-expire-text',
            format: value => {
              return `${this.extras.strings.expire_text}${this.decodeDate(value)}`;
            },
          },
          {
            element: '.with-expiration1   .wpcd-coupon-five-expired',
            format: value => {
              return `${this.extras.strings.expired_text}${this.decodeDate(value)}`;
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.wpcd-template-five-exp': () => this.store['show-expiration'] === 'Show',
        '.without-expiration1': () =>
          this.store['show-expiration'] !== 'Hide' && this.store['expire-date'] === undefined,
        '.with-expiration1': () => this.store['expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.with-expiration1   .wpcd-coupon-five-expired': () =>
          this.store['expire-date'] !== undefined && Date.now() > this.toMilliSeconds(this.store['expire-date']),
        '.with-expiration1   .wpcd-coupon-five-expire': () =>
          this.store['expire-date'] !== undefined && Date.now() < this.toMilliSeconds(this.store['expire-date']),
      },
    };
  },
};
</script>
