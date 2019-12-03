<script>
import BaseTemplate from './BaseTemplate';

export default {
  extends: BaseTemplate,
  data() {
    return {
      values: {
        'coupon-title': '.wpcd-coupon-three-title',
        'coupon-code-text': '.coupon-code-button',
        wpcd_description: '.wpcd-coupon-description',
        'deal-button-text': '.deal-code-button',
        'expire-date': [
          {
            element: '.wpcd-coupon-three-expire-text',
            format: value => {
              return `${this.extras.strings.expire_text}${value}`;
            },
          },
          {
            element: '.wpcd-coupon-three-expired',
            format: value => {
              return `${this.extras.strings.expired_text}${value}`;
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.wpcd-coupon-three-info-left': () => this.store['show-expiration'] === 'Show',
        '.without-expiration1': () =>
          this.store['show-expiration'] === 'Hide' || this.store['expire-date'] === undefined,
        '.with-expiration1': () => this.store['expire-date'] !== undefined && this.store['show-expiration'] === 'Show',
        '.wpcd-coupon-three-expired': () =>
          this.store['expire-date'] !== undefined && Date.now() > new Date(this.store['expire-date']),
        '.with-expiration1 > .wpcd-coupon-three-expire': () =>
          this.store['expire-date'] !== undefined && Date.now() < new Date(this.store['expire-date']),
      },
    };
  },
};
</script>
