<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <DynamicForm
      :pageNumber="4"
      :fieldSchema="fieldSchema"
      arrayName="CivilService"
    />
    <div class="flex justify-between">
      <Button :to="{ name: 'Educational Background' }">
        Back
      </Button>
      <Button :to="{ name: 'Work Experience' }">
        Next
      </Button>

    </div>

<button @click="handleSubmit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Submit Form
</button>
    </form>
    
  </div>
</template>

<script setup>
import { ref } from 'vue';
import DynamicForm from '@/components/dynamic/DynamicForm.vue'; // Adjust the path as needed
import Button from '@/components/base/Button.vue';
import { useStore } from 'vuex';

const store = useStore();

const fieldSchema = ref([
  { name: 'career_service', label: 'Career Service', type: 'text' },
  { name: 'rating', label: 'Rating', type: 'text' },
  { name: 'date_of_examination', label: 'Date of Examination', type: 'date' },
  { name: 'place_of_examination', label: 'Place of Examination', type: 'text' },
  { name: 'license_number', label: 'License Number', type: 'text' },
  { name: 'license_date_of_validity', label: 'License Date of Validity', type: 'date' },
  // Add more fields as needed for the CivilService array
]);

const isSubmitting = ref(false);
const handleSubmit = async () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;

  try {
    await store.dispatch('submitFormData');
    // Success feedback
  } catch (error) {
    console.error('Error submitting form data:', error);
    // Error feedback
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style>
/* Add any styles specific to this parent component */
</style>
