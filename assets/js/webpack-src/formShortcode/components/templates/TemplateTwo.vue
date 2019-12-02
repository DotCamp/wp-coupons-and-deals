<script>
import BaseTemplate from './BaseTemplate';

export default {
  extends: BaseTemplate,
  mounted() {
    const expiresOn = document.querySelector('.expires-on');
    expiresOn.style = '';
    expiresOn.classList.add('hidden');
  },
  data() {
    return {
      values: {
        'coupon-title': '.wpcd-coupon-title',
        'coupon-code-text': '.coupon-code-button',
        'discount-text': '.wpcd-coupon-two-discount-text',
        wpcd_description: '.wpcd-coupon-description',
        'deal-button-text': '.deal-code-button',
        'expire-date': [
          {
            element: '.expires-on',
            format: (value, el) => {
              const expired = Date.now() > new Date(this.store['expire-date']);
              if (expired) {
                el.classList.add('wpcd-countdown-expired');
                el.classList.remove('wpcd-coupon-two-countdown');
              } else {
                el.classList.add('wpcd-coupon-two-countdown');
                el.classList.remove('wpcd-countdown-expired');
              }

              return `${this.extras.strings.expire_text}${expired ? this.extras.strings.offer_expired_text : ''}${
                expired ? '' : value
              }`;
            },
          },
        ],
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
        '.never-expire': () => this.store['never-expire-check'] === true || this.store['expire-date'] === undefined,
        '.expires-on': () =>
          this.store['never-expire-check'] === false || this.store['never-expire-check'] === undefined,
      },
    };
  },
};
</script>
