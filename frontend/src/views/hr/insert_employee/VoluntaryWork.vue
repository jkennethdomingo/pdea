<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <DynamicForm
      :pageNumber="6"
      :fieldSchema="fieldSchema"
      arrayName="VoluntaryWork"
    />
    <div class="flex justify-between">
      <Button :to="{ name: 'Work Experience' }">
        Back
      </Button>
      <Button :to="{ name: 'Learning And Development' }">
        Next
      </Button>

    </div>

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
  { name: 'organization_name', label: 'Organization Name', type: 'text' },
  { name: 'position', label: 'Position', type: 'text' },
  { name: 'period_from', label: 'Period From', type: 'date' },
  { name: 'period_to', label: 'Period To', type: 'date' },
  { name: 'number_of_hours', label: 'Number of Hours', type: 'text' },
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
