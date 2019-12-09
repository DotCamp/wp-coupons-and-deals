<template>
  <div class="checkerboard" style="height: 200px">
    <img
      @error="showImage = false"
      @load="showImage = true"
      class="object-contain w-full"
      style="height: 200px"
      v-show="showImage"
      ref="previewImage"
      :src="store['coupon-image-input'] || ''"
      alt="image source"
    />
    <div v-if="!showImage" class="flex flex-col w-full h-full items-center justify-center">
      <div class="text-gray-600 bg-white p-4 rounded border shadow">{{ extras.strings['select_an_image'] }}</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showImage: true,
    };
  },
};
</script>
