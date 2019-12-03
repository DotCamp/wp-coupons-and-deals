<template>
  <fragment>
    <tr class="form-shortcode-row" v-show="getDependencyGraph(f)" v-for="f in fieldsdata" :key="f.id">
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
import dependencyGraph from '../data/dependencyGraph';

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
        text: ['text', /.*(buttontext)/, /.+(dealtext)/],
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
      function evaluateObject(depObj) {
        return Object.keys(depObj)
          .map(f => {
            const depArray = depObj[f];

            return depArray
              .map(d => {
                const hide = d[0] === '!';
                let rest;
                if (hide) {
                  rest = d.slice(1);
                } else rest = d;
                if (rest === '*') {
                  return !hide;
                }
                if (this.store[f] === rest) {
                  return !hide;
                  // throw a dummy exception to break out of 'forEach' loop
                  // even though we didn't find a match the possibility of a '!' operator
                  // force us to also write a else clause to maybe show the element
                }
                if (hide) {
                  return true;
                }
                return false;
              })
              .some(d => d === true);
          })
          .every(o => o === true);
      }

      // if (field.depend) {
      //   return evaluateObject.call(this, field.depend);
      // }
      const currentType = this.store['coupon-type'];
      if (!dependencyGraph[currentType]) {
        return true;
      }
      const graph = dependencyGraph[currentType];
      if (!graph[field.id]) {
        return true;
      }
      return evaluateObject.call(this, graph[field.id]);
    },
  },
};
</script>
