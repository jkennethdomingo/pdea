<script setup>
import { ref, onMounted, computed } from 'vue';
import ReusableTable from '@/components/flowbite/PropertyMonitoringTable.vue';
import { initDropdowns } from 'flowbite';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';




const store = useStore();

const isLoading = computed(() => store.state.isLoading);

// Fetch and compute the table rows based on the Vuex state
const filteredTableRows = computed(() => {
  const isActiveChecked = filters.value.find(f => f.id === 'Active').checked;
  const isArchivedChecked = filters.value.find(f => f.id === 'Archived').checked;

  if (isActiveChecked && isArchivedChecked) {
    // Combine both active and archived data
    return [...store.state.activeProcurementData, ...store.state.archivedProcurementData];
  } else if (isActiveChecked) {
    // Only active data
    return store.state.activeProcurementData;
  } else if (isArchivedChecked) {
    // Only archived data
    return store.state.archivedProcurementData;
  } else {
    // If neither is checked, you can decide to return either empty array or all data
    return [];
  }
});


// Fetch data on component mount
onMounted(async () => {
  await store.dispatch('getPropertyPlantAndEquipment'); 
  initDropdowns();
});



</script>

<template>
  <section class="p-3 sm:p-5 rounded-lg">
    
    <div v-if="isLoading" class="flex justify-center items-center">
        <span>Loading...</span> <!-- Replace with a spinner or a loading component -->
      </div>
      <div v-else class="mx-auto max-w-screen-xl px-1 max-h-[76vh] overflow-hidden">
        <div class="relative overflow-hidden">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="flex items-center space-x-4">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-42">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                    </div>
                </form>
                <Button class="bg-green-700 dark:bg-green-600 ml-4" :to="{ name: 'LG_Property_Add' }">Input Details</Button>
            </div>

                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filter
                            <svg class="-m2-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <label class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input type="checkbox" class="mr-2">
                                    Active
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input type="checkbox" class="mr-2">
                                    Archived
                                </label>
                            </li>
                        </ul>
                    </div>

                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-green-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-green-400">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-center">ARTICLE</th>
                            <th scope="col" class="px-4 py-3 text-center">DESCRIPTION</th>
                            <th scope="col" class="px-4 py-3 text-center">YEAR ACQUIRED</th>
                            <th scope="col" class="px-4 py-3 text-center">SERIAL NUMBER</th>
                            <th scope="col" class="px-4 py-3 text-center">PROPERTY NUMBER</th>
                            <th scope="col" class="px-4 py-3 text-center">UNIT OF MEASURE</th>
                            <th scope="col" class="px-4 py-3 text-center">UNIT OF VALUE</th>
                            <th scope="col" class="px-4 py-3 text-center">QUANTITY PER PROPERTY CARD</th>
                            <th scope="col" class="px-4 py-3 text-center">QUANTITY PER PHYSICAL COUNT</th>
                            <th scope="col" class="px-4 py-3 text-center">SHORTAGE/OVERAGE OF QUANTITY</th>
                            <th scope="col" class="px-4 py-3 text-center">SHORTAGE/OVERAGE OF VALUE</th>
                            <th scope="col" class="px-4 py-3 text-center">STATUS</th>
                            <th scope="col" class="px-4 py-3 text-center">REMARKS & WHERE ABOUTS</th>
                            <th scope="col" class="px-4 py-3 text-center">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>


                   
                </table>
            </div>
            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                </span>
                <ul class="inline-flex items-stretch -space-x-px">
                    <li>
                        <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
        </div>
      </div>
    </section>
  </template>
  
  <style scoped>
    /* Your existing styles */
  </style>
  