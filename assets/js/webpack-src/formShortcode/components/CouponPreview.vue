<template>
  <div class="wpcd-fs-mt-4 wpcd-preview-wrapper wpcd-fs-shadow wpcd-fs-border">
    <transition name="form-shortcode-preview" appear mode="out-in">
      <image-template v-if="store['coupon-type'] === 'Image'" />
      <component v-else class="wpcd-fs-px-4" :is="store['coupon-template'].replace(' ', '')" :html="currentTemplate" />
    </transition>
    <div class="wpcd-fs-text-sm wpcd-fs-note wpcd-fs-rounded wpcd-fs-border">
      <span class="wpcd-fs-bold">Note: </span>This is just to show how the coupon will look. Click to copy
      functionality, showing hidden coupon will not work here, but it will work on posts, pages where you put the
      shortcode.
    </div>
  </div>
</template>
<script>
import Default from './templates/Default';
import TemplateOne from './templates/TemplateOne';
import TemplateTwo from './templates/TemplateTwo';
import TemplateThree from './templates/TemplateThree';
import TemplateFour from './templates/TemplateFour';
import TemplateFive from './templates/TemplateFive';
import TemplateSix from './templates/TemplateSix';
import TemplateSeven from './templates/TemplateSeven';
import TemplateEight from './templates/TemplateEight';
import ImageTemplate from './templates/ImageTemplate';

export default {
  data() {
    return {
      previews: couponPreview,
    };
  },
  components: {
    Default,
    TemplateOne,
    TemplateTwo,
    TemplateThree,
    TemplateFour,
    TemplateFive,
    TemplateSix,
    TemplateSeven,
    TemplateEight,
    ImageTemplate,
  },
  computed: {
    currentFile() {
      return this.store['coupon-template'].replace(' ', '');
    },
    currentTemplate() {
      // overriding 'show-expiration' so 'Expiration Date' will not be hidden at template changes
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      // this.store['show-expiration'] = 'Show';

      return this.previews[this.store['coupon-template']];
    },
  },
};
</script>
