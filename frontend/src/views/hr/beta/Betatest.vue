<template>
  <VDatePicker v-model="range" is-range>
    <template #default="{ inputValue, inputEvents }">
      <div class="flex justify-center items-center">
        <!-- From Date Input -->
        <input 
          type="date"
          :value="formatDate(inputValue.start)" 
          @input="inputEvents.start.$event(inputValue.start)"
          class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline"
          placeholder="From"
        />
        <IconArrowRight />
        <!-- To Date Input -->
        <input 
          type="date"
          :value="formatDate(inputValue.end)" 
          @input="inputEvents.end.$event(inputValue.end)"
          class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline"
          placeholder="To"
        />
      </div>
    </template>
  </VDatePicker>
</template>

<script setup>
import { ref } from 'vue';

const range = ref({
  start: new Date(2020, 9, 12),
  end: new Date(2020, 9, 16),
});

// Helper function to format Date object to string for input[type=date]
function formatDate(date) {
  if (!date) return '';
  const d = new Date(date);
  let month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) month = '0' + month;
  if (day.length < 2) day = '0' + day;

  return [year, month, day].join('-');
}
</script>
