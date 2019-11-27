<template>
  <fragment>
    <tr v-show="getDependencyGraph(f)" v-for="f in fieldsdata" :key="f.id">
      <td>
        <form-label :id="f.id" :helpmessage="f.help">
          {{ f.label }}
        </form-label>
      </td>
      <td>
        <input-selector :filterdata="filterdata" :data="f" :id="f.id" :name="f.name"></input-selector>
      </td>
    </tr>
  </fragment>
</template>
<script>
import FormLabel from './FormLabel';
import InputSelector from './InputSelector';

export default {
  components: { FormLabel, InputSelector },
  props: ['fieldsdata'],
  data() {
    return {
      filterdata: {
        select: ['select'],
        button: 'coupon-image-row',
        text: ['text', /.*(buttontext)/],
        colorpicker: 'colorpicker',
        date: 'expiredate',
      },
    };
  },
  methods: {
    getDependencyGraph(field) {
      if (field.depend) {
        let result = false;
        Object.keys(field.depend).map(f => {
          const depArray = field.depend[f];
          depArray.forEach(d => {
            if (this.store[f] === d) {
              result = true;
            }
          });
        });
        return result;
      }
      return true;
    },
  },
};
</script>
