<template>
  <div class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade">
    <div>
      <table class="wpcd-fs-w-full-important wpcd-fs-table wpcd-fs-zebra-table" style="margin-bottom: 0">
        <tr>
          <column-sort :heading="extras.strings.coupon_title" col-name="coupon_title" @sort="sort" />
          <column-sort :heading="extras.strings.coupon_type" col-name="coupon_type" @sort="sort" />
          <column-sort heading="Category" col-name="terms['category']" @sort="sort" />
          <column-sort heading="Vendor" col-name="terms['vendor']" @sort="sort" />
          <column-sort :heading="extras.strings.expires_on" col-name="expire_date" @sort="sort" />
          <th>Shortcode</th>
        </tr>
        <user-coupon-row
          v-for="c in currentPageCoupons"
          :key="c['ID']"
          :post_title="c['post_title']"
          :post_status="c['post_status']"
          :coupon_type="c['coupon_type']"
          :terms="c['terms']"
          :ID="c['ID']"
          :shortcode="extras.shortcode"
          :expire="c['expire_date']"
          @edit="editCoupon"
          @thrash="deleteCoupon"
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
    <pagination
      class="wpcd-fs-float-right"
      v-model="current"
      :max="coupons.length"
      min="1"
      :itemperpage="itemsPerPage"
    />
  </div>
</template>
<script>
import UserCouponRow from './UserCouponRow';
import Pagination from './Pagination';
import WaitBlock from './WaitBlock';
import ColumnSort from './ColumnSort';

export default {
  components: { UserCouponRow, Pagination, WaitBlock, ColumnSort },
  data() {
    return {
      current: 1,
      itemsPerPage: 5,
      coupons: [],
    };
  },
  mounted() {
    this.getAllUserCoupons().then(() => {
      this.sort('ID', 'DESC');
    });
  },
  methods: {
    sort(colName, sortOrder) {
      this.getAllUserCoupons().then(() => {
        this.coupons.sort((a, b) => {
          return (a[colName] > b[colName] ? 1 : -1) * (sortOrder === 'ASC' ? 1 : -1);
        });
      });
    },
    getAllUserCoupons() {
      this.startFetching();
      return this.resource
        .get({
          action: this.extras.coupons_action,
          nonce: this.extras.nonce,
          coupons: 'all',
        })
        .then(resp => resp.json())
        .then(r => {
          this.$set(this, 'coupons', r.data);
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
    deleteCoupon(id) {
      this.startFetching();
      return this.resource
        .get({
          action: this.extras.coupons_action,
          nonce: this.extras.nonce,
          coupons: 'thrash',
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
          if (!r.error) {
            this.getAllUserCoupons();
          }
        })
        .catch(() => {
          this.stopFetching();
        });
    },
    editCoupon(id) {
      this.getCoupon(id).then(r => {
        this.resetStore();
        // Object.assign(this.store, r);
        Object.keys(r).map(key => {
          if (Object.prototype.hasOwnProperty.call(r, key)) {
            this.$set(this.store, key, r[key]);
          }
        });

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
