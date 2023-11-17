<template>
    <div v-if="isVisible" id="popup-modal" tabindex="-1" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" @click="closeModal" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <!-- SVG for 'X' -->
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5">
                            <div class="overflow-x-auto">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="md:col-span-1 mb-4">
                                        <label for="status_name" class="block text-gray-700 text-sm dark:text-white mb-2">Procurement Status:</label>
                                    </div>          
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Project" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulars:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="End" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Philgeps" class="block text-gray-700 text-sm dark:text-white mb-2">Philgeps:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Price" class="block text-gray-700 text-sm dark:text-white mb-2">Price Quotation:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Abstract" class="block text-gray-700 text-sm dark:text-white mb-2">Abstract of Canvass:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Amount" class="block text-gray-700 text-sm dark:text-white mb-2">Amount:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Supplier" class="block text-gray-700 text-sm dark:text-white mb-2">Supplier:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Date_Request" class="block text-gray-700 text-sm dark:text-white mb-2">Date Request for Fund:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Ideal_No" class="block text-gray-700 text-sm dark:text-white mb-2">Ideal No. of Days to Complete:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Actual_days" class="block text-gray-700 text-sm dark:text-white mb-2">Actual Days Completed:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Difference" class="block text-gray-700 text-sm dark:text-white mb-2">Difference:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="PurchaseOrder" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Order:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Delivery_Status" class="block text-gray-700 text-sm dark:text-white mb-2">Delivery Status:</label>
                                    </div>
                                    <div class="md:col-span-1 mb-4">
                                        <label for="Remarks" class="block text-gray-700 text-sm dark:text-white mb-2">Remarks:</label>
                                    </div>
                                </div>
                            </div>
                    <br>        
                    <button @click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

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
#popup-modal {
  display: flex;
  align-items: flex-start; 
  justify-content: center;
  height: 100vh;
  top: 11%; 
}

</style>
