<script setup>
import { ref, onMounted, computed,  watchEffect } from 'vue';
import ReusableTable from '@/components/flowbite/ReusableTable.vue';
import { initDropdowns } from 'flowbite';
import { useStore } from 'vuex';


const store = useStore();
const tableRows = computed(() => {
  // Assuming your Vuex state has a structure like { procurementData: { procurement: [...] } }
  const procurementData = store.state.procurementData.procurement;
  if (Array.isArray(procurementData)) {
    return procurementData.map(item => ({
      Date: item.date_of_receipt_of_request,
      ProjectParticulars: item.project_particulars,
      End: item.department_id, // Assuming 'End' corresponds to 'department_id' //TODO ayusin ang fetch
      PurchaseNo: item.purchase_work_job_request_no,
      PurchaseDate: item.purchase_work_job_request_date,
      Philgeps: item.philgeps_posting === '1' ? 'Registered' : 'Not Registered',
      PriceNo: item.price_quotation_no,
      PriceDate: item.price_quotation_date,
      AbstractNo: item.abstract_of_canvas_no,
      AbstractDate: item.abstract_of_canvas_date,
      Amount: item.amount,
      Supplier: item.supplier,
      DateRequest: item.date_request_for_fund,
      IdealNo: item.ideal_no_of_days_to_complete,
      ActualDays: item.actual_days_to_complete,
      Difference: item.difference,
      PurchaseOrder: item.purchase_order,
      DeliveryStatus: item.delivery_status,
      Remarks: item.remarks,
      // ... other fields as required
    }));
  }
  return []; // Return an empty array if data is not an array
});


onMounted(async () => {
  await store.dispatch('getInventoryData');
  initDropdowns();
});

const tableHeaders = [
  { key: 'Date', text: 'Date of Receipt of Request' },
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
  // ... other headers
];



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
  