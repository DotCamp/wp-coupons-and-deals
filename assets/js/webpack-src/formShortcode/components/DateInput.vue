<template>
  <input type="date" :value="parseDate" @input="updateDate" />
</template>
<script>
import EzTime from '../functions/EzTime';

export default {
  props: ['value'],
  model: {
    prop: 'value',
    event: 'changeDate',
  },
  computed: {
    parseDate() {
      const date = new Date(Number.parseInt(this.value, 10) * 1000);
      const year = date.getFullYear();
      const month = EzTime.appendZero(date.getMonth() + 1);
      const day = EzTime.appendZero(date.getDate());

      const fullDate = [year, month, day];

      return fullDate.join('-');
    },
  },
  methods: {
    updateDate(e) {
      const unixTime = Date.parse(e.target.value) / 1000;

      this.$emit('changeDate', unixTime);
    },
  },
};
</script>
