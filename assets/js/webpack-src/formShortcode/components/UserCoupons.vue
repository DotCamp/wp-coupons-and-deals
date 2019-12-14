<template>
  <div class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade">
    <table class="wpcd-fs-w-full-important wpcd-fs-table wpcd-fs-zebra-table">
      <tr>
        <th>{{ extras.strings.coupon_title | cap }}</th>
        <th>{{ extras.strings.coupon_type | cap }}</th>
        <th>ID</th>
      </tr>
      <user-coupon-row
        v-for="c in coupons"
        :key="c['ID']"
        :post_title="c['post_title']"
        :post_status="c['post_status']"
        :coupon_type="getCouponMeta(c, 'coupon-type')[0]"
        :ID="c['ID']"
      />
    </table>
  </div>
</template>
<script>
import UserCouponRow from './UserCouponRow';

export default {
  components: { UserCouponRow },
  props: ['coupons', 'meta_suffix', 'meta_key'],
  methods: {
    getCouponMeta(couponObject, metaKey) {
      return couponObject[this.meta_key][this.meta_suffix + metaKey];
    },
  },
};
</script>
