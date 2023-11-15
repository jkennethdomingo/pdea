// useModal.js
import { ref } from 'vue'

export default function useModal() {
    const isModalVisible = ref(false);

    const toggleModal = () => {
        isModalVisible.value = !isModalVisible.value;
    };

    return { isModalVisible, toggleModal };
}
