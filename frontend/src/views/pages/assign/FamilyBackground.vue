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

  <p class="text-xl text-gray-900 dark:text-white">Family Background</p>
    <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Surname -->
      <div>
        <label for="spouse_surname" class="block text-gray-700 text-sm dark:text-white mb-2">Surname:</label>
        <input type="text" id="spouse_surname" v-model="formData.spouse_surname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- First Name -->
      <div>
        <label for="spouse_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">First Name:</label>
        <input type="text" id="spouse_first_name" v-model="formData.spouse_first_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Middle Name -->
      <div>
        <label for="spouse_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Middle Name:</label>
        <input type="text" id="spouse_middle_name" v-model="formData.spouse_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Name Extension -->
      <div>
        <label for="spouse_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
        <input type="text" id="spouse_name_extension" v-model="formData.spouse_name_extension" placeholder="e.g., Jr, Sr" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- occupation -->
      <div>
        <label for="spouse_occupation" class="block text-gray-700 text-sm dark:text-white mb-2">Occupation:</label>
        <input type="text" id="spouse_occupation" v-model="formData.spouse_occupation" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- Business Name -->
      <div>
        <label for="spouse_employer_business_name" class="block text-gray-700 text-sm dark:text-white mb-2">Business Name:</label>
        <input type="text" id="spouse_employer_business_name" v-model="formData.spouse_employer_business_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- address -->
      <div>
        <label for="spouse_business_address" class="block text-gray-700 text-sm dark:text-white mb-2">Business Address:</label>
        <input type="text" id="spouse_business_address" v-model="formData.spouse_business_address" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- telephone -->
      <div>
        <label for="spouse_telephone_no" class="block text-gray-700 text-sm dark:text-white mb-2">Telephone Number:</label>
        <input type="text" id="spouse_telephone_no" v-model="formData.spouse_telephone_no" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Father Name -->
      <div>
        <label for="father_surname" class="block text-gray-700 text-sm dark:text-white mb-2">Father Name:</label>
        <input type="text" id="father_surname" v-model="formData.father_surname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- First Name -->
      <div>
        <label for="father_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">Father Firstname:</label>
        <input type="text" id="father_first_name" v-model="formData.father_first_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Middle Name -->
      <div>
        <label for="father_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2"> Father Middlename:</label>
        <input type="text" id="father_middle_name" v-model="formData.father_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Name Extension -->
      <div>
        <label for="father_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
        <input type="text" id="father_name_extension" v-model="formData.father_name_extension" placeholder="e.g., Jr, Sr" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- mother maiden name -->
      <div>
        <label for="mother_maiden_name" class="block text-gray-700 text-sm dark:text-white mb-2">Mother Maiden Name:</label>
        <input type="text" id="mother_maiden_name" v-model="formData.mother_maiden_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- First Name -->
      <div>
        <label for="mother_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">Mother Firstname:</label>
        <input type="text" id="mother_first_name" v-model="formData.mother_first_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Mother Middlename -->
      <div>
        <label for="mother_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Mother Middlename :</label>
        <input type="text" id="mother_middle_name" v-model="formData.mother_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- children name -->
      <div>
        <label for="full_name" class="block text-gray-700 text-sm dark:text-white mb-2">Children Name:</label>
        <input type="text" id="full_name" v-model="formData.full_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">  
      </div>
      <!-- DOB -->
      <div>
        <label for="date_of_birth" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Birth:</label>
        <input type="text" id="date_of_birth" v-model="formData.date_of_birth" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

<div class="flex justify-between">
  <div>
    <Button :to="{ name: 'Personal Information' }">
      Back
    </Button>
  </div>
  <div>
    <Button :to="{ name: 'Educational Background' }">
      Next
    </Button>
  </div>
</div>







</template>
