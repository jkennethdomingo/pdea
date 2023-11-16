<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';

import PageWrapper from '@/components/layout/PageWrapper.vue';
// Create a reactive object for your form data
const formData = ref({
  date: '',
  project: '',
  endUser: '',
  // ... add all other form fields here
});

const store = useStore();

// Form submission handler
const submitForm = async () => {
  try {
    // Dispatch the Vuex action with the form data
    await store.dispatch('addInventory', formData.value);

    // Optionally, handle post-submission logic (e.g., clear form, show success message)
  } catch (error) {
    console.error('Error submitting form:', error);
    // Handle the error, e.g., show an error message to the user
  }
};
</script>

<template>
  <PageWrapper>
  
  <br>
  <form @submit.prevent="submitForm">
  

    <div class="mb-4 grid grid-cols-4 gap-4">
      <div>
        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
        <input type="date" id="Date" v-model="formData.date" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Project" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulara:</label>
        <input type="text" id="Project"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="End" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
        <input type="text" id="End" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
        <input type="text" id="Purchase" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="Purchase" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Philgeps" class="block text-gray-700 text-sm dark:text-white mb-2">Philgeps:</label>
        <input type="text" id="Philgeps" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Price" class="block text-gray-700 text-sm dark:text-white mb-2">Price Quotation:</label>
        <input type="text" id="Price" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="Price" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Abstract" class="block text-gray-700 text-sm dark:text-white mb-2">Abstract of Canvass:</label>
        <input type="text" id="Abstract" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="Abstract" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Amount" class="block text-gray-700 text-sm dark:text-white mb-2">Amount:</label>
        <input type="text" id="Amount" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Supplier" class="block text-gray-700 text-sm dark:text-white mb-2">Supplier:</label>
        <input type="text" id="Supplier" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Date_Request" class="block text-gray-700 text-sm dark:text-white mb-2">Date Request for Fund:</label>
        <input type="text" id="Date_Request" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Ideal_No" class="block text-gray-700 text-sm dark:text-white mb-2">Ideal No. of Days to Complete:</label>
        <input type="text" id="Ideal_No" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Actual_days" class="block text-gray-700 text-sm dark:text-white mb-2">Actual Days Completed:</label>
        <input type="text" id="Actual_days" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Difference" class="block text-gray-700 text-sm dark:text-white mb-2">Difference:</label>
        <input type="text" id="Difference" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Order:</label>
        <input type="text" id="Purchase" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Delivery_Status" class="block text-gray-700 text-sm dark:text-white mb-2">Delivery Status:</label>
        <input type="text" id="Delivery_Status" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Remarks" class="block text-gray-700 text-sm dark:text-white mb-2">Remarks:</label>
        <input type="text" id="Remarks" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <div class="flex justify-end">
    <button @click="submitForm">Submit</button>
      </div>
    </form>
</PageWrapper>
        
</template>

<style lang="">
    
</style>
 