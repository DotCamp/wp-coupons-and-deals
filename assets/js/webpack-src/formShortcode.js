import Vue from 'vue';
import App from './components/Form';

new Vue({
    components: {App},
    data: {
        testMessage: 'greetings from the Vuejs',
        fields: formShortcodeFields
    },
    template: "<app :message='testMessage' :fields='fields'></app>"
}).$mount('#form_shortcode');