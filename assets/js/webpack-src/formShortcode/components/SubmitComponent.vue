<template>
  <div class="wpcd-fs-flex wpcd-fs-items-center">
    <input class="button" ref="submitButton" type="submit" :value="extras.strings[store.ID?'update':'submit']" @click="$emit('submit')" />
    <wait-block v-if="isFetching" />
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
import WaitBlock from './WaitBlock';

export default {
  props: ['message'],
  components: { WaitBlock },
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
