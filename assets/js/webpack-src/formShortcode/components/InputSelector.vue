<template>
  <select v-model="store[data.id]" v-if="isElementType('select')">
    <option v-for="option in data.options" :key="option">{{ option }}</option>
  </select>
  <a class="bg-gray-400 p-2 cursor-pointer border-b-2 border-r-2 border-gray-500" v-else-if="isElementType('button')">
    {{ data.label }}
  </a>
  <textarea v-model="store[data.id]" v-else-if="isElementType('textarea')" rows="5" cols="30" />
  <input v-model="store[data.id]" v-else-if="isElementType('text')" />
  <input v-model="store[data.id]" v-else-if="isElementType('date')" type="date" />
  <input v-model="store[data.id]" v-else-if="isElementType('time')" type="time" class="w-full-important" />
  <!--  <input v-model="store[data.id]" v-else-if="isElementType('colorpicker')" type="color" />-->
  <color-picker v-model="store[data.id]" v-else-if="isElementType('colorpicker')" />
  <input
    v-model="store[data.id]"
    v-else-if="isElementType('checkbox')"
    @change.prevent="checkboxCheck"
    type="checkbox"
  />
</template>
<script>
import ColorPicker from './ColorPicker';

export default {
  props: ['filterdata', 'data'],
  components: { ColorPicker },
  methods: {
    checkboxCheck(e) {
      this.store[this.data.id] = e.target.checked ? 'on' : 0;
    },
    isElementType(el) {
      if (!Array.isArray(this.filterdata[el])) {
        this.filterdata[el] = [this.filterdata[el]];
      }

      // eslint-disable-next-line consistent-return
      const result = this.filterdata[el].filter(rule => {
        if (this.data.type.match(rule) !== null) {
          return rule;
        }
      });
      return result.length > 0;
    },
  },
};
</script>
