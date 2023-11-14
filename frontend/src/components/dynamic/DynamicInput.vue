<script setup>
import { defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
  count: Number,
  countLabel: String,
  headers: Array,
  data: Array,
});

const emit = defineEmits(['update:count', 'update:data']);

// Update the count and emit the event
const updateCount = (newCount) => {
  emit('update:count', newCount);
};

// Watch the count prop for changes
watch(() => props.count, (newCount) => {
  // Adjust the data array based on the new count
  const newData = [];
  for (let i = 0; i < newCount; i++) {
    if (props.data[i]) {
      // If existing data is present for this index, use it
      newData.push(props.data[i]);
    } else {
      // Otherwise, create a new entry with default values
      const defaultEntry = {};
      props.headers.forEach(header => {
        defaultEntry[header.key] = ''; // Initialize with empty string or any default value
      });
      newData.push(defaultEntry);
    }
  }

  // Emit the updated data array
  emit('update:data', newData);
});
</script>


<template>
    <div>
      <div class="max-w-sm mx-auto">
        <label for="count" class="block text-gray-700 text-sm dark:text-white mb-2">{{ countLabel }}</label>
        <input type="number" id="count" min="0" :value="count" @input="updateCount($event.target.valueAsNumber)" class="shadow border dark:bg-dark-eval-2 rounded py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline text-center">
      </div>
  
      <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th v-for="(header, headerIndex) in headers" :key="headerIndex" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ header.label }}
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(row, rowIndex) in data" :key="rowIndex">
          <td v-for="(header, headerIndex) in headers" :key="headerIndex" class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <input :id="`input_${rowIndex}_${headerIndex}`" :type="header.type" :min="header.min"
                :max="header.max" v-model="row[header.key]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </template>
  