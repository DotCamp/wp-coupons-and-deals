<template>
  <div class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade">
    <div>
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
          :coupon_type="c['coupon_type']"
          :ID="c['ID']"
          @edit="editCoupon"
        />
      </table>

      <div
        class="wpcd-fs-no-coupons wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-items-center"
        style="position: relative"
        v-if="coupons.length === 0"
      >
        <div v-if="isFetching" class="wpcd-fs-coupons-fetching">
          <div
            class="wpcd-fs-flex wpcd-fs-items-center wpcd-fs-justify-center wpcd-fs-w-full-important wpcd-fs-h-full-important"
          >
            <wait-block />
          </div>
        </div>
        <div class="wpcd-fs-no-text">
          no coupons found...
        </div>
      </div>
    </div>
    <pagination v-model="current" :max="coupons.length" min="1" :itemperpage="itemsPerPage" />
  </div>
</template>
<script>
import UserCouponRow from './UserCouponRow';
import Pagination from './Pagination';
import WaitBlock from './WaitBlock';

export default {
  components: { UserCouponRow, Pagination, WaitBlock },
  data() {
    return {
      current: 1,
      itemsPerPage: 5,
      coupons: [],
    };
  },
  mounted() {
    this.getAllUserCoupons();
  },
  methods: {
    getAllUserCoupons() {
      this.startFetching();
      this.resource
        .get({
          action: this.extras.coupons_action,
          nonce: this.extras.nonce,
          coupons: 'all',
        })
        .then(resp => resp.json())
        .then(r => {
          // this.coupons = r.data;
          this.$set(
            this,
            'coupons',
            r.data.sort((a, b) => b.ID - a.ID)
          );
          this.stopFetching();
        });
    },
    getCoupon(id) {
      this.startFetching();
      return this.resource
        .get({
          action: this.extras.coupons_action,
          nonce: this.extras.nonce,
          coupons: 'single',
          coupon_id: id,
        })
        .then(
          resp => resp.json(),
          () => {
            this.stopFetching();
          }
        )
        .then(r => {
          this.stopFetching();
          return r.data;
        })
        .catch(() => {
          this.stopFetching();
        });
    },
    editCoupon(id) {
      this.getCoupon(id).then(r => {
        this.resetStore();
        Object.assign(this.store, r);
        this.$emit('switch', 'CouponForm');
      });
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
