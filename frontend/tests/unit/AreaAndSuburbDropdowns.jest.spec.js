//Note: ATLAS api does not return any value when both ar (area) and ct (suburb) is passed to it. So we take care of this
// by clearing one when other is selected, to only search one of them. This is the reason we needed this test.
import { mount } from '@vue/test-utils';
import AreaAndSuburbDropdowns from '../../src/components/AreaAndSuburbDropdowns.vue';

describe('AreaAndSuburbDropdowns', () => {
    it('clears the other dropdown when one is changed', () => {
        const wrapper = mount(AreaAndSuburbDropdowns);

        // Simulate changing the area dropdown
        wrapper.vm.$data.selectedArea = 1; // Corrected line

        // Assert that the suburb dropdown is cleared
        expect(wrapper.vm.selectedSuburb).toBeNull();
    });
});
