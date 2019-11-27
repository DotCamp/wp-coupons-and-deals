<template>
  <label :for="id">
    <slot></slot>
    <help-box v-if="helpmessage" :message="helpmessage">?</help-box>
  </label>
</template>
<script>
import HelpBox from './HelpBox';

export default {
  components: { HelpBox },
  props: ['id', 'helpmessage'],
};
</script>
