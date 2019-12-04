<script>
/* eslint-disable no-param-reassign */

import BaseTemplate from './BaseTemplate';

export default {
  extends: BaseTemplate,
  data() {
    return {
      values: {
        wpcd_description: '.wpcd-coupon-description',
        'discount-text': '.wpcd-coupon-discount-text',
        'coupon-title': '.wpcd-coupon-title',
        'coupon-type': '.coupon-type',
        'coupon-code-text': '.coupon-code-button',
        'deal-button-text': '.admin-wpcd-new-goto-button',
        'expire-date': [
          {
            element: '.wpcd-coupon-three-expire-text .expiration-date',
            format: value => {
              return value;
            },
          },
          {
            element: '.wpcd-coupon-three-expired .expiration-date',
            format: value => {
              return value;
            },
          },
        ],
        'hide-coupon': [
          {
            element: '.wpcd-coupon-hidden',
            format: (value, el) => {
              el.style.display = value === 'Yes' ? 'block' : 'none';
            },
          },
        ],
        'template-eight-theme': [
          {
            element: '.coupon-type',
            format: (value, el) => {
              el.style.backgroundColor = value;
            },
          },
          {
            element: '.admin-wpcd-new-goto-button',
            format: (value, el) => {
              el.style.backgroundColor = value;
            },
          },
          {
            element: '.square_wpcd',
            format: (value, el) => {
              el.style.backgroundColor = value;
            },
          },
          {
            element: '.rectangle_wpcd',
            format: (value, el) => {
              el.style.borderLeftColor = value;
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        // '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.without-expiration1': () =>
          this.store['show-expiration'] !== 'Hide' && this.store['expire-date'] === undefined,
        '.with-expiration1': () => this.store['expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.with-expiration1 > .expired-text-block1': () =>
          this.store['expire-date'] !== undefined && Date.now() > new Date(this.store['expire-date']),
        '.with-expiration1 > .expire-text-block1': () =>
          this.store['expire-date'] !== undefined && Date.now() < new Date(this.store['expire-date']),
      },
    };
  },
};
</script>
