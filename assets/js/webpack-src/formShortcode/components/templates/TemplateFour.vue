<script>
import BaseTemplate from './BaseTemplate';

export default {
  mixins: [BaseTemplate],
  methods: {
    beforeParentMount() {
      const allCoupons = document.querySelectorAll('.wpcd-coupon-four-coupon');
      Array.from(allCoupons).map((el, i) => {
        el.classList.add(`wpcd-coupon-col-${i + 1}`);
      });
    },
  },
  data() {
    return {
      values: {
        'coupon-title': '.wpcd-coupon-four-title',
        'coupon-code-text': '.coupon-code-button',
        'second-coupon-code-text': '.wpcd-coupon-col-2 .coupon-code-button',
        'third-coupon-code-text': '.wpcd-coupon-col-3 .coupon-code-button',
        'discount-text': '.wpcd-four-discount-text',
        'second-discount-text': '.wpcd-coupon-col-2 .wpcd-four-discount-text',
        'third-discount-text': '.wpcd-coupon-col-3 .wpcd-four-discount-text',
        wpcd_description: '.wpcd-coupon-description',
        'deal-button-text': '.deal-code-button',
        'second-deal-button-text': '.wpcd-coupon-col-2 .deal-code-button',
        'third-deal-button-text': '.wpcd-coupon-col-3 .deal-code-button',
        'expire-date': [
          {
            element: '.with-expiration1  .wpcd-coupon-four-expire-text',
            format: value => {
              return `${this.extras.strings.expire_text}${this.decodeDate(value)}`;
            },
          },
          {
            element: '.with-expiration1  .wpcd-coupon-four-expired',
            format: value => {
              return `${this.extras.strings.expired_text}${this.decodeDate(value)}`;
            },
          },
        ],
        'second-expire-date': [
          {
            element: '.with-expiration-4-2  .wpcd-coupon-four-expire-text',
            format: value => {
              return `${this.extras.strings.expire_text}${this.decodeDate(value)}`;
            },
          },
          {
            element: '.with-expiration-4-2  .wpcd-coupon-four-expired',
            format: value => {
              return `${this.extras.strings.expired_text}${this.decodeDate(value)}`;
            },
          },
        ],
        'third-expire-date': [
          {
            element: '.with-expiration-4-3  .wpcd-coupon-four-expire-text',
            format: value => {
              return `${this.extras.strings.expire_text}${this.decodeDate(value)}`;
            },
          },
          {
            element: '.with-expiration-4-3  .wpcd-coupon-four-expired',
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
        '.wpcd-coupon-col-2 .wpcd-coupon-code': () =>
          this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-col-2 .wpcd-coupon-hidden': () =>
          this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-col-2 .wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.wpcd-coupon-col-3 .wpcd-coupon-code': () =>
          this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-col-3 .wpcd-coupon-hidden': () =>
          this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-col-3 .wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.without-expiration1': () =>
          this.store['show-expiration'] !== 'Hide' && this.store['expire-date'] === undefined,
        '.without-expiration-4-2': () =>
          this.store['show-expiration'] !== 'Hide' && this.store['second-expire-date'] === undefined,
        '.without-expiration-4-3': () =>
          this.store['show-expiration'] !== 'Hide' && this.store['third-expire-date'] === undefined,
        '.with-expiration1': () => this.store['expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.with-expiration-4-2': () =>
          this.store['second-expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.with-expiration-4-3': () =>
          this.store['third-expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.with-expiration1  .wpcd-coupon-four-expired': () =>
          this.store['expire-date'] !== undefined && Date.now() > this.toMilliSeconds(this.store['expire-date']),
        '.with-expiration1  .wpcd-coupon-four-expire': () =>
          this.store['expire-date'] !== undefined && Date.now() < this.toMilliSeconds(this.store['expire-date']),
        '.with-expiration-4-2  .wpcd-coupon-four-expired': () =>
          this.store['second-expire-date'] !== undefined &&
          Date.now() > this.toMilliSeconds(this.store['second-expire-date']),
        '.with-expiration-4-2 .wpcd-coupon-four-expire': () =>
          this.store['second-expire-date'] !== undefined &&
          Date.now() < this.toMilliSeconds(this.store['second-expire-date']),
        '.with-expiration-4-3  .wpcd-coupon-four-expired': () =>
          this.store['third-expire-date'] !== undefined &&
          Date.now() > this.toMilliSeconds(this.store['third-expire-date']),
        '.with-expiration-4-3 .wpcd-coupon-four-expire': () =>
          this.store['third-expire-date'] !== undefined &&
          Date.now() < this.toMilliSeconds(this.store['third-expire-date']),
      },
    };
  },
};
</script>
