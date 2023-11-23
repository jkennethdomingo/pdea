<script setup>
import { ref, onMounted, computed } from 'vue';
import ReusableTable from '@/components/flowbite/PropertyMonitoringTable.vue';
import { initDropdowns } from 'flowbite';
import { useStore } from 'vuex';



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
  await store.dispatch('getInventoryData'); 
  initDropdowns();
});

// Define the headers for your table based on the key names used in tableRows
const tableHeaders = [
{ key: 'asset_type_name', text: 'Article' },
{ key: 'description', text: 'Description' },
  { key: 'yr_acquired', text: 'Year Acquired' },
  { key: 'serial_number', text: 'Serial Number' },
  { key: 'property_number', text: 'Property Number'},
  { key: 'unit_of_measure', text: 'Unit of Measure'},
  { key: 'unit_value	', text: 'Unit of Value' },
  { key: 'qty_per_property_card', text: 'Quantity Per Property Card' },
  { key: 'physical_count', text: 'Quantity Per Physical Count' },
  { key: 'shortage_overage_qty', text: 'Shortage/Overage of Quantity' },
  { key: 'shortage_overage_value', text: 'Shortage/Overage of Value' },
  { key: 'status', text: 'Status' },
  { key: 'remarks_whereabouts', text: 'Remarks & Where Abouts' },
];

// Define actions and filters if needed
const actions = ref([
  { label: 'Edit', action: 'edit' },
  { label: 'Delete', action: 'delete' }
]);

// Define filters if needed
const filters = ref([
{ id: 'Active', label: 'Active', checked: true },
  { id: 'Archived', label: 'Archived', checked: false },
]);

const handleAction = (action, item) => {
  
};


</script>

<template>
  <section class="p-3 sm:p-5 rounded-lg">
    
    <div v-if="isLoading" class="flex justify-center items-center">
        <span>Loading...</span> <!-- Replace with a spinner or a loading component -->
      </div>
      <div v-else class="mx-auto max-w-screen-xl px-1 max-h-[76vh] overflow-hidden">
        <div class="relative overflow-hidden">
          <ReusableTable :headers="tableHeaders" :rows="filteredTableRows" :actions="actions" :filters="filters" @action="handleAction" />
        </div>
      </div>
    </section>
  </template>
  
  <style scoped>
    /* Your existing styles */
  </style>
  