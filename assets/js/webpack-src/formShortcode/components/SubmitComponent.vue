<template>
  <div class="wpcd-fs-flex wpcd-fs-items-center">
    <input class="button" ref="submitButton" type="submit" :value="extras.strings.submit" @click="$emit('submit')" />
    <div v-if="app.submit.fetching" class="wpcd-fs-wait-block-wrapper">
      <div class="wpcd-fs-wait-block"></div>
      <div class="wpcd-fs-wait-block"></div>
      <div class="wpcd-fs-wait-block"></div>
    </div>
    <div
      v-if="!app.submit.fetching && app.submit.isSuccess && message !== ''"
      class="wpcd-success-message-box wpcd-fs-basic-fade"
    >
      {{ message }}
    </div>
    <div v-if="!app.submit.fetching && !app.submit.isSuccess" class="wpcd-error-message-box wpcd-fs-basic-fade">
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
