import Vue from 'vue';
import { Plugin } from 'vue-fragment';
import VueResource from 'vue-resource';
import App from './components/Form';
import FormLabel from './components/FormLabel';
import Store from './plugins/Store';
import StoreData from './functions/storeData';
// eslint-disable-next-line no-unused-vars
import styles from './assets/css/formShortcode.css';

// fragment activation
Vue.use(Plugin);

Vue.use(VueResource);
Vue.http.options.emulateJSON = true;
Vue.http.options.emulateHTTP = true;

Vue.mixin({
  computed: {
    resource() {
      return this.$resource(this.extras.ajax_url);
    },
  },
});

// applying some defaults to singleton store that actually defined in server sent data
let storeData = StoreData.putSelectionDefaults(formShortcodeFields, { select: 'options' });

// extra defaults for some fields
const extraDefaults = {
  'template-five-theme': '#1cbc00',
  'template-six-theme': '#1cbc00',
  'template-seven-theme': '#9fe26f',
  'template-eight-theme': '#329d40',
};
storeData = { ...storeData, ...extraDefaults };

// singleton store plugin activation
Vue.use(Store, {
  store: storeData,
  extras: formShortcodeExtras,
  app: {
    submit: {
      fetching: false,
      isSuccess: true,
    },
  },
});

// main Vue instance
new Vue({
  components: { App, FormLabel },
  data: {
    fields: formShortcodeFields,
  },
  template: "<app :fields='fields'></app>",
}).$mount('#form_shortcode');