import {shallowMount} from '@vue/test-utils';
import Form from '../../assets/js/webpack-src/components/Form';


describe('Form', () => {
    it('should be an instance of Vuejs', () => {
            const wrapper = shallowMount(Form);
            expect(wrapper.isVueInstance()).toBeTruthy();
        }
    );

    it('should render same amount of fields as server send data', () => {
        const fields = [1, 2, 3, 4];

        const wrapper = shallowMount(Form, {propsData: {fields}});
        const result = wrapper.findAll('tr').length;

        expect(result).toBe(fields.length);
    });
})