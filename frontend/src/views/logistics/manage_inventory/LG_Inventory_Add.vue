<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';

import PageWrapper from '@/components/layout/PageWrapper.vue';
// Create a reactive object for your form data
const formData = ref({
  status_name: '',
  date_of_receipt_of_request: '',
  project_particular: '',
  endUser: '',
  purchase_work_job_request_no: '',
  purchase_work_job_request_date: '',
  philgeps_posting: '',
  price_quotation_no: '',
  price_quotation_date: '',
  abstract_of_canvas_no: '',
  abstract_of_canvas_date: '',
  amount: '',
  supplier: '',
  date_request_for_fund: '',
  idel_no_of_days_to_complete: '',
  actual_days_to_complete: '',
  difference: '',
  purchase_order: '',
  delivery_status: '',
  remarks: '',
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
        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Procurement Status:</label>
        <input type="date" id="Date" v-model="formData.status_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
        <input type="date" id="Date" v-model="formData.date_of_receipt_of_request" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Project" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulara:</label>
        <input type="text" id="Project" v-model="formData.project_particular"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="End" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
        <select type="dropdown" id="End" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
          <option value="option1">Option 1</option>
          <option value="option2">Option 2</option>
          <option value="option3">Option 3</option>
        </select>
      </div>
      <div>
        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
        <input type="text" id="Purchase1" placeholder="No" v-model="formData.purchase_work_job_request_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="date" id="Purchase2" placeholder="Date" v-model="formData.purchase_work_job_request_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Philgeps" class="block text-gray-700 text-sm dark:text-white mb-2">Philgeps:</label>
        <input type="checkbox" id="Philgeps" v-model="formData.philgeps_posting" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Price" class="block text-gray-700 text-sm dark:text-white mb-2">Price Quotation:</label>
        <input type="text" id="Price1" placeholder="No" v-model="formData.price_quotation_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="date" id="Price2" placeholder="Date" v-model="formData.price_quotation_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Abstract" class="block text-gray-700 text-sm dark:text-white mb-2">Abstract of Canvass:</label>
        <input type="text" id="Abstract1" placeholder="No" v-model="formData.abstract_of_canvas_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="date" id="Abstract2" placeholder="Date" v-model="formData.abstract_of_canvas_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Amount" class="block text-gray-700 text-sm dark:text-white mb-2">Amount:</label>
        <input type="text" id="Amount" v-model="formData.amount" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Supplier" class="block text-gray-700 text-sm dark:text-white mb-2">Supplier:</label>
        <input type="text" id="Supplier" v-model="formData.supplier" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Date_Request" class="block text-gray-700 text-sm dark:text-white mb-2">Date Request for Fund:</label>
        <input type="date" id="Date_Request" v-model="formData.date_request_for_fund" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Ideal_No" class="block text-gray-700 text-sm dark:text-white mb-2">Ideal No. of Days to Complete:</label>
        <input type="text" id="Ideal_No" v-model="formData.idel_no_of_days_to_complete" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Actual_days" class="block text-gray-700 text-sm dark:text-white mb-2">Actual Days Completed:</label>
        <input type="text" id="Actual_days" v-model="formData.actual_days_to_complete" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Difference" class="block text-gray-700 text-sm dark:text-white mb-2">Difference:</label>
        <input type="text" id="Difference" v-model="formData.difference" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="PurchaseOrder" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Order:</label>
        <input type="text" id="PurchaseOrder" v-model="formData.purchase_order" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Delivery_Status" class="block text-gray-700 text-sm dark:text-white mb-2">Delivery Status:</label>
        <input type="text" id="Delivery_Status" v-model="formData.delivery_status" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Remarks" class="block text-gray-700 text-sm dark:text-white mb-2">Remarks:</label>
        <input type="text" id="Remarks" v-model="formData.remarks" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
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
 