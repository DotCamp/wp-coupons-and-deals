<template>
  <hide-box :heading="name" :force-show="show">
    <table class="wpcd-fs-table">
      <slot :row-fields="filterFields"></slot>
    </table>
  </hide-box>
</template>
<script>
import HideBox from './HideBox';

export default {
  props: {
    name: {
      type: String,
    },
    show: {
      type: Boolean,
      default: false,
    },
    optionsFields: {
      type: Array,
    },
    filter: {
      type: Function,
    },
  },
  components: { HideBox },
  computed: {
    filterFields() {
      return this.optionsFields.filter(this.filter);
    },
  },
};
</script>
