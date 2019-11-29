import Vue from 'vue';
import { Plugin } from 'vue-fragment';
import App from './components/Form';
import FormLabel from './components/FormLabel';
import Store from './plugins/Store';
import StoreData from './functions/storeData';
import dependencyGraph from './data/dependencyGraph';
// eslint-disable-next-line no-unused-vars
import styles from './assets/css/formShortcode.css';

// fragment activation
Vue.use(Plugin);

// applying some defaults to singleton store that actually defined in server sent data
let storeData = StoreData.putSelectionDefaults(formShortcodeFields, { select: 'options' });

// extra defaults for some fields
const extraDefaults = { };

storeData = { ...storeData, ...extraDefaults };

// injecting dependency fields
StoreData.putDepends(formShortcodeFields, dependencyGraph);

// singleton store plugin activation
Vue.use(Store, { store: storeData });

// main Vue instance
new Vue({
  components: { App, FormLabel },
  data: {
    fields: formShortcodeFields,
  },
  template: "<app :fields='fields'></app>",
}).$mount('#form_shortcode');
