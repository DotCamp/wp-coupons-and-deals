<template>
  <div class="checkerboard" style="height: 200px">
    <img
      @error="imageError"
      class="object-contain w-full"
      style="height: 200px"
      v-if="showImage"
      ref="previewImage"
      :src="imageSrc"
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
      imageSrc: '',
      showImage: true,
    };
  },
  methods: {
    imageError() {
      this.showImage = false;
    },
  },
  watch: {
    store: {
      handler() {
        if (this.store['coupon-image-input']) {
          const reader = new FileReader();
          reader.addEventListener('load', () => {
            const imageData = reader.result;
            this.showImage = true;
            this.imageSrc = imageData;
          });

          reader.readAsDataURL(this.store['coupon-image-input']);
        }
      },
      deep: true,
    },
  },
};
</script>
