<template>
  <div ref="preview-wrapper" v-html="html"></div>
</template>
<script>
import { decodeDate, toMilliSeconds, decodeTime } from '../../functions/EzTime';

export default {
  data() {
    return {
      values: {
        featured_url: [
          {
            element: '.wpcd-get-fetured-img',
            format: (value, el) => {
              if (value && el) {
                // eslint-disable-next-line no-param-reassign
                el.src = value;
              }
            },
          },
          {
            element: 'img[alt="Coupon"]',
            format: (value, el) => {
              if (value && el) {
                // eslint-disable-next-line no-param-reassign
                el.src = value;
              }
            },
          },
        ],
      },
    };
  },
  props: ['html'],
  computed: {
    wrapper() {
      return this.$refs['preview-wrapper'];
    },
  },
  mounted() {
    this.beforeParentMount();
    this.bindValues();
    this.toggles();
  },
  watch: {
    store: {
      handler() {
        this.bindValues();
        this.toggles();
      },
      deep: true,
    },
  },
  methods: {
    decodeTime(timeString) {
      return decodeTime(timeString);
    },
    decodeDate(secs) {
      return decodeDate(secs);
    },
    toMilliSeconds(secs) {
      return toMilliSeconds(secs);
    },
    // hook to call before mounting parent template
    // override for DOM manipulations etc
    beforeParentMount() {},
    /**
     * toggle visibility of a element
     * @param e string element class/id name
     * @param handler function a function that returns boolen (true for show, false for hide)
     */
    toggle(e, handler) {
      const element = this.wrapper.querySelector(e);
      const handlerResult = handler();
      if (element.classList.contains('hidden')) {
        if (handlerResult) {
          this.wrapper.querySelector(e).classList.remove('hidden');
        }
      } else this.wrapper.querySelector(e).style.display = handler() ? 'block' : 'none';
      // if (handler()) {
      //   this.wrapper.querySelector(e).classList.remove('hidden');
      // } else {
      //   this.wrapper.querySelector(e).classList.add('hidden');
      // }
    },

    /**
     * toggle visibility of all elements in data.toggleVisibility
     */
    toggles() {
      Object.keys(this.toggleVisibility).map(t => {
        if (Object.prototype.hasOwnProperty.call(this.toggleVisibility, t)) {
          this.toggle(t, this.toggleVisibility[t]);
        }
      });
    },

    /**
     * bind keys in data.fieldPairs to values of preview object class/id
     * values of the keys can be
     * string : that element's text content will be changed
     * array : all of the elements' text content will be changed
     * objects inside array : object has this keys:
     *                        -element : element to search for
     *                        - format: is a function with a value argument to further
     *                        customize the string to be put in text content, takes value
     *                        and element as arguments
     *                        -append: is a boolean to append instead of changing
     *                        the text content
     */
    bindValues() {
      Object.keys(this.values).map(f => {
        if (Object.prototype.hasOwnProperty.call(this.values, f)) {
          let value;
          let append = false;
          let format = s => s;
          let dataObject = this.store;
          let attr = 'innerHTML';
          const parent = Array.isArray(this.values[f]) ? this.values[f] : [this.values[f]];

          parent.map(p => {
            if (typeof p === 'object') {
              value = p.element;
              append = p.append || false;
              dataObject = p.dataObject || dataObject;
              attr = p.attr || attr;
              format =
                p.format ||
                function callback(s) {
                  return s;
                };
            } else {
              value = p;
            }
            const el = document.querySelector(value);
            const callbackResult = format(dataObject[f], el);
            if (callbackResult) {
              if (dataObject[f]) {
                if (Array.isArray(value)) {
                  value.map(v => {
                    if (append) {
                      this.wrapper.querySelector(v)[attr] += callbackResult;
                    } else {
                      this.wrapper.querySelector(v)[attr] = callbackResult;
                    }
                  });
                } else if (append) {
                  this.wrapper.querySelector(value)[attr] += callbackResult;
                } else {
                  this.wrapper.querySelector(value)[attr] = callbackResult;
                }
              }
            }
          });
        }
      });
    },
  },
};
</script>
