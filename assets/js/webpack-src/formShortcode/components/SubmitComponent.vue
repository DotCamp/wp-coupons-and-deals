<template>
  <div class="wpcd-fs-flex wpcd-fs-items-center wpcd-fs-justify-center wpcd-fs-mt-2">
    <div class="wpcd-fs-relative">
      <input
        class="button"
        ref="submitButton"
        type="submit"
        :value="extras.strings[store.ID ? 'update' : 'submit']"
        @click="$emit('submit')"
      />
      <fetch-block :show="isFetching" />
    </div>
  </div>
</template>
<script>
import FetchBlock from './FetchBlock';

export default {
  props: ['message'],
  components: { FetchBlock },
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
