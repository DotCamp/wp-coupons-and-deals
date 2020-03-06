<script>
import BaseTemplate from './BaseTemplate';
import { decodeDate, toMilliSeconds } from '../../functions/EzTime';

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
        'deal-button-text': '.deal-code-button',
        'expire-date': [
          {
            element: '.with-expiration1 > .wpcd-coupon-expire',
            format: value => {
              return `${this.extras.strings.expire_text}${decodeDate(value)}`;
            },
          },
          {
            element: '.with-expiration1 > .wpcd-coupon-expired',
            format: value => {
              return `${this.extras.strings.expired_text}${decodeDate(value)}`;
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.without-expiration1': () =>
          this.store['show-expiration'] !== 'Hide' && this.store['expire-date'] === undefined,
        '.with-expiration1': () => this.store['expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.with-expiration1 > .wpcd-coupon-expired': () =>
          this.store['expire-date'] !== undefined && Date.now() > toMilliSeconds(this.store['expire-date']),
        '.with-expiration1 > .wpcd-coupon-expire': () =>
          this.store['expire-date'] !== undefined && Date.now() < toMilliSeconds(this.store['expire-date']),
      },
    };
  },
};
</script>
