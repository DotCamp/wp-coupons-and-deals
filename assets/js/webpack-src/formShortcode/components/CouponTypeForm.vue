<template>
  <fragment>
    <tr class="form-shortcode-row" v-show="getDependencyGraph(f)" v-for="f in fieldsdata" :key="f.id">
      <td>
        <form-label :id="f.id" :helpmessage="f.help">
          {{ f.label }}
        </form-label>
      </td>
      <td>
        <input-selector :filterdata="filterdata" :data="f" :id="f.id" :name="f.name" />
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
        file: 'coupon-image-row',
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
            const BreakError = {};
            let tempResult = false;
            try {
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
                    tempResult = !hide;
                    // throw an error to break out of iteration
                    throw BreakError;
                    // return !hide;
                  }
                  if (hide) {
                    return true;
                  }
                  return false;
                })
                .some(d => d === true);
            } catch (e) {
              if (e === BreakError) {
                return tempResult;
              }
              throw e;
            }
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
