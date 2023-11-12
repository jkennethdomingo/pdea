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
    return store.state.formData.page2; 
  },
  set(value) {
    store.commit('updateFormData', { page: 'page2', data: value });
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
     <p class="text-xl text-gray-900 dark:text-white font-bold">Work Experience</p>


<div class="mb-4 grid grid-cols-4 gap-4">
  <div class="mb-4">
    <label for="inclusive_dates_from" class="block text-gray-700 text-sm dark:text-white mb-2">Inclusive Dates:</label>
    <input type="text" id="inclusive_dates_from" v-model="formData.inclusive_dates_from" placeholder="From" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    <input type="text" id="inclusive_dates_to" v-model="formData.inclusive_dates_to" placeholder="To" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <div>
    <label for="position_title" class="block text-gray-700 text-sm dark:text-white mb-2">Position Title:</label>
    <input type="text" id="position_title" v-model="formData.position_title" placeholder="(Write in full/Do not abbreviate)" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <div>
    <label for="department_agency_office_company" class="block text-gray-700 text-sm dark:text-white mb-2">Department/Agency/Office/Company</label>
    <input type="text" id="department_agency_office_company" v-model="formData.department_agency_office_company" placeholder="(Write in full/Do not abbreviate)" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <div>
    <label for="monthly_salary" class="block text-gray-700 text-sm dark:text-white mb-2">Monthly Salary</label>
    <input type="text" id="monthly_salary" v-model="formData.monthly_salary" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
</div>

<div class="mb-4 grid grid-cols-4 gap-4">
  <div>
    <label for="salary_grade_step_increment" class="block text-gray-700 text-sm dark:text-white mb-2">Salary/Job/Pay Grade</label>
    <input type="text" id="salary_grade_step_increment" v-model="formData.salary_grade_step_increment" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <div>
    <label for="status_of_appointment" class="block text-gray-700 text-sm dark:text-white mb-2">Status Of Appointment</label>
    <input type="text" id="status_of_appointment" v-model="formData.status_of_appointment" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <div>
    <label for="govt_service" class="block text-gray-700 text-sm dark:text-white mb-2">Gov't Service</label>
    <input type="text" id="govt_service" v-model="formData.govt_service" placeholder="(Y/ N)" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
</div>

    <Button :to="{ name: 'Civil Service Eligibility' }">
  Back
</Button>

<Button :to="{ name: 'Voluntary Work' }">
  Next
</Button>
</template>
