<template>
  <div class="wpcd-fs-overflow-hidden wpcd-fs-hide-box-wrapper">
    <div class="wpcd-fs-hide-box wpcd-fs-relative" style="z-index: 100">
      <div
        @click="showChild = !showChild"
        class="wpcd-form-shortcode-generic-transition wpcd-fs-hide-box-header wpcd-fs-flex wpcd-fs-items-center wpcd-fs-space-between wpcd-fs-p-2"
      >
        {{ heading | cap }}
        <div class="wpcd-fs-toggle-button" :aria-expanded="JSON.stringify(showChild)">
          <span class="wpcd-fs-toggle-indicator" />
        </div>
      </div>
    </div>
    <transition name="wpcd-fs-drawer">
      <div v-show="showChild" class="wpcd-fs-p-2 wpcd-fs-hide-box wpcd-fs-relative wpcd-fs-drawer-container">
        <slot />
      </div>
    </transition>
  </div>
</template>
<script>
export default {
  props: ['heading', 'forceShow'],
  data() {
    return {
      showChild: this.forceShow || false,
    };
  },
  watch: {
    forceShow(n) {
      this.showChild = n;
    },
  },
};
</script>
