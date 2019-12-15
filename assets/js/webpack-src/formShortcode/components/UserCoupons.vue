<template>
  <div class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade">
    <table class="wpcd-fs-w-full-important wpcd-fs-table wpcd-fs-zebra-table" style="margin-bottom: 0">
      <tr>
        <th>{{ extras.strings.coupon_title | cap }}</th>
        <th>{{ extras.strings.coupon_type | cap }}</th>
        <th>ID</th>
      </tr>
      <user-coupon-row
        v-for="c in currentPageCoupons"
        :key="c['ID']"
        :post_title="c['post_title']"
        :post_status="c['post_status']"
        :coupon_type="getCouponMeta(c, 'coupon-type')[0]"
        :ID="c['ID']"
      />
    </table>

    <div
      class="wpcd-fs-no-coupons wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-items-center"
      v-if="coupons.length === 0"
    >
      <div class="wpcd-fs-no-text">
        no coupons found...
      </div>
    </div>
    <pagination v-model="current" :max="coupons.length" min="1" :itemperpage="itemsPerPage" />
  </div>
</template>
<script>
import UserCouponRow from './UserCouponRow';
import Pagination from './Pagination';

export default {
  components: { UserCouponRow, Pagination },
  props: ['coupons', 'meta_suffix', 'meta_key'],
  data() {
    return {
      current: 1,
      itemsPerPage: 3,
    };
  },
  created() {
    this.resource
      .get({ action: this.extras.coupons_action })
      .then(resp => resp.json())
      .then(j => {
        console.log(j);
      });
  },
  methods: {
    getCouponMeta(couponObject, metaKey) {
      return couponObject[this.meta_key][this.meta_suffix + metaKey];
    },
  },
  computed: {
    currentPageCoupons() {
      const startIndex = (this.current - 1) * this.itemsPerPage;
      return this.coupons.slice(startIndex, startIndex + this.itemsPerPage);
    },
  },
};
</script>
