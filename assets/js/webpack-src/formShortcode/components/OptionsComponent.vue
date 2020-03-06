<template>
  <div id="form-shortcode-form-wrapper">
    <option-holder
      :filter="f => true"
      v-if="extras.options.split_form === 'full'"
      :name="extras.strings.options"
      :show="true"
      :options-fields="fields"
    >
      <template v-slot:default="{ rowFields }">
        <coupon-type v-model="store['coupon-type']" :typedata="couponTypeData" />
        <coupon-title helpmessage="enter coupon title" id="coupon-title" label="Coupon Title" />
        <coupon-type-form :fieldsdata="rowFields" />
      </template>
    </option-holder>

    <div v-else-if="extras.options.split_form === 'split'">
      <option-holder
        :filter="f => f.complexity === 'basic'"
        :name="extras.strings.basic_options"
        :show="true"
        :options-fields="fields"
      >
        <template v-slot:default="{ rowFields }">
          <coupon-type v-model="store['coupon-type']" :typedata="couponTypeData" />
          <coupon-title helpmessage="enter coupon title" id="coupon-title" label="Coupon Title" />
          <coupon-type-form :fieldsdata="rowFields" />
        </template>
      </option-holder>
      <option-holder
        :filter="f => f.complexity === undefined || f.complexity === 'advanced'"
        :name="extras.strings.advanced_options"
        :show="false"
        :options-fields="fields"
      >
        <template v-slot:default="{ rowFields }">
          <coupon-type-form :fieldsdata="rowFields" />
        </template>
      </option-holder>
    </div>
  </div>
</template>
<script>
import OptionHolder from './OptionHolder';
import CouponType from './CouponType';
import CouponTitle from './CouponTitle';
import CouponTypeForm from './CouponTypeForm';

export default {
  components: { CouponTypeForm, OptionHolder, CouponType, CouponTitle },
  props: ['fields', 'couponTypeData'],
};
</script>
