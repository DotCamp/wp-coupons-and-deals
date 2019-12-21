<template>
  <input type="checkbox" :value="value" :checked="value == 0 ? false : true" @change="update" />
</template>
<script>
export default {
  props: ['value'],
  model: {
    prop: 'value',
    event: 'updateCheck',
  },
  methods: {
    update(e) {
      this.$emit('change', e);
    },
  },
};
</script>
