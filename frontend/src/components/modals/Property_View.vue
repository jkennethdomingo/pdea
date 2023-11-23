<template>
    <div v-if="isVisible" id="popup-modal" tabindex="-1" class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl h-auto"> <!-- Adjusted max-width and height -->
        <div class="relative bg-gray-200 rounded-lg shadow dark:bg-gray-700">
            <button type="button" @click="closeModal" class="absolute top-3 right-0 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <!-- SVG for 'X' -->
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <button type="button" @click="closeModal" class="absolute top-10 right-0 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <!-- SVG for 'X' -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" 
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5">
                <div class="overflow-x-auto">
                    <table>
    <tbody class="text-left">
        <!-- Row 1 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1">
                <label for="status_name" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Procurement Status:</label>
                <div>{{ item ? item.procurement_status : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1"> 
                <label for="Date" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Date of Receipt of Request:</label>
                <div>{{ item ? item.date_of_receipt_of_request : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Project" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Project/Particulars:</label>
                <div>{{ item ? item.project_particulars : 'Data not available' }}</div>
            </td>
        </tr>

        <!-- Row 2 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1"> 
                <label for="End" class="block text-gray-700 text-sm dark:text-green-400 mb-2">End-User:</label>
                <div>{{ item ? item.endUser : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1"> 
                <label for="Purchase" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Purchase/Work/Job Request Number:</label>
                <div>{{ item ? item.purchase_work_job_request_no : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1"> 
                <label for="Purchase" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Purchase/Work/Job Request Date:</label>
                <div>{{ item ? item.purchase_work_job_request_date : 'Data not available' }}</div>
            </td>
        </tr>

        <!-- Row 3 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1">
                <label for="Philgeps" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Philgeps:</label>
                <div>{{ item ? item.philgeps_posting : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Price" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Price Quotation Number:</label>
                <div>{{ item ? item.price_quotation_no : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Price" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Price Quotation Date:</label>
                <div>{{ item ? item.price_quotation_date : 'Data not available' }}</div>
            </td>
        </tr>

        <!-- Row 4 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1">
                <label for="Abstract" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Abstract of Canvas Number:</label>
                <div>{{ item ? item.abstract_of_canvas_no : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Amount" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Abstract of Canvas Date:</label>
                <div>{{ item ? item.abstract_of_canvas_date : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Amount" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Amount:</label>
                <div>{{ item ? item.amount : 'Data not available' }}</div>
            </td>
        </tr>

        <!-- Row 5 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1">
                <label for="Supplier" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Supplier:</label>
                <div>{{ item ? item.supplier : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Date_Request" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Date Request for Fund:</label>
                <div>{{ item ? item.date_request_for_fund : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Ideal_No" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Ideal No. of Days to Complete:</label>
                <div>{{ item ? item.ideal_no_of_days_to_complete : 'Data not available' }}</div>
            </td>
        </tr>

        <!-- Row 6 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1">
                <label for="Actual_days" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Actual Days Completed:</label>
                <div>{{ item ? item.actual_days_to_complete : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Difference" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Difference:</label>
                <div>{{ item ? item.difference : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="PurchaseOrder" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Purchase/Work/Job Order:</label>
                <div>{{ item ? item.purchase_order : 'Data not available' }}</div>
            </td>
        </tr>

        <!-- Row 7 -->
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-1" colspan="2">
                <label for="Delivery_Status" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Delivery Status:</label>
                <div>{{ item ? item.delivery_status : 'Data not available' }}</div>
            </td>
            <td class="px-6 py-1">
                <label for="Remarks" class="block text-gray-700 text-sm dark:text-green-400 mb-2">Remarks:</label>
                <div>{{ item ? item.remarks : 'Data not available' }}</div>
            </td>
        </tr>
    </tbody>
</table>

                 </div>
                </div>     
            </div>
        </div>
    </div>



</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  isVisible: Boolean,
  message: String, // example for passing custom message
  item: Object,
});

const emit = defineEmits(['cancel']);

const closeModal = () => {
  emit('cancel');
};
</script>

<style scoped>
#popup-modal {
  display: flex;
  align-items: flex-start; 
  justify-content: center;
  height: 100vh;
  top: 11%; 
}

</style>
