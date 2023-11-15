import { ref, watch } from 'vue';

export default function useChildrenData(formData, formFields) {
    const childrenCount = ref(0);
    const childrenData = ref([]);

    // Initialize children data with empty values based on formFields
    const initializeChildData = () => {
        return formFields.reduce((data, field) => {
            data[field.key] = '';
            return data;
        }, {});
    };

    watch(childrenCount, (newCount) => {
        if (newCount > childrenData.value.length) {
            for (let i = childrenData.value.length; i < newCount; i++) {
                childrenData.value.push(initializeChildData());
            }
        } else {
            childrenData.value.splice(newCount);
        }
    });

    watch(childrenData, (newChildrenData) => {
        formData.value.children = newChildrenData;
    }, { deep: true });

    return { childrenCount, childrenData };
}
