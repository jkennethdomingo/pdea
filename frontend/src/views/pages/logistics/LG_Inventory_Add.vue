<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import PageWrapper from '@/components/layout/PageWrapper.vue';


</script>

<template>
    <div class="mb-4 grid grid-cols-4 gap-4">
      <div>
        <label for="spouse_surname" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
        <input type="text" id="spouse_surname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulara:</label>
        <input type="text" id="spouse_first_name"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
        <input type="text" id="spouse_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
        <input type="text" id="spouse_name_extension" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="spouse_name_extension" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Philgeps:</label>
        <input type="text" id="spouse_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Price Quotation:</label>
        <input type="text" id="spouse_name_extension" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="spouse_name_extension" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Abstract of Canvass:</label>
        <input type="text" id="spouse_name_extension" placeholder="No" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="text" id="spouse_name_extension" placeholder="Date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Amount:</label>
        <input type="text" id="spouse_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="spouse_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Supplier:</label>
        <input type="text" id="spouse_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>
    
        
</template>

<style lang="">
    
</style>
 