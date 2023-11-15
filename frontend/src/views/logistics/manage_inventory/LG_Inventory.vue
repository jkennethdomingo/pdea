<script setup>
import { ref, onMounted } from 'vue';
import ReusableTable from '@/components/flowbite/ReusableTable.vue';
import { initDropdowns } from 'flowbite';

const tableHeaders = [
  { key: 'Date', text: 'Date of Receipt of Request' },
  { key: 'Project', text: 'Project/Particular' },
  { key: 'End', text: 'End-User' },
  { key: 'Purchase', text: 'Purchase/Work/Job Request',
  columns: [
      { key: 'No', text: 'No' },
      { key: 'Date', text: 'Date' }
    ] },
  { key: 'Philgeps', text: 'Philgeps' },
  { key: 'Price', text: 'Price Quotation' },
  { key: 'Abstract', text: 'Abstract of Canvass' },
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
  // ... other headers
];


const tableRows = ref([
  {
    Date: '2023-11-01',
    Project: 'Project Alpha',
    End: 'User A',
    Purchase: {
      No: 'PR001',
      Date: '2023-11-02'
    },
    Philgeps: 'Registered',
    Price: '$500',
    Abstract: 'Canvas 1',
    Amount: '$1000',
    Supplier: 'Supplier X',
    Date_Request: '2023-11-03',
    Ideal_No: '30',
    Actual_days: '28',
    Difference: '2',
    Purchase: 'Order 123',
    Delivery_Status: 'Delivered',
    Remarks: 'On time',
    Action: 'Review'
  },
  {
    Date: '2023-11-05',
    Project: 'Project Beta',
    End: 'User B',
    Purchase: {
      No: 'PR002',
      Date: '2023-11-06'
    },
    Philgeps: 'Not Registered',
    Price: '$300',
    Abstract: 'Canvas 2',
    Amount: '$800',
    Supplier: 'Supplier Y',
    Date_Request: '2023-11-07',
    Ideal_No: '25',
    Actual_days: '20',
    Difference: '5',
    Purchase: 'Order 456',
    Delivery_Status: 'Pending',
    Remarks: 'Delayed',
    Action: 'Escalate'
  },
  // ... more rows as needed
]);


// Define actions and filters if needed
const actions = ref([
  { label: 'Edit', action: 'edit' },
  { label: 'Delete', action: 'delete' }
]);

const filters = ref([
  // Define your filters here
]);

const handleAction = (action) => {
  // Handle your action here
  // Example: if (action === 'edit') { /* Open edit modal */ }
};

onMounted(() => {
  initDropdowns();
});
</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 rounded-lg">
      <div class="mx-auto max-w-screen-xl px-4 max-h-[76vh] overflow-y-scroll">
        <div class="relative shadow-md rounded-lg overflow-hidden">
          <ReusableTable :headers="tableHeaders" :rows="tableRows" :actions="actions" :filters="filters" @action="handleAction" />
        </div>
      </div>
    </section>
  </template>
  
  <style scoped>
    /* Your existing styles */
  </style>
  