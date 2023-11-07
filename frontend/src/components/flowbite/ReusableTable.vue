<template>
  <PerfectScrollbar ref="scrollContainerRef" class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-4 py-3" v-for="header in headers" :key="header.key">
            {{ header.text }}
          </th>
          <th scope="col" class="px-4 py-3">
            <span class="sr-only">Actions</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-b dark:border-gray-700" v-for="(row, rowIndex) in rows" :key="`row-${rowIndex}`">
          <td class="px-4 py-3" v-for="(value, key) in row" :key="`cell-${rowIndex}-${key}`">
            {{ value }}
          </td>
          <td class="px-4 py-3 flex items-center justify-end">
              <button id="xbox-series-x-dropdown-button" data-dropdown-toggle="xbox-series-x-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                  <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                  </svg>
              </button>
              <div id="xbox-series-x-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="xbox-series-x-dropdown-button">
                      <li>
                          <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                      </li>
                      <li>
                          <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                      </li>
                  </ul>
                  <div class="py-1">
                      <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                  </div>
              </div>
          </td>
        </tr>
      </tbody>
    </table>
  </PerfectScrollbar>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import PerfectScrollbar from '@/components/PerfectScrollbar.vue';
import Button from '@/components/Button.vue';
import { initDropdowns } from 'flowbite';

const scrollContainerRef = ref(null);
const props = defineProps({
  headers: Array,
  rows: Array
});

const emit = defineEmits(['action']);

onMounted(() => {
  initDropdowns();
  // Any additional logic for onMounted
});

function emitAction(action, rowData) {
  emit('action', { action, rowData });
}
</script>
