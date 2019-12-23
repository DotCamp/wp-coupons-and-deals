<template>
  <div class="wpcd-fs-flex wpcd-fs-justify-center">
    <div
      v-if="templates"
      class="wpcd-fs-w-full-important wpcd-fs-flex"
      style="justify-content: space-around; max-width: 50%"
    >
      <button @click="slideTemplates(previousDirection)" :disabled="buttonAvailable(previousDirection)">
        <span class="dashicons dashicons-arrow-left" />
      </button>
      <input-selector
        :filterdata="{ select: ['select'] }"
        :data="templates"
        :id="templates.id"
        :name="templates.name"
      />
      <button :disabled="buttonAvailable(nextDirection)" @click="slideTemplates(nextDirection)">
        <span class="dashicons dashicons-arrow-right" />
      </button>
    </div>
  </div>
</template>
<script>
import InputSelector from './InputSelector';

export default {
  components: { InputSelector },
  props: ['templates'],
  data() {
    return {
      nextDirection: 1,
      previousDirection: -1,
    };
  },
  methods: {
    calculateDynamicIndex(direction) {
      const currentSelection = this.store[this.templates.id];
      const index = this.templates.options.indexOf(currentSelection);
      return index + direction;
    },
    buttonAvailable(direction) {
      const dynamicIndex = this.calculateDynamicIndex(direction);
      return dynamicIndex === this.templates.options.length || dynamicIndex < 0;
    },
    slideTemplates(direction) {
      const dynamicIndex = this.calculateDynamicIndex(direction);
      this.$set(this.store, 'coupon-template', this.templates.options[dynamicIndex]);
    },
  },
};
</script>
