import Vue from 'vue';
import { Plugin } from 'vue-fragment';
import VueResource from 'vue-resource';
import App from './components/App';
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

Vue.filter('cap', val => {
  if (val) {
    return val
      .split(' ')
      .map(v => {
        return v[0].toUpperCase() + v.slice(1);
      })
      .join(' ');
  }
  return '';
});

Vue.filter('truncate', (val, l, suffix) => {
  if (val.length > l) {
    return val.slice(0, l) + (suffix || '...');
  }
  return val;
});

Vue.mixin({
  computed: {
    resource() {
      return this.$resource(this.extras.options.ajax_url);
    },
  },
});

// applying some defaults to singleton store that actually defined in server sent data
let storeData = StoreData.putSelectionDefaults(wpcd_fs_fields, { select: 'options' });

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
  extras: wpcd_fs_extras,
  app: {
    submit: {
      fetching: false,
      isSuccess: true,
    },
  },
});

// eslint-disable-next-line camelcase
wpcd_fs_extras = undefined;

// eslint-disable-next-line camelcase
const formShortcodeFields = [...wpcd_fs_fields];
// eslint-disable-next-line camelcase
wpcd_fs_fields = undefined;

// main Vue instance
new Vue({
  components: { App, FormLabel },
  data: {
    fields: formShortcodeFields,
  },
  template: "<app :fields='fields'></app>",
}).$mount('#form_shortcode');
