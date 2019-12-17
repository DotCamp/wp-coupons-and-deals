<template>
  <div class="checkerboard" style="height: 200px">
    <img
      @error="showImage = false"
      @load="showImage = true"
      class="wpcd-fs-image-template wpcd-fs-w-full-important"
      style="height: 200px"
      v-show="showImage"
      ref="previewImage"
      :src="store['coupon-image-input']"
      alt="image source"
      :key="refreshKey"
    />
    <div
      v-if="!showImage"
      class="wpcd-fs-flex wpcd-fs-flex-col wpcd-fs-items-center wpcd-fs-justify-center wpcd-fs-w-full-important wpcd-fs-h-full-important"
    >
      <div class="wpcd-fs-shadow wpcd-fs-rounded wpcd-fs-bg-white wpcd-fs-p-4  wpcd-fs-border">
        {{ extras.strings['select_an_image'] }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showImage: false,
      refreshKey: 0,
    };
  },
  watch: {
    store: {
      handler() {
        this.refreshKey += 1;
      },
      deep: true,
    },
  },
};
</script>
