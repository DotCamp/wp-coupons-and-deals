<template>
  <div class="text-gray-700">
    <coupon-preview></coupon-preview>
    <div
      class="overflow-scroll flex items-center flex-col bg-gray-100 border-t-4 border-l-4 shadow-lg rounded p-4"
      style="height: 500px"
    >
      <div class="text-4xl font-bold bg-gray-200 p-2 rounded shadow">Coupon Submit Form</div>
      <dev-box></dev-box>
      <form id="form-shortcode-form-wrapper" @submit.prevent="submitForm" method="post">
        <table class="border-collapse border-2 border-dashed w-full">
          <coupon-type v-model="store['coupon-type']" :typedata="couponType"></coupon-type>
          <coupon-title helpmessage="enter coupon title" id="coupon-title" label="Coupon Title"></coupon-title>
          <tr is="CouponTypeForm" :fieldsdata="parsedFields"></tr>
        </table>

        <input type="submit" value="Submit" />
      </form>
    </div>
  </div>
</template>
<script>
import CouponType from './CouponType';
import CouponTypeForm from './CouponTypeForm';
import CouponPreview from './CouponPreview';
import CouponTitle from './CouponTitle';
import DevBox from './DevBox';

export default {
  props: ['fields'],
  components: { CouponTitle, CouponType, CouponTypeForm, CouponPreview, DevBox },
  data() {
    return {
      showSampleField: false,
      couponType: this.fields.filter(f => f.id === 'coupon-type')[0],
    };
  },
  methods: {
    submitForm() {
      return this.resource
        .save({ action: 'wpcd_form' })
        .then(resp => resp.json())
        .then(j => console.log(j));
    },
  },
  computed: {
    parsedFields() {
      /**
       * function to filter fields according to supplied filters
       *
       * will be using this function to differentiate fields based on coupon type
       * each coupon type will gonna display the fields that is returned from this function
       * @param main array main data object to be filtered
       * @param filters array filter array with string and regex values
       * @returns {*} array filtered array of fields
       */
      function filterFields(main, filters) {
        return main.filter(m => {
          // eslint-disable-next-line consistent-return
          return filters.filter(f => {
            if (m.id.match(f) !== null) {
              return m;
            }
          })[0];
        });
      }

      // Image type fields
      const imageFilters = [/^link$/, /coupon-image.+/];
      const imageFields = filterFields(this.fields, imageFilters);

      // Coupon type fields
      const couponFilters = [
        'link',
        'coupon-code-text',
        'deal-button-text',
        'discount-text',
        'wpcd_description',
        'show-expiration',
        'expire-date',
        'expire-time',
        'show-expiration',
        'hide-coupon',
        'coupon-template',
        'never-expire-check',
        /.*-theme$/,
      ];
      const couponFields = filterFields(this.fields, couponFilters);

      // Deal type fields
      const dealFilters = [
        'link',
        'deal-button-text',
        'discount-text',
        'wpcd_description',
        'show-expiration',
        'expire-date',
        'expire-time',
        'show-expiration',
        'coupon-template',
        'never-expire-check',
        /.*-theme$/,
      ];
      const dealFields = filterFields(this.fields, dealFilters);

      const finalFields = {
        Image: imageFields,
        Coupon: couponFields,
        Deal: dealFields,
      };

      return finalFields[this.store['coupon-type']];
    },
  },
};
</script>
