<template>
  <div class="w-full overflow-x-hidden bg-gray-100 mb-4 border-t-4 border-l-4 rounded border shadow-lg">
    <div class="text-sm">{{ store }}</div>
    <transition name="form-shortcode-preview" appear mode="out-in">
      <component class="p-4" :is="store['coupon-template'].replace(' ', '')" :html="currentTemplate"></component>
    </transition>
    <div class="text-sm italic p-4 text-justify">
      <span class="font-bold">Note: </span>This is just to show how the coupon will look. Click to copy functionality,
      showing hidden coupon will not work here, but it will work on posts, pages where you put the shortcode.
    </div>
  </div>
</template>
<script>
import Default from './templates/Default';
import TemplateOne from './templates/TemplateOne';
import TemplateTwo from './templates/TemplateTwo';

export default {
  data() {
    return {
      previews: couponPreview,
    };
  },
  components: { Default, TemplateOne, TemplateTwo },
  computed: {
    currentTemplate() {
      return this.previews[this.store['coupon-template']];
    },
  },
};
</script>
