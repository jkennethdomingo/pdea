<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/Button.vue';
import { reactive, ref, onMounted } from 'vue';
import { initDropdowns } from 'flowbite';

const store = useStore();


// Form data bound to Vuex store
const formData = computed({
  get() {
    return store.state.formData.page4; 
  },
  set(value) {
    store.commit('updateFormData', { page: 'page4', data: value });
  },
});

onMounted(async () => {
  initDropdowns();
});

const handleSubmit = () => {
  // Submit form data or navigate to the next page
  store.dispatch('submitFormData');
};

</script>

<template>
    Civil Service Eligibility

    <Button :to="{ name: 'Educational Background' }">
  Back
</Button>

<Button :to="{ name: 'Work Experience' }">
  Next
</Button>
</template>
