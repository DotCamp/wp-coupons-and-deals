<template>
  <div class="wpcd-fs-hide-box">
    <div
      @click="showChild = !showChild"
      class="wpcd-form-shortcode-generic-transition wpcd-fs-hide-box-header wpcd-fs-flex wpcd-fs-items-center wpcd-fs-space-between wpcd-fs-p-2"
    >
      {{ heading }}
      <div class="wpcd-fs-toggle-button" :aria-expanded="JSON.stringify(showChild)">
        <span class="wpcd-fs-toggle-indicator" />
      </div>
    </div>
    <div v-show="showChild" class="wpcd-fs-p-2 wpcd-fs-basic-fade">
      <slot />
    </div>
  </div>
</template>
<script>
export default {
  props: ['heading', 'forceShow'],
  data() {
    return {
      showChild: false,
    };
  },
  watch: {
    forceShow(n) {
      this.showChild = n;
    },
  },
};
</script>
