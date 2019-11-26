import {shallowMount} from '@vue/test-utils';
import Form from '../../assets/js/webpack-src/formShortcode/components/Form';


describe('Form', () => {
    it('should be an instance of Vuejs', () => {
            const wrapper = shallowMount(Form, {propsData:{fields: []}});
            expect(wrapper.isVueInstance()).toBeTruthy();
        }
    );
})