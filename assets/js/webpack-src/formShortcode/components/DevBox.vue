<template>
  <div
    v-if="isDev"
    class="flex bg-gray-400 items-center flex-col m-4 border border-dashed border-black fixed top-0 left-0"
  >
    <div class="m-2 text-sm p-2 bg-gray-200 border border-gray" v-if="showSampleField">
      <span class="font-bold">Store: </span>{{ store }}
    </div>
    <div class="m-2 text-sm p-2 bg-gray-200 border border-gray" v-if="showSampleField">
      <span class="font-bold">Fields: </span>{{ fields }}
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
      fields: formShortcodeFields,
    };
  },
  computed: {
    isDev() {
      return process.env.NODE_ENV === 'development';
    },
  },
};
</script>
