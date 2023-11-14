<script setup>
import { computed, ref, onMounted, watch } from 'vue'; // Ensure 'computed' is imported here
import { useStore } from 'vuex';
import Button from '@/components/Button.vue';
import { initDropdowns } from 'flowbite';

const store = useStore();

// Assuming your Vuex store has an action called 'getDropdownData'
onMounted(() => {
  initDropdowns();
});

// Simplify formData to directly refer to the store state
const formData = computed(() => store.state.formData.page3);

watch(formData, (newValue) => {
  console.log('Form Data Updated:', newValue);
}, { deep: true });

// Debounce handleSubmit to prevent double submission
const isSubmitting = ref(false);
const handleSubmit = async () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;

  try {
    await store.dispatch('submitFormData');
    // Success feedback (toast, modal, etc.) goes here
  } catch (error) {
    console.error('Error submitting form data:', error);
    // Error feedback (toast, modal, etc.) goes here
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<template>
  <form @submit.prevent="handleSubmit">
    <p class="text-xl text-gray-900 dark:text-white font-bold">Educational Background</p>
    <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Elementary -->
      <div>
        <label for="name_of_school" class="block text-gray-700 text-sm dark:text-white mb-2"> Name of School:</label>
        <input type="text" id="name_of_school" v-model="formData.Elementary.name_of_school"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="degree_course" class="block text-gray-700 text-sm dark:text-white mb-2">Degree/Course:</label>
        <input type="text" id="degree_course" v-model="formData.Elementary.degree_course"  class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="period_of_attendance_from" class="block text-gray-700 text-sm dark:text-white mb-2"> Period of Attendance:</label>
        <input type="text" id="period_of_attendance_from" v-model="formData.Elementary.period_of_attendance_from" placeholder="From" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="period_of_attendance_to" v-model="formData.Elementary.period_of_attendance_to" placeholder="To" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="highest_level_units_earned" class="block text-gray-700 text-sm dark:text-white mb-2"> Highest Level Units Earned:</label>
        <input type="text" id="highest_level_units_earned" v-model="formData.Elementary.highest_level_units_earned" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="year_graduated" class="block text-gray-700 text-sm dark:text-white mb-2">Year Graduated:</label>
        <input type="text" id="year_graduated" v-model="formData.Elementary.year_graduated" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="scholarship_academic_honors_received" class="block text-gray-700 text-sm dark:text-white mb-2"> Scholarship Academic Honor Received:</label>
        <input type="text" id="scholarship_academic_honors_received" v-model="formData.Elementary.scholarship_academic_honors_received" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Secondary -->
      <div>
        <label for="name_of_school" class="block text-gray-700 text-sm dark:text-white mb-2"> Name of School:</label>
        <input type="text" id="name_of_school" v-model="formData.Secondary.name_of_school"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="degree_course" class="block text-gray-700 text-sm dark:text-white mb-2">Degree/Course:</label>
        <input type="text" id="degree_course" v-model="formData.Secondary.degree_course"  class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="period_of_attendance_from" class="block text-gray-700 text-sm dark:text-white mb-2"> Period of Attendance:</label>
        <input type="text" id="period_of_attendance_from" v-model="formData.Secondary.period_of_attendance_from" placeholder="From" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="period_of_attendance_to" v-model="formData.Secondary.period_of_attendance_to" placeholder="To" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="highest_level_units_earned" class="block text-gray-700 text-sm dark:text-white mb-2"> Highest Level Units Earned:</label>
        <input type="text" id="highest_level_units_earned" v-model="formData.Secondary.highest_level_units_earned" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="year_graduated" class="block text-gray-700 text-sm dark:text-white mb-2">Year Graduated:</label>
        <input type="text" id="year_graduated" v-model="formData.Secondary.year_graduated" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="scholarship_academic_honors_received" class="block text-gray-700 text-sm dark:text-white mb-2"> Scholarship Academic Honor Received:</label>
        <input type="text" id="scholarship_academic_honors_received" v-model="formData.Secondary.scholarship_academic_honors_received" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Secondary -->
      <div>
        <label for="name_of_school" class="block text-gray-700 text-sm dark:text-white mb-2"> Name of School:</label>
        <input type="text" id="name_of_school" v-model="formData.Vocational.name_of_school"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="degree_course" class="block text-gray-700 text-sm dark:text-white mb-2">Degree/Course:</label>
        <input type="text" id="degree_course" v-model="formData.Vocational.degree_course"  class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="period_of_attendance_from" class="block text-gray-700 text-sm dark:text-white mb-2"> Period of Attendance:</label>
        <input type="text" id="period_of_attendance_from" v-model="formData.Vocational.period_of_attendance_from" placeholder="From" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="period_of_attendance_to" v-model="formData.Vocational.period_of_attendance_to" placeholder="To" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="highest_level_units_earned" class="block text-gray-700 text-sm dark:text-white mb-2"> Highest Level Units Earned:</label>
        <input type="text" id="highest_level_units_earned" v-model="formData.Vocational.highest_level_units_earned" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="year_graduated" class="block text-gray-700 text-sm dark:text-white mb-2">Year Graduated:</label>
        <input type="text" id="year_graduated" v-model="formData.Vocational.year_graduated" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="scholarship_academic_honors_received" class="block text-gray-700 text-sm dark:text-white mb-2"> Scholarship Academic Honor Received:</label>
        <input type="text" id="scholarship_academic_honors_received" v-model="formData.Vocational.scholarship_academic_honors_received" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Secondary -->
      <div>
        <label for="name_of_school" class="block text-gray-700 text-sm dark:text-white mb-2"> Name of School:</label>
        <input type="text" id="name_of_school" v-model="formData.College.name_of_school"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="degree_course" class="block text-gray-700 text-sm dark:text-white mb-2">Degree/Course:</label>
        <input type="text" id="degree_course" v-model="formData.College.degree_course"  class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="period_of_attendance_from" class="block text-gray-700 text-sm dark:text-white mb-2"> Period of Attendance:</label>
        <input type="text" id="period_of_attendance_from" v-model="formData.College.period_of_attendance_from" placeholder="From" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="period_of_attendance_to" v-model="formData.College.period_of_attendance_to" placeholder="To" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="highest_level_units_earned" class="block text-gray-700 text-sm dark:text-white mb-2"> Highest Level Units Earned:</label>
        <input type="text" id="highest_level_units_earned" v-model="formData.College.highest_level_units_earned" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="year_graduated" class="block text-gray-700 text-sm dark:text-white mb-2">Year Graduated:</label>
        <input type="text" id="year_graduated" v-model="formData.College.year_graduated" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="scholarship_academic_honors_received" class="block text-gray-700 text-sm dark:text-white mb-2"> Scholarship Academic Honor Received:</label>
        <input type="text" id="scholarship_academic_honors_received" v-model="formData.College.scholarship_academic_honors_received" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>
   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Secondary -->
      <div>
        <label for="name_of_school" class="block text-gray-700 text-sm dark:text-white mb-2"> Name of School:</label>
        <input type="text" id="name_of_school" v-model="formData.GraduateStudies.name_of_school"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="degree_course" class="block text-gray-700 text-sm dark:text-white mb-2">Degree/Course:</label>
        <input type="text" id="degree_course" v-model="formData.GraduateStudies.degree_course"  class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="period_of_attendance_from" class="block text-gray-700 text-sm dark:text-white mb-2"> Period of Attendance:</label>
        <input type="text" id="period_of_attendance_from" v-model="formData.GraduateStudies.period_of_attendance_from" placeholder="From" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="period_of_attendance_to" v-model="formData.GraduateStudies.period_of_attendance_to" placeholder="To" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="highest_level_units_earned" class="block text-gray-700 text-sm dark:text-white mb-2"> Highest Level Units Earned:</label>
        <input type="text" id="highest_level_units_earned" v-model="formData.GraduateStudies.highest_level_units_earned" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="year_graduated" class="block text-gray-700 text-sm dark:text-white mb-2">Year Graduated:</label>
        <input type="text" id="year_graduated" v-model="formData.GraduateStudies.year_graduated" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="scholarship_academic_honors_received" class="block text-gray-700 text-sm dark:text-white mb-2"> Scholarship Academic Honor Received:</label>
        <input type="text" id="scholarship_academic_honors_received" v-model="formData.GraduateStudies.scholarship_academic_honors_received" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>
   <button @click="handleSubmit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Submit Form
</button>
  </form>
<div class="flex justify-between">
 <div>
    <Button :to="{ name: 'Family Background' }">
  Back
</Button>
</div>
 <div>
<Button :to="{ name: 'Civil Service Eligibility' }">
  Next
</Button>
</div>
</div>
</template>
