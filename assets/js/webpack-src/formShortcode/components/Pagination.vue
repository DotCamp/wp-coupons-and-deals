<template>
  <div v-if="pagMax != 1 && pagMax > 0" class="wpcd-fs-float-right">
    <button v-show="min != pagCurrent" @click.prevent="updatePag(-1)"><<</button>
    <div class="wpcd-fs-current-pagination">
      {{ pagCurrent }}
    </div>
    <button v-show="pagCurrent != pagMax" @click.prevent="updatePag(1)">>></button>
  </div>
</template>
<script>
export default {
  inheritAttrs: false,
  model: {
    prop: 'current',
    event: 'pagUpdate',
  },
  props: ['current', 'min', 'max', 'itemperpage'],
  data() {
    return {
      pagCurrent: this.current,
      pagMax: Math.ceil(this.max / this.itemperpage),
    };
  },
  methods: {
    updatePag(a) {
      this.pagCurrent += a;
      this.$emit('pagUpdate', this.pagCurrent);
    },
  },
};
</script>
