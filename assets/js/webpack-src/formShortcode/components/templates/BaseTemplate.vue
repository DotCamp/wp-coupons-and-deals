<template>
  <div ref="preview-wrapper" v-html="html"></div>
</template>
<script>
export default {
  props: ['html'],
  computed: {
    wrapper() {
      return this.$refs['preview-wrapper'];
    },
  },
  mounted() {
    this.bindValues();
    this.toggles();
  },
  watch: {
    store: {
      handler() {
        this.bindValues();
        this.toggles();
      },
      deep: true,
    },
  },
  methods: {
    /**
     * toggle visibility of a element
     * @param e string element class/id name
     * @param handler function a function that returns boolen (true for show, false for hide)
     */
    toggle(e, handler) {
      this.wrapper.querySelector(e).style.display = handler() ? '' : 'none';
    },

    /**
     * toggle visibility of all elements in data.toggleVisibility
     */
    toggles() {
      Object.keys(this.toggleVisibility).map(t => {
        if (Object.prototype.hasOwnProperty.call(this.toggleVisibility, t)) {
          this.toggle(t, this.toggleVisibility[t]);
        }
      });
    },
    /**
     * bind keys in data.fieldPairs to values of preview object class/id
     */
    bindValues() {
      Object.keys(this.values).map(f => {
        if (Object.prototype.hasOwnProperty.call(this.values, f)) {
          if (this.store[f]) {
            this.wrapper.querySelector(this.values[f]).textContent = this.store[f];
          }
        }
      });
    },
  },
};
</script>
