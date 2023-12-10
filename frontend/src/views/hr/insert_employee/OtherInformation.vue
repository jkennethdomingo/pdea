<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <DynamicForm
      :pageNumber="8"
      :fieldSchema="fieldSchema"
      arrayName="OtherInformation"
    />
    <div class="flex justify-between">
      <Button :to="{ name: 'Learning And Development' }">
        Back
      </Button>
      <button @click="handleSubmit" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
    Submit Form
</button>
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
  { name: 'special_skills_hobbies', label: 'Special Skills Hobbies', type: 'text' },
  { name: 'non_academic_distinctions_recognition', label: 'Non Academic Distinctions Recognition', type: 'text' },
  { name: 'membership_association_organization', label: 'Membership Association Organization', type: 'text' },
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
