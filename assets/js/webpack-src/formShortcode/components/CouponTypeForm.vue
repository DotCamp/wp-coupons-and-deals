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
      // these are type-data associations with data field's type section
      // keys are basic html element types, values are their equivalance in the type fields of data
      // this values will be fed to 'InputSelector' to decide which element type to render
      filterdata: {
        select: ['select'],
        button: 'coupon-image-row',
        text: ['text', /.*(buttontext)/],
        textarea: 'textarea',
        colorpicker: 'colorpicker',
        date: 'expiredate',
        time: 'expiretime',
        checkbox: 'checkbox',
      },
    };
  },
  methods: {
    /**
     * function to decode to render element based on depend attribute
     *
     * since depend attribute field of the data can accept
     * '!' operator to hide the field we also need to check
     * for that operator in this function.
     *
     * @param field object field object
     * @returns {boolean} to show/or not to show
     */
    getDependencyGraph(field) {
      if (field.depend) {
        let result = false;
        Object.keys(field.depend).map(f => {
          const depArray = field.depend[f];
          try {
            depArray.forEach(d => {
              const hide = d[0] === '!';
              let rest;
              if (hide) {
                rest = d.slice(1);
              } else rest = d;
              if (this.store[f] === rest) {
                result = !hide;
                // throw a dummy exception to break out of 'forEach' loop
                throw Exception('break');
                // even though we didn't find a match the possibility of a '!' operator
                // force us to also write a else clause to maybe show the element
              } else if (hide) {
                result = true;
              }
            });
          } catch (e) {
            // do nothing
          }
        });
        return result;
      }
      return true;
    },
  },
};
</script>
