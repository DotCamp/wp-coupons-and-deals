<template>
  <span :title="message" class="wpcd-fs-helpbox wpcd-form-shortcode-generic-transition">
    <slot></slot>
  </span>
</template>
<script>
export default {
  props: ['message'],
};
</script>
