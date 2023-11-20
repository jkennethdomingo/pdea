<script setup>
import { ref, onMounted, computed } from 'vue';
import ReusableTable from '@/components/flowbite/ReusableTable.vue';
import { initDropdowns } from 'flowbite';
import { useStore } from 'vuex';
import Button from '@/components/base/Button';


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
{ key: 'date_of_receipt_of_request', text: 'Date of Receipt of Request' },
{ key: 'procurement_status', text: 'Procurement Status' },
  { key: 'project_particulars', text: 'Project/Particular' },
  { key: 'endUser', text: 'End-User' },
  { key: 'purchase_work_job_request_no', text: 'Purchase/Work/Job Request Number'},
  { key: 'purchase_work_job_request_date', text: 'Purchase/Work/Job Request Date'},
  { key: 'philgeps_posting', text: 'Philgeps' },
  { key: 'price_quotation_no', text: 'Price Quotation Number' },
  { key: 'price_quotation_date', text: 'Price Quotation Date' },
  { key: 'abstract_of_canvas_no', text: 'Abstract of Canvass Number' },
  { key: 'abstract_of_canvas_date', text: 'Abstract of Canvass Date' },
  { key: 'amount', text: 'Amount' },
  { key: 'supplier', text: 'Supplier' },
  { key: 'date_request_for_fund', text: 'Date Request for Fund' },
  { key: 'ideal_no_of_days_to_complete', text: 'Ideal_No. of days to complete' },
  { key: 'actual_days_to_complete', text: 'Actual days Completed' },
  { key: 'difference', text: 'Difference' },
  { key: 'purchase_order', text: 'Purchase/Work/Job Order' },
  { key: 'delivery_status', text: 'Delivery_Status' },
  { key: 'remarks', text: 'Remarks' },
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
  
};


</script>

<template>
  <section class="p-3 sm:p-5 rounded-lg">
    
    <div v-if="isLoading" class="flex justify-center items-center">
        <span>Loading...</span> <!-- Replace with a spinner or a loading component -->
      </div>
      <div v-else class="mx-auto max-w-screen-xl px-1 max-h-[76vh] overflow-hidden">
        <div class="relative overflow-hidden">
          <ReusableTable :headers="tableHeaders" :rows="tableRows" :actions="actions" :filters="filters" @action="handleAction" />
        </div>
      </div>
    </section>
  </template>
  
  <style scoped>
    /* Your existing styles */
  </style>
  