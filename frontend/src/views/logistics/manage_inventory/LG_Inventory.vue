<script setup>
import { ref, onMounted, computed } from 'vue';
import ReusableTable from '@/components/flowbite/ReusableTable.vue';
import { initDropdowns } from 'flowbite';
import { useStore } from 'vuex';

const store = useStore();

const isLoading = computed(() => store.state.isLoading);

// Fetch and compute the table rows based on the Vuex state
const tableRows = computed(() => store.state.procurementData);

// Fetch data on component mount
onMounted(async () => {
  await store.dispatch('getInventoryData');
  initDropdowns();
});

// Define the headers for your table based on the key names used in tableRows
const tableHeaders = [
{ key: 'Date', text: 'Date of Receipt of Request' },
{ key: 'Status', text: 'Procurement Status' },
  { key: 'Project', text: 'Project/Particular' },
  { key: 'End', text: 'End-User' },
  { key: 'PurchaseNo', text: 'Purchase/Work/Job Request Number'},
  { key: 'PurchaseDate', text: 'Purchase/Work/Job Request Date'},
  { key: 'Philgeps', text: 'Philgeps' },
  { key: 'PriceNo', text: 'Price Quotation Number' },
  { key: 'PriceDate', text: 'Price Quotation Date' },
  { key: 'AbstractNo', text: 'Abstract of Canvass Number' },
  { key: 'AbstractDate', text: 'Abstract of Canvass Date' },
  { key: 'Amount', text: 'Amount' },
  { key: 'Supplier', text: 'Supplier' },
  { key: 'Date_Request', text: 'Date Request for Fund' },
  { key: 'Ideal_No', text: 'Ideal_No. of days to complete' },
  { key: 'Actual_days', text: 'Actual days Completed' },
  { key: 'Difference', text: 'Difference' },
  { key: 'Purchase', text: 'Purchase/Work/Job Order' },
  { key: 'Delivery_Status', text: 'Delivery_Status' },
  { key: 'Remarks', text: 'Remarks' },
  { key: 'Action', text: 'Action' },
];

// Define actions and filters if needed
const actions = ref([
  { label: 'Edit', action: 'edit' },
  { label: 'Delete', action: 'delete' }
]);

// Define filters if needed
const filters = ref([
  // ... your filter definitions
]);

const handleAction = (action, item) => {
  // Handle your action here
  // Example: if (action === 'edit') { /* Open edit modal with item */ }
};


</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 rounded-lg">
      <div v-if="isLoading" class="flex justify-center items-center">
        <span>Loading...</span> <!-- Replace with a spinner or a loading component -->
      </div>
      <div v-else class="mx-auto max-w-screen-xl px-4 max-h-[76vh] overflow-y-scroll">
        <div class="relative shadow-md rounded-lg overflow-hidden">
          <ReusableTable :headers="tableHeaders" :rows="tableRows" :actions="actions" :filters="filters" @action="handleAction" />
        </div>
      </div>
    </section>
  </template>
  
  <style scoped>
    /* Your existing styles */
  </style>
  