<script>
import BaseTemplate from './BaseTemplate';

export default {
  extends: BaseTemplate,
  data() {
    return {
      values: {
        wpcd_description: '.wpcd-coupon-description',
        'discount-text': '.wpcd-coupon-discount-text',
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes' && this.store['coupon-type'] !== 'Deal',
        '.wpcd-deal-code': () => this.store['coupon-type'] === 'Deal',
      },
    };
  },
};
</script>
