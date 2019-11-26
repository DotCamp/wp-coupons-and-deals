import Vue from 'vue';
import App from './components/Form';
import FormLabel from "./components/FormLabel";
import {Plugin} from 'vue-fragment';

Vue.use(Plugin);

new Vue({
    components: {App, FormLabel},
    data: {
        fields: formShortcodeFields
    },
    template: "<app :fields='fields'></app>"
}).$mount('#form_shortcode');