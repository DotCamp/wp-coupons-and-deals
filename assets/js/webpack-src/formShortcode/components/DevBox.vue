<template>
  <div
    v-if="isDev"
    class="flex bg-gray-400 items-center flex-col m-4 border border-dashed border-black fixed left-0"
    style="top: 50%"
  >
    <div class="m-2 text-sm p-2 bg-gray-200 border border-gray" v-if="showSampleField">
      <span class="font-bold">Fields: </span>{{ preview.Default }}
    </div>
    <button @click="showSampleField = !showSampleField" class="text-sm p-2 text-white">
      {{ showSampleField ? 'hide' : 'show' }} Dev Box
    </button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      showSampleField: false,
      preview: couponPreview,
    };
  },
  computed: {
    isDev() {
      return process.env.NODE_ENV === 'development';
    },
  },
};
</script>
