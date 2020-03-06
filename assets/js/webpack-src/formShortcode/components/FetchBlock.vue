<template>
  <div v-if="show" class="wpcd-fs-coupons-fetching">
    <div
      class="wpcd-fs-flex wpcd-fs-items-center wpcd-fs-justify-center wpcd-fs-w-full-important wpcd-fs-h-full-important"
    >
      <wait-block />
    </div>
  </div>
</template>
<script>
import WaitBlock from './WaitBlock';

export default {
  components: { WaitBlock },
  props: ['show'],
};
</script>
