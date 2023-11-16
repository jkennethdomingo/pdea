<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <DynamicForm
      :pageNumber="7"
      :fieldSchema="fieldSchema"
      arrayName="LearningDevelopment"
    />
    <div class="flex justify-between">
      <Button :to="{ name: 'Voluntary Work' }">
        Back
      </Button>
      <Button :to="{ name: 'Other Information' }">
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
  { name: 'title', label: 'Title', type: 'text' },
  { name: 'period_from', label: 'Period From', type: 'date' },
  { name: 'period_to', label: 'Period To', type: 'date' },
  { name: 'number_of_hours', label: 'Number of Hours', type: 'text' },
  { name: 'conducted_by', label: 'Conducted by', type: 'text' },
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
