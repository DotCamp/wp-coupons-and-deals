<template>
  <select v-model="store[data.id]" v-if="isElementType('select')">
    <option v-for="option in data.options" :key="option">{{ option }}</option>
  </select>
  <a class="bg-gray-400 p-2 cursor-pointer border-b-2 border-r-2 border-gray-500" v-else-if="isElementType('button')">
    {{ data.label }}
  </a>
  <textarea v-model="store[data.id]" v-else-if="isElementType('textarea')" rows="5" cols="30"></textarea>
  <input v-model="store[data.id]" v-else-if="isElementType('text')" />
  <input v-model="store[data.id]" v-else-if="isElementType('date')" type="date" />
  <input v-model="store[data.id]" v-else-if="isElementType('time')" type="time" />
  <input v-model="store[data.id]" v-else-if="isElementType('colorpicker')" type="color" />
  <input v-model="store[data.id]" v-else-if="isElementType('checkbox')" type="checkbox" />
</template>
<script>
export default {
  props: ['filterdata', 'data'],
  methods: {
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
