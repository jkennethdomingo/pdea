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
                    <div class="md:px-8">
                        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
                        <input type="date" id="Date" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Project" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulara:</label>
                        <input type="text" id="Project"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="End" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
                        <input type="text" id="End" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
                        <input type="text" id="Purchase" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                        <input type="text" id="Purchase" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Philgeps" class="block text-gray-700 text-sm dark:text-white mb-2">Philgeps:</label>
                        <input type="text" id="Philgeps" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Price" class="block text-gray-700 text-sm dark:text-white mb-2">Price Quotation:</label>
                        <input type="text" id="Price" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                        <input type="text" id="Price" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Abstract" class="block text-gray-700 text-sm dark:text-white mb-2">Abstract of Canvass:</label>
                        <input type="text" id="Abstract" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                        <input type="text" id="Abstract" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Amount" class="block text-gray-700 text-sm dark:text-white mb-2">Amount:</label>
                        <input type="text" id="Amount" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Supplier" class="block text-gray-700 text-sm dark:text-white mb-2">Supplier:</label>
                        <input type="text" id="Supplier" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Date_Request" class="block text-gray-700 text-sm dark:text-white mb-2">Date Request for Fund:</label>
                        <input type="text" id="Date_Request" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Ideal_No" class="block text-gray-700 text-sm dark:text-white mb-2">Ideal No. of Days to Complete:</label>
                        <input type="text" id="Ideal_No" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Actual_days" class="block text-gray-700 text-sm dark:text-white mb-2">Actual Days Completed:</label>
                        <input type="text" id="Actual_days" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Difference" class="block text-gray-700 text-sm dark:text-white mb-2">Difference:</label>
                        <input type="text" id="Difference" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Order:</label>
                        <input type="text" id="Purchase" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Delivery_Status" class="block text-gray-700 text-sm dark:text-white mb-2">Delivery Status:</label>
                        <input type="text" id="Delivery_Status" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="md:px-8">
                        <label for="Remarks" class="block text-gray-700 text-sm dark:text-white mb-2">Remarks:</label>
                        <input type="text" id="Remarks" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
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
/* Your CSS here */
</style>
