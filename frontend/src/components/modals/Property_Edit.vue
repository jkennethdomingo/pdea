<script setup>
import { defineProps, defineEmits, reactive, watch, toRefs } from 'vue';
import procurementStatusData from '@/assets/json/procurement_status.json';

const procurementStatus = procurementStatusData.statuses;

// Define props and emits
const props = defineProps({
  isVisible: Boolean,
  itemToEdit: Object // The prop name must match what's passed from the parent
});

const emit = defineEmits(['update', 'cancel']);

// Use toRefs to make each prop reactive
const { itemToEdit } = toRefs(props);

// Log the initial itemToEdit to see if it's being passed correctly
console.log('Initial itemToEdit:', itemToEdit.value);

// Create a reactive formData object. The spread operator (...) can't be used directly with refs inside `reactive`
const formData = reactive({});

// Watch for changes in itemToEdit and update formData accordingly
watch(itemToEdit, (newValue) => {
  console.log('itemToEdit changed:', newValue);
  for (const key in newValue) {
    formData[key] = newValue[key];
  }
}, { deep: true, immediate: true });

// Log formData to see if it reflects the changes
watch(formData, (newFormData) => {
  console.log('formData updated:', newFormData);
}, { deep: true });

// Method to handle saving changes
const saveChanges = () => {
  console.log('Saving changes:', formData);
  // Here you would call an API to save the changes or emit an event with the updated data
  emit('update', formData);
  closeModal();
};

// Method to close the modal and reset formData
const closeModal = () => {
  console.log('Closing modal, resetting formData');
  // Reset the form data to initial values or clear them
  for (const key in formData) {
    formData[key] = '';
  }
  emit('cancel');
};
</script>


<template>
    <div v-if="isVisible" id="popup-modal" tabindex="-1" class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex items-center justify-center w-full h-screen">
    <div class="relative p-4 w-full max-w-2xl bg-gray-200 rounded-lg shadow dark:bg-gray-700">
        <!-- Close Button at the top-right corner -->
        <button type="button" @click="closeModal" class="absolute top-2 right-2 text-gray-400 bg-transparent hover:bg-gray-200 rounded-full text-sm p-2 dark:hover:bg-gray-600 dark:hover:text-white" aria-label="Close">
            <!-- SVG for 'X' -->
            <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9.5l5-5m-5 5l-5-5m5 5l5 5m-5-5l-5 5" clip-rule="evenodd"/>
            </svg>
        </button>
                <br>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                    <label for="status_name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Procurement Status:</label>
                    <select id="status_name" v-model="formData.procurement_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option v-for="pc in procurementStatus" :key="pc.value" :value="pc.value">{{ pc.label }}</option>
                    </select>
                </div>
                    
                    <div>
                        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
                        <input type="date" id="Date" v-model="formData.date_of_receipt_of_request" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="Project" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulara:</label>
                        <input type="text" id="Project" v-model="formData.project_particulars"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="EndUser" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
                        <select id="EndUser" v-model="formData.endUser" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled>Select User</option>
                        <option v-for="option in endUserOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
                        <input type="text" id="Purchase1" placeholder="No" v-model="formData.purchase_work_job_request_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                        <input type="date" id="Purchase2" placeholder="Date" v-model="formData.purchase_work_job_request_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="Philgeps" class="block text-gray-700 text-sm dark:text-white mb-2">Philgeps:</label>
                        <input id="Philgeps" type="checkbox" v-model="formData.philgeps_posting" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                        <input type="text" id="Ideal_No" v-model="formData.ideal_no_of_days_to_complete" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
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
                <div class="flex justify-end gap-3 mt-4">
                <button @click="closeModal" type="button" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm font-medium px-4 py-1.5 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-500 dark:focus:ring-gray-700">
                    Cancel
                </button>
                <button @click="saveChanges" type="button" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg text-sm font-medium px-4 py-1.5 focus:z-10">
                    Update
                </button>
            </div>
        </div>
    </div>

</template>



<style scoped>
/* Your CSS here */
</style>
