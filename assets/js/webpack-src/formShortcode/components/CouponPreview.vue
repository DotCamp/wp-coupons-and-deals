<template>
  <div class="w-full overflow-x-hidden bg-gray-100 mb-4 border-t-4 border-l-4 rounded border shadow-lg">
    <div class="text-sm">{{ store }}</div>
    <transition name="form-shortcode-preview" appear mode="out-in">
      <component class="px-4" :is="store['coupon-template'].replace(' ', '')" :html="currentTemplate" />
    </transition>
    <div class="bg-white rounded border text-sm italic px-2 m-2 text-justify">
      <span class="font-bold">Note: </span>This is just to show how the coupon will look. Click to copy functionality,
      showing hidden coupon will not work here, but it will work on posts, pages where you put the shortcode.
    </div>
  </div>
</template>
<script>
import Default from './templates/Default';
import TemplateOne from './templates/TemplateOne';
import TemplateTwo from './templates/TemplateTwo';
import TemplateThree from './templates/TemplateThree';
import TemplateFour from './templates/TemplateFour';

export default {
  data() {
    return {
      previews: couponPreview,
    };
  },
  components: { Default, TemplateOne, TemplateTwo, TemplateThree, TemplateFour },
  computed: {
    currentTemplate() {
      // overriding 'show-expiration' so 'Expiration Date' will not be hidden at template changes
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.store['show-expiration'] = 'Show';

      return this.previews[this.store['coupon-template']];
    },
  },
};
</script>
