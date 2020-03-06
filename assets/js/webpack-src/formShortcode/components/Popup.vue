<template>
  <transition name="wpcd-fs-popup">
    <div v-show="show" class="wpcd-fs-tooltip wpcd-fs-flex wpcd-fs-justify-center">
      {{ message }}
      <span class="wpcd-fs-tooltip-pointer" />
    </div>
  </transition>
</template>
<script>
export default {
  name: 'popup',
  props: ['message', 'show'],
};
</script>
