<template>
  <span
    ref="tooltipWrapper"
    @mouseover="show = true"
    @mouseout="show = false"
    class="wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-items-center wpcd-fs-h-full-important wpcd-fs-helpbox wpcd-form-shortcode-generic-transition wpcd-fs-pointer"
  >
    <popup :message="message" :show="show" />
    <slot />
  </span>
</template>
<script>
import Popup from './Popup';

export default {
  components: { Popup },
  props: ['message'],
  data() {
    return {
      show: false,
    };
  },
};
</script>
