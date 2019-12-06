<template>
  <div class="flex items-center overflow-hidden">
    <input ref="submitButton" type="submit" :value="extras.strings.submit" />
    <div v-if="app.submit.fetching" class="inline-block wait-block-wrapper px-4">
      <div class="wait-block"></div>
      <div class="wait-block"></div>
      <div class="wait-block"></div>
    </div>
    <div
      v-if="!app.submit.fetching && app.submit.isSuccess && message !== ''"
      class="bg-white form-shortcode-row border-l-4 border-green-500 p-4 text-green-500"
    >
      {{ message }}
    </div>
    <div
      v-if="!app.submit.fetching && !app.submit.isSuccess"
      class="bg-white form-shortcode-row border-l-4 border-red-500 p-4 text-red-500"
    >
      {{ message }}
    </div>
  </div>
</template>
<script>
export default {
  props: ['message'],
  watch: {
    app: {
      handler(n) {
        this.$refs.submitButton.disabled = n.submit.fetching;
      },
      deep: true,
    },
  },
};
</script>
