<script setup>
import { computed, ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/Button.vue';
import { initDropdowns } from 'flowbite';
import DynamicFormComponent from '@/components/dynamic/DynamicInput.vue';

const store = useStore();

const qualificationHeaders = ref([
  { label: "CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE BARANGAY ELIGIBILITY / DRIVER'S LICENSE", key: 'career_service', type: 'text', },
  { label: 'Rating', key: 'rating', type: 'number' , min: 0, max: 100 },
  { label: 'Date of Examination / Conferment', key: 'date_of_examination', type: 'date' },
  { label: 'Place of Examination / Conferment', key: 'place_of_examination', type: 'text' },
  { label: 'License Number', key: 'license_number', type: 'text' },
  { label: 'License Date of Validity', key: 'license_date_of_validity', type: 'date' },
  // ... other headers
]);

const createDefaultQualification = () => ({
  career_service: '',
  rating: '',
  date_of_examination: '',
  place_of_examination: '',
  license_number: '',
  license_date_of_validity: ''
});

onMounted(() => {
  initDropdowns();
});

const formData = computed(() => store.state.formData.page4);

const qualificationCount = ref(formData.value.length);
const qualificationData = ref(formData.value.length ? formData.value : [createDefaultQualification()]);

watch(qualificationCount, (newCount) => {
  qualificationData.value = Array.from({ length: newCount }, (_, index) =>
    qualificationData.value[index] || createDefaultQualification()
  );
}, { deep: true });

watch(qualificationData, (newData) => {
    // Use the updated mutation to handle the array of qualifications
    store.commit('updateDynamicForm', { page: 'page4', data: newData });
}, { deep: true });

watch(formData, (newValue) => {
  console.log('Form Data Updated:', newValue);
}, { deep: true });

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



<template>
  <form @submit.prevent="handleSubmit">
    <DynamicFormComponent 
    :count="qualificationCount" 
    countLabel="Number of Qualifications" 
    :headers="qualificationHeaders" 
    :data="qualificationData" 
    @update:count="qualificationCount = $event" 
    @update:data="qualificationData = $event" 
  />

  <button @click="handleSubmit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Submit Form
</button>
  </form>
  
  <div class="mt-4 flex justify-between">
    <Button :to="{ name: 'Educational Background' }" class="mr-2">
      Back
    </Button>
    <Button :to="{ name: 'Work Experience' }">
      Next
    </Button>
  </div>
</template>
