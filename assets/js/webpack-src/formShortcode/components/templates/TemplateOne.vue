<script>
import BaseTemplate from './BaseTemplate';

export default {
  extends: BaseTemplate,
  data() {
    return {
      values: {
        wpcd_description: '.wpcd-coupon-description',
        'discount-text': '.wpcd-coupon-one-discount-text',
      },
      toggleVisibility: {
        '.wpcd-coupon-code': () => this.store['hide-coupon'] === 'No',
        '.wpcd-coupon-hidden': () => this.store['hide-coupon'] === 'Yes',
        '.wpcd-deal-code': () => false,
      },
    };
  },
};
</script>
