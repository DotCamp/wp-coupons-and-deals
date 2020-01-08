<template>
  <div>
    <div
      id="scrollMarker"
      title="Best WordPress Coupon Plugin For Bloggers and Affiliate Marketers."
      class="wpcd-fs-logo-wrapper wpcd-fs-flex wpcd-fs-flex-col wpcd-fs-justify-center wpcd-fs-items-center"
    >
      <h3 style="margin:5px">
        <a href="https://wpcouponsdeals.com/" target="_blank">
          WP Coupons and Deals
        </a>
      </h3>
    </div>
    <div>
      <h2 style="margin-top: 2px">
        {{ heading | cap }}
      </h2>
      <!--      <button class="wpcd-fs-float-right" v-show="current !== 'CouponForm'" @click="addNew">-->
      <!--        {{ extras.strings.add_new }}-->
      <!--      </button>-->
    </div>
    <component @switch="switchComponent" :is="current" :fields="fields" @addNew="addNew" />
  </div>
</template>
<script>
import CouponForm from './CouponForm';
import UserCoupons from './UserCoupons';
import ScrollMixin from './mixins/ScrollMixin';

export default {
  mixins: [ScrollMixin],
  props: ['fields', 'coupons'],
  components: { CouponForm, UserCoupons },
  data() {
    return {
      current: '',
      defaultTag: 'UserCoupons',
      tabQueryKey: 'wpcd_fs_tab',
      paginationQueryKey: 'wpcd_fs_p',
      currentPagination: 0,
    };
  },
  watch: {
    current(n) {
      const tempUrl = new URL(window.location.href);
      tempUrl.searchParams.set(this.tabQueryKey, n);
      window.history.pushState('', '', tempUrl.toString());
    },
  },
  created() {
    this.assignTab(window.location.href, this.defaultTag);
    window.onpopstate = e => {
      this.assignTab(e.target.location.href, this.defaultTag);
    };
  },
  methods: {
    assignTab(url, defaultTab) {
      const urlObj = new URL(url);

      this.current = urlObj.searchParams.get(this.tabQueryKey) || defaultTab;
    },
    switchComponent(c) {
      this.current = c;
      this.scrollTo('scrollMarker');
    },
    addNew() {
      this.resetStore();
      this.switchComponent('CouponForm');
    },
  },
  computed: {
    heading() {
      let stringKey = '';

      switch (this.current) {
        case 'CouponForm':
          stringKey = this.store.ID ? 'edit' : 'add_a_coupon';
          break;
        case 'UserCoupons':
          stringKey = 'your_coupons';
          break;
        default:
          stringKey = 'your_coupons';
          break;
      }

      return this.extras.strings[stringKey];
    },
  },
};
</script>
