<template>
  <div class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade">
    <message type="all" />
    <button v-show="current !== 'CouponForm'" @click="$emit('addNew')">
      {{ extras.strings.add_new }}
    </button>
    <div class="wpcd-fs-mt-2 wpcd-fs-dynamic-border wpcd-fs-dynamic-bg wpcd-fs-p-4 wpcd-fs-rounded wpcd-fs-shadow">
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
          :shortcode="extras.options.shortcode"
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
import Message from './Message';
import MessageMixin from './mixins/MessageMixin';
import HighlightMixin from './mixins/HighlightMixin';

export default {
  mixins: [MessageMixin, HighlightMixin],
  components: { Message, UserCouponRow, Pagination, WaitBlock, ColumnSort },
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
      this.findPageNumber(this.app.latest.id);
    });
  },
  methods: {
    findPageNumber(id) {
      let index = -1;
      this.coupons.map((c, i) => {
        const parsedID = Number.parseInt(c.ID, 10);

        if (parsedID === id) {
          index = i;
        }
      });

      // id not found, exit
      if (index < 0) {
        return;
      }

      // calculate the position of index in current pagination system
      this.current = Math.floor(index / this.itemsPerPage) + 1;
    },
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
          action: this.extras.options.coupons_action,
          nonce: this.extras.options.nonce,
          coupons: 'all',
        })
        .then(
          resp => resp.json(),
          resp => {
            this.setMessage(resp.message, this.messageTypes.error);
          }
        )
        .then(r => {
          if (r.error) {
            throw new Error(r.error);
          }
          this.$set(this, 'coupons', r.data);
        })
        .catch(e => {
          this.setMessage(e.message, this.messageTypes.error);
        })
        .finally(() => {
          this.stopFetching();
        });
    },
    getCoupon(id) {
      this.startFetching();
      return this.resource
        .get({
          action: this.extras.options.coupons_action,
          nonce: this.extras.options.nonce,
          coupons: 'single',
          coupon_id: id,
        })
        .then(
          resp => resp.json(),
          resp => {
            this.setMessage(resp.message, this.messageTypes.error);
          }
        )
        .then(r => {
          if (r.error) {
            throw new Error(r.error);
          }
          return r.data;
        })
        .catch(e => {
          this.setMessage(e.message, this.messageTypes.error);
        })
        .finally(() => {
          this.stopFetching();
        });
    },
    deleteCoupon(id) {
      this.startFetching();
      return this.resource
        .get({
          action: this.extras.options.coupons_action,
          nonce: this.extras.options.nonce,
          coupons: 'thrash',
          coupon_id: id,
        })
        .then(
          resp => resp.json(),
          resp => {
            this.setMessage(resp.message, this.messageTypes.error);
          }
        )
        .then(r => {
          if (r.error) {
            throw new Error(r.error);
          }
          this.setMessage(`${r.message} | id:${r.id}`);
          this.getAllUserCoupons();
        })
        .catch(e => {
          this.setMessage(e.message, this.messageTypes.error);
        })
        .finally(() => {
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
  beforeDestroy() {
    // reset highlight data
    this.resetHighlight();
  },
};
</script>
