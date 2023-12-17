<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToPersonalInfo">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S1
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Personal Information</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToFamBackground">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S2
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Family Background</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToEducBg">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S3
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Educational Background</h3>
        </span>
    </li>
    <li class="flex items-center text-green-600 dark:text-green-500 space-x-2.5 rtl:space-x-reverse cursor-pointer">
        <span class="flex items-center justify-center w-6 h-6 border border-green-600 rounded-full shrink-0 dark:border-green-500">
            S4
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Civil Service Eligibility</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToWorkExp">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S5
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Work Experience</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToVolWork">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S6
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Voluntary Work</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToLearnDev">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S7
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Learning And Development</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToOtherInfo">
        <span class="flex items-center justify-center w-6 h-6 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S8
        </span>
        <span>
            <h3 class="font-semibold text-sm  leading-tight">Other Information</h3>
        </span>
    </li>
</ol>

<hr class="my-3 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

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

    </form>
    
  </div>
</template>

<script setup>
import { ref } from 'vue';
import DynamicForm from '@/components/dynamic/DynamicForm.vue'; // Adjust the path as needed
import Button from '@/components/base/Button.vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const router = useRouter();

const goToPersonalInfo = () => {
  router.push({ name: 'Personal Information' });
};
const goToFamBackground = () => {
  router.push({ name: 'Family Background' });
};
const goToEducBg = () => {
  router.push({ name: 'Educational Background' });
};
const goToWorkExp = () => {
  router.push({ name: 'Work Experience' });
};
const goToVolWork = () => {
  router.push({ name: 'Voluntary Work' });
};
const goToLearnDev = () => {
  router.push({ name: 'Learning And Development' });
};
const goToOtherInfo = () => {
  router.push({ name: 'Other Information' });
};

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
