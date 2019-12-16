<template>
  <div>
    <term-holder
      class="wpcd-fs-term-holder"
      heading="Coupon Categories"
      taxname="wpcd_coupon_category"
      :terms="taxonomies['wpcd_coupon_category']"
      :termsChecked="store.terms? store.terms['wpcd_coupon_category'] || [] : []"
      @termsChanged="updateTerms"
    />
    <term-holder
      class="wpcd-fs-term-holder"
      heading="Coupon Vendors"
      taxname="wpcd_coupon_vendor"
      :terms="taxonomies['wpcd_coupon_vendor']"
      :termsChecked="store.terms? store.terms['wpcd_coupon_vendor'] || [] : []"
      @termsChanged="updateTerms"
    />
  </div>
</template>
<script>
import TermHolder from './TermHolder';

export default {
  components: { TermHolder },
  props: ['taxonomies'],
  data() {
    return {
      allTerms: {},
    };
  },
  methods: {
    updateTerms(taxName, terms) {
      this.allTerms[taxName] = terms;
      this.store.terms = this.allTerms;
    },
  },
};
</script>
