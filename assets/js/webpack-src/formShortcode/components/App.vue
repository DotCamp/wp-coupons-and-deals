<template>
  <div>
    <div>
      <h2>
        {{ heading | cap }}
      </h2>
      <button class="wpcd-fs-float-right" v-show="current !== 'CouponForm'" @click="addNew">
        {{ extras.strings.add_new }}
      </button>
    </div>
    <component
      @switch="switchComponent"
      :is="current"
      :fields="fields"
      :coupons="coupons"
      meta_suffix="coupon_details_"
      meta_key="post_meta"
    />
  </div>
</template>
<script>
import CouponForm from './CouponForm';
import UserCoupons from './UserCoupons';

export default {
  props: ['fields', 'coupons'],
  components: { CouponForm, UserCoupons },
  data() {
    return {
      current: 'UserCoupons',
    };
  },
  methods: {
    switchComponent(c) {
      this.current = c;
    },
    addNew() {
      this.current = 'CouponForm';
    },
  },
  computed: {
    heading() {
      let stringKey = '';

      switch (this.current) {
        case 'CouponForm':
          stringKey = 'add_a_coupon';
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
