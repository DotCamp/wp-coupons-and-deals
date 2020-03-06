<template>
  <div>
    <div
      @click="redirectClick"
      class="border-4 border-gray-200 cursor-pointer"
      :style="{ backgroundColor: value, height: '50px' }"
    ></div>
    <input
      ref="realColorPicker"
      :value="value"
      @change="$emit('change', $event.target.value)"
      type="color"
      class="hidden"
    />
  </div>
</template>
<script>
export default {
  inheritAttrs: false,
  model: {
    prop: 'value',
    event: 'change',
  },
  props: ['value'],
  methods: {
    redirectClick() {
      this.$refs.realColorPicker.click();
    },
  },
};
</script>
