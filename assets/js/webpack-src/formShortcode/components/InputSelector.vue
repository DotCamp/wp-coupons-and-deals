<template>
  <select v-model="store[data.id]" v-if="isElementType('select')">
    <option v-for="option in data.options" :key="option">{{ option }}</option>
  </select>
  <file-input :preview_id="data.id" v-else-if="isElementType('file')" :text="extras.strings.select_an_image" />
  <textarea v-model="store[data.id]" v-else-if="isElementType('textarea')" rows="5" cols="30" />
  <!--  <tiny-editor :storebind="data.id" v-else-if="isElementType('textarea')" />-->
  <input
    v-model="store[data.id]"
    v-else-if="isElementType('text')"
    type="text"
    class="wpcd-fs-w-full-important"
    :placeholder="data.placeholder"
  />
  <input v-model="store[data.id]" v-else-if="isElementType('date')" type="date" class="wpcd-fs-w-full-important" />
  <input v-model="store[data.id]" v-else-if="isElementType('time')" type="time" class="wpcd-fs-w-full-important" />
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
import FileInput from './FileInput';
import TinyEditor from './TinyEditor';

export default {
  props: ['filterdata', 'data'],
  components: { ColorPicker, TinyEditor, FileInput },
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
