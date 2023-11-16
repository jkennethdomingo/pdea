<template>
    <div v-if="isVisible" id="popup-modal" tabindex="-1" class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex items-center justify-center w-full md:inset-0 h-screen max-h-full">
        <div class="relative p-4 w-full max-w-5xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" @click="closeModal" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <!-- SVG for 'X' -->
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <br>
                <div class="mb-4 grid grid-cols-3 gap-4">
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
                <div class="p-4 md:px-8">
                    <button @click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import { useStore } from 'vuex';
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

const props = defineProps({
  isVisible: Boolean,
  message: String // example for passing custom message
});

const emit = defineEmits(['cancel']);

const closeModal = () => {
  emit('cancel');
};
</script>

<style scoped>
/* Your CSS here */
</style>
