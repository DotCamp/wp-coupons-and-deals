<template>
  <div class="bg-gray-200 w-full">
    <div id="preview_wrap" v-html="preview"></div>
  </div>
</template>
<script>
/* eslint-disable no-return-assign,no-param-reassign */

export default {
  data() {
    return {
      preview: couponPreview,
    };
  },
  mounted() {
    // TODO [task-001][erdembircan] remove for production, must have wrote a better parser to differentiate different templates
    const previewElements = Array.from(document.querySelectorAll('.wpcd-coupon-preview'));
    previewElements.map(el => (el.style.display = 'none'));

    // TODO [task-001][erdembircan] remove for production, must have wrote a better parser to differentiate different templates
    document.querySelector('#preview_wrap > p').style.display = 'none';

    // TODO [task-001][erdembircan] remove for production and be sure you overridden any 'button' style
    Array.from(document.querySelector('#preview_wrap').querySelectorAll('button')).map(
      el => (el.style.display = 'none')
    );

    // TODO [task-001][erdembircan] remove for production, must have wrote a better parser to differentiate different templates
    document.querySelector('.admin_wpcd_seven').style.display = 'none';

    // TODO [task-001][erdembircan] remove for production, must have wrote a better parser to differentiate different templates
    document.querySelector('.wpcd-coupon-default').style.display = '';
  },
};
</script>
