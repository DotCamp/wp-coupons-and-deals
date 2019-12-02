<template>
  <div class="flex flex-row items-center">
    <input ref="submitButton" type="submit" value="Submit" />
    <div v-if="app.submit.fetching" class="inline-block wait-block-wrapper px-4">
      <div class="wait-block"></div>
      <div class="wait-block"></div>
      <div class="wait-block"></div>
    </div>
    <div v-if="!app.submit.fetching && app.submit.isSuccess" class="px-4 text-sm text-green-500">{{ message }}</div>
    <div v-if="!app.submit.fetching && !app.submit.isSuccess" class="px-4 text-sm text-red-500">{{ message }}</div>
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
