<template>
  <div>
    <div
      @click="redirectClick"
      class="border border-gray-200 cursor-pointer"
      :style="{ backgroundColor: value, width: '200px', height: '50px' }"
    >
      <div class="px-2 border border-l-4 bg-gray-200 float-right" style="height: 100%;">
        Select Color
      </div>
    </div>
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
