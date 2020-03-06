<template>
  <select v-model="store[data.id]" v-if="isElementType('select')">
    <option v-for="option in data.options" :key="option">{{ option }}</option>
  </select>
  <file-input
    preview_id="coupon-image-input-url"
    v-else-if="isElementType('file')"
    :text="extras.strings.select_an_image"
  />
  <tiny-editor :storebind="data.id" v-else-if="isElementType('textarea')" />
  <input
    v-model="store[data.id]"
    v-else-if="isElementType('text')"
    type="text"
    class="wpcd-fs-w-full-important"
    :placeholder="data.placeholder"
  />
  <date-input v-model="store[data.id]" v-else-if="isElementType('date')" class="wpcd-fs-w-full-important" />
  <time-input v-model="store[data.id]" v-else-if="isElementType('time')" class="wpcd-fs-w-full-important" />
  <color-picker v-model="store[data.id]" v-else-if="isElementType('colorpicker')" />
  <check-box v-model="store[data.id]" v-else-if="isElementType('checkbox')" @change.prevent="checkboxCheck" />
</template>
<script>
import ColorPicker from './ColorPicker';
import FileInput from './FileInput';
import TinyEditor from './TinyEditor';
import DateInput from './DateInput';
import CheckBox from './CheckBox';
import TimeInput from './TimeInput';

export default {
  props: ['filterdata', 'data'],
  components: { TimeInput, CheckBox, DateInput, ColorPicker, TinyEditor, FileInput },
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
