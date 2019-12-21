<template>
  <input :value="parseTime" @change="updateTime" type="time" />
</template>
<script>
import { appendZero } from '../functions/EzTime';

export default {
  props: ['value'],
  model: {
    prop: 'value',
    event: 'changeTime',
  },
  computed: {
    parseTime() {
      if (this.value) {
        const [time, pos] = this.value.split(' ');
        // eslint-disable-next-line prefer-const
        let [hour, min] = time.split(':').map(t => Number.parseInt(t, 10));

        if (pos === 'pm') {
          hour += 12;
        }
        return `${appendZero(hour)}:${appendZero(min)}`;
      }

      return '';
    },
  },
  methods: {
    updateTime(e) {
      const timeVal = e.target.value;
      if (timeVal) {
        const [hour, min] = timeVal.split(':').map(n => Number.parseInt(n, 10));

        let pos;

        if (hour < 12) {
          pos = 'am';
        } else {
          pos = 'pm';
        }
        const timeString = `${hour % 12}:${min} ${pos}`;
        this.$emit('changeTime', timeString);
      }
    },
  },
};
</script>
