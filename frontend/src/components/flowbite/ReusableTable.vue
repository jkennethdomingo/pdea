<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue';
import PerfectScrollbar from '@/components/base/PerfectScrollbar.vue';
import Button from '@/components/base/Button.vue';
import { initDropdowns } from 'flowbite';
import DeleteModal from '@/components/modals/Delete.vue';
import EditModal from '@/components/modals/Edit.vue';
import ViewModal from '@/components/modals/View.vue';

const scrollContainerRef = ref(null);
const props = defineProps({
  headers: Array,
  rows: Array,
  actions: Array, // New prop for actions
  filters: Array  // New prop for filters
});

const emit = defineEmits(['action']);
const searchQuery = ref('');
const currentPage = ref(1);
const pageSize = 10; // Adjust as needed
const totalRows = computed(() => filteredRows.value.length);
const totalPages = computed(() => Math.ceil(totalRows.value / pageSize));

const filteredRows = computed(() => {
  return props.rows.filter(row =>
    Object.values(row).some(
      value => value.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  );
});

const paginatedRows = computed(() => {
  const start = (currentPage.value - 1) * pageSize;
  const end = start + pageSize;
  return filteredRows.value.slice(start, end);
});

function emitAction(actionType, rowData) {
  emit('action', { actionType, rowData });
}

function changePage(page) {
  currentPage.value = page;
}

watch(searchQuery, () => {
  currentPage.value = 1; // Reset to first page on new search
});

onMounted(() => {
  initDropdowns();
  // Any additional logic for onMounted
});

const isDeleteModalVisible = ref(false);
const isEditModalVisible = ref(false);
const isViewModalVisible = ref(false);
const selectedItem = ref(null);

function openDeleteModal(item) {
  selectedItem.value = item;
  isDeleteModalVisible.value = true;
}

function openEditModal(item) {
  selectedItem.value = item;
  isEditModalVisible.value = true;
}

function openViewModal(item) {
  selectedItem.value = item;
  isViewModalVisible.value = true;
}

function handleConfirm() {
  console.log('Confirm clicked');
  emitAction('delete', selectedItem.value);
  isDeleteModalVisible.value = false;
}

function handleCancel() {
  console.log('Cancel clicked');
  isDeleteModalVisible.value = false;
  isEditModalVisible.value = false;
  isViewModalVisible.value = false;
}

</script>


<template>
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
    <div class="w-full md:w-1/2">
      <form class="flex items-center">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
          <!-- Search Icon (Placeholder) -->
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
          </div>
          <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" v-model="searchQuery">
        </div>
      </form>
    </div>

    <!-- Actions Dropdown -->
    <div v-if="actions && actions.length" class="w-full md:w-auto">
      <!-- [Dropdown Trigger Button Code] -->
      <div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-600 shadow dark:bg-gray-700 dark:divide-gray-600">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
          <li v-for="action in actions" :key="action.label">
            <a href="#" @click.prevent="emitAction(action.action)" class="block py-2 px-4 text-black hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white dark:hover:text-white">
              {{ action.label }}
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Filters Dropdown -->
    <div v-if="filters && filters.length" class="w-full md:w-auto">
      <!-- [Dropdown Trigger Button Code] -->
      <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
        <h6 class="mb-3 text-sm font-medium text-black dark:text-white">Filter options</h6>
        <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
          <li v-for="filter in filters" :key="filter.value" class="flex items-center">
            <input :id="filter.value" type="checkbox" :value="filter.value" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" v-model="filter.checked">
            <label :for="filter.value" class="ml-2 text-sm font-medium text-black dark:text-gray-100">{{ filter.label }}</label>
          </li>
        </ul>
      </div>
    </div>
  </div>

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
        <tr class="border-b dark:border-gray-700" v-for="(row, rowIndex) in paginatedRows" :key="`row-${rowIndex}`">
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
                          <a href="#"  @click.prevent="openViewModal(row)" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View</a>
                      </li>
                      <li>
                        <a href="#" @click.prevent="openEditModal(row)" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            Edit
                        </a>
                      </li>
                  </ul>
                  <div class="py-1">
                    <a 
                      href="#"
                      @click.prevent="openDeleteModal(row)" 
                      class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                      Archive
                    </a>
                  </div>
              </div>
          </td>
        </tr>
      </tbody>
    </table>
  </PerfectScrollbar>

  <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
      Showing 
      <span class="font-semibold text-gray-900 dark:text-white">{{ (currentPage - 1) * pageSize + 1 }}</span>
      to 
      <span class="font-semibold text-gray-900 dark:text-white">{{ Math.min(currentPage * pageSize, totalRows) }}</span>
      of 
      <span class="font-semibold text-gray-900 dark:text-white">{{ totalRows }}</span> entries
    </span>
    <ul class="inline-flex items-stretch -space-x-px">
      <li>
        <a href="#" @click="changePage(currentPage - 1)" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          <span class="sr-only">Previous</span>
          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
        </a>
      </li>
      <li v-for="page in totalPages" :key="page">
        <a href="#" @click="changePage(page)" :class="{'z-10 text-primary-600 bg-primary-50 border-primary-300 dark:text-white': page === currentPage, 'text-gray-500 bg-white dark:bg-gray-800 dark:text-gray-400': page !== currentPage}" class="flex items-center justify-center text-sm py-2 px-3 leading-tight border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-white">
          {{ page }}
        </a>
      </li>
      <li>
        <a href="#" @click="changePage(currentPage + 1)" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          <span class="sr-only">Next</span>
          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
        </a>
      </li>
    </ul>
  </nav>
  <DeleteModal
    :isVisible="isDeleteModalVisible"
    @confirm="handleConfirm"
    @cancel="handleCancel"
    message="Are you sure you want to Archive this item?"
  />
  <EditModal
    :isVisible="isEditModalVisible"
    @cancel="handleCancel"
    message="Are you sure you want to edit this item?"
  />
  <ViewModal
    :isVisible="isViewModalVisible"
    @cancel="handleCancel"
    message="Are you sure you want to view this item?"
  />
</template>

