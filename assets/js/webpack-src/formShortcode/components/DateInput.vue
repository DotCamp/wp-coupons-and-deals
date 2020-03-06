<template>
  <input type="date" :value="parseDate" @input="updateDate" />
</template>
<script>
import { decodeDate, encodeDate } from '../functions/EzTime';

export default {
  props: ['value'],
  model: {
    prop: 'value',
    event: 'changeDate',
  },
  computed: {
    parseDate() {
      return decodeDate(this.value);
    },
  },
  methods: {
    updateDate(e) {
      const unixTime = encodeDate(e.target.value);
      this.$emit('changeDate', unixTime);
    },
  },
};
</script>
