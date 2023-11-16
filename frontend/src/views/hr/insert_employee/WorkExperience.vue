<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <DynamicForm
      :pageNumber="5"
      :fieldSchema="fieldSchema"
      arrayName="WorkExperience"
    />
    <div class="flex justify-between">
      <Button :to="{ name: 'Civil Service Eligibility' }">
        Back
      </Button>
      <Button :to="{ name: 'Voluntary Work' }">
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
  { name: 'inclusive_dates_from', label: 'Inclusive Dates From', type: 'date' },
  { name: 'inclusive_dates_to', label: 'Inclusive Dates To', type: 'date' },
  { name: 'position_title', label: 'Position Title', type: 'text' },
  { name: 'department_agency_office_company', label: 'Department Agency Office Company', type: 'text' },
  { name: 'monthly_salary', label: 'Monthly Salary', type: 'text' },
  { name: 'salary_grade_step_increment', label: 'Salary Grade Step Increment', type: 'text' },
  { name: 'status_of_appointment', label: 'Status of Appointment', type: 'text' },
  { name: 'govt_service', label: 'govt_service', type: 'text' },
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
