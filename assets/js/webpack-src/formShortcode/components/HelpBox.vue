<template>
  <span
    ref="tooltipWrapper"
    @mouseover="show = true"
    @mouseout="show = false"
    class="wpcd-fs-helpbox wpcd-form-shortcode-generic-transition wpcd-fs-pointer"
  >
    <transition name="wpcd-fs-popup">
      <div v-show="show" class="wpcd-fs-tooltip wpcd-fs-flex wpcd-fs-justify-center">
        {{ message }}
        <span class="wpcd-fs-tooltip-pointer" />
      </div>
    </transition>
    <slot />
  </span>
</template>
<script>
export default {
  props: ['message'],
  data() {
    return {
      show: false,
    };
  },
};
</script>
