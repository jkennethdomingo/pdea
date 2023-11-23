<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import PageWrapper from '@/components/layout/PageWrapper.vue';
import procurementStatusData from '@/assets/json/procurement_status.json';
import { errorToast, successToast } from '@/toast/index';
import Button from '@/components/base/Button';

const procurementStatus = procurementStatusData.statuses;

const store = useStore();
// Create a reactive object for your form data
const formData = ref({
  status_name: '',
  date_of_receipt_of_request: '',
  project_particulars: '',
  endUser: '',
  purchase_work_job_request_no: '',
  purchase_work_job_request_date: '',
  philgeps_posting: '',
  price_quotation_no: '',
  price_quotation_date: '',
  abstract_of_canvas_no: '',
  abstract_of_canvas_date: '',
  amount: '',
  supplier: '',
  date_request_for_fund: '',
  ideal_no_of_days_to_complete: '',
  actual_days_to_complete: '',
  difference: '',
  purchase_order: '',
  delivery_status: '',
  remarks: '',
  endUserType: '',
  // ... add all other form fields here
});

onMounted(() => {
  store.dispatch('getData');
});


const endUserTypeOptions = [
  { value: 'personal', label: 'Personal' },
  { value: 'department', label: 'Department' },
  { value: 'province', label: 'Province' },
  { value: 'region', label: 'Regional' },
  // Add other types if necessary
];

// Computed property to determine End-User dropdown options
const endUserOptions = computed(() => {
  switch (formData.value.endUserType) {
    case 'personal':
      return store.state.dropdownData.personal_information.map(person => ({
        value: person.EmployeeID,
        label: `${person.first_name} ${person.surname}`
      }));
    case 'department':
      return store.state.dropdownData.department.map(dept => ({
        value: dept.department_id,
        label: dept.department_name
      }));
    case 'province':
      return store.state.dropdownData.provincial_office.map(dept => ({
        value: dept.provincial_office_id,
        label: dept.office_name
      }));
    case 'region':
      return store.state.dropdownData.regional_office.map(dept => ({
        value: dept.regional_office_id,
        label: dept.regional_office_name
      }));
    // Add other cases if necessary
    default:
      return [];
  }
});

const updateIdealDays = (event) => {
    const value = event.target.value;
    if (value === '') {
        formData.value.ideal_no_of_days_to_complete = 0;
    } else if (!isNaN(value)) {
        formData.value.ideal_no_of_days_to_complete = Number(value);
    } else {
        event.target.value = formData.value.ideal_no_of_days_to_complete;
    }
};

const updateActualDays = (event) => {
    const value = event.target.value;
    if (value === '') {
        formData.value.actual_days_to_complete = 0;
    } else if (!isNaN(value)) {
        formData.value.actual_days_to_complete = Number(value);
    } else {
        event.target.value = formData.value.actual_days_to_complete;
    }
};
const difference = computed(() => {
    return formData.value.actual_days_to_complete - formData.value.ideal_no_of_days_to_complete;
});

watch(difference, (newDifference) => {
    formData.value.difference = newDifference;
});



watch(formData, (newValue) => {
  console.log('Form Data Updated:', newValue);
}, { deep: true });

const clearForm = () => {
  for (const key in formData.value) {
    if (typeof formData.value[key] === 'number') {
      formData.value[key] = 0;
    } else {
      formData.value[key] = '';
    }
  }
};


// Form submission handler
const isSubmitting = ref(false);

const submitForm = async () => {
  if (isSubmitting.value) {
    return; // Prevents further execution if a submission is already in progress
  }

  try {
    isSubmitting.value = true; // Indicates that submission is in progress

    // Dispatch the Vuex action with the form data
    await store.dispatch('addInventory', formData.value);
    successToast('Form submitted successfully.');
    clearForm();

    // Optionally, handle post-submission logic (e.g., clear form, show success message)
  } catch (error) {
    console.error('Error submitting form:', error);
    errorToast('Error submitting form. Please try again.');
    // Handle the error, e.g., show an error message to the user
  } finally {
    isSubmitting.value = false; // Resets the submission state
  }
};

</script>

<template>
  <PageWrapper>
  
  <br>
  <form @submit.prevent="submitForm">
    <Button class="dark:bg-green-600" :to="{ name: 'LG_Property_Monitoring' }">View Details</Button>
<div class="grid grid-cols-4 gap-4 pt-2">
      <div>
        <label for="status_name" class="block text-gray-700 text-sm dark:text-white mb-2">Procurement Status:</label>
        <select id="status_name" v-model="formData.status_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
          <option v-for="pc in procurementStatus" :key="pc.value" :value="pc.value">
            {{ pc.label }}
          </option>
        </select>
      </div>
      <div>
        <label for="Date" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Receipt of Request:</label>
        <input type="date" id="Date" v-model="formData.date_of_receipt_of_request" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Project" class="block text-gray-700 text-sm dark:text-white mb-2">Project/Particulars:</label>
        <input type="text" id="Project" v-model="formData.project_particulars"  class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="EndUserType" class="block text-gray-700 text-sm dark:text-white mb-2">End-User Type:</label>
        <select id="EndUserType" v-model="formData.endUserType" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
          <option value="" disabled>Select Type</option>
          <option v-for="option in endUserTypeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
        </select>
      </div>
      <div>
        <label for="EndUser" class="block text-gray-700 text-sm dark:text-white mb-2">End-User:</label>
        <select id="EndUser" v-model="formData.endUser" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
          <option value="" disabled>Select User</option>
          <option v-for="option in endUserOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
        </select>
      </div>
      <div>
        <label for="Purchase" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Request:</label>
        <input type="text" id="Purchase1" placeholder="No" v-model="formData.purchase_work_job_request_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="date" id="Purchase2" placeholder="Date" v-model="formData.purchase_work_job_request_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div class="flex items-center mb-4">
          <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Philgeps:</label>
          <input id="Philgeps" type="checkbox" v-model="formData.philgeps_posting" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
      </div>
      <div>
        <label for="Price" class="block text-gray-700 text-sm dark:text-white mb-2">Price Quotation:</label>
        <input type="text" id="Price1" placeholder="No" v-model="formData.price_quotation_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="date" id="Price2" placeholder="Date" v-model="formData.price_quotation_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Abstract" class="block text-gray-700 text-sm dark:text-white mb-2">Abstract of Canvass:</label>
        <input type="text" id="Abstract1" placeholder="No" v-model="formData.abstract_of_canvas_no" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        <input type="date" id="Abstract2" placeholder="Date" v-model="formData.abstract_of_canvas_date" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Amount" class="block text-gray-700 text-sm dark:text-white mb-2">Amount:</label>
        <input type="text" id="Amount" v-model="formData.amount" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Supplier" class="block text-gray-700 text-sm dark:text-white mb-2">Supplier:</label>
        <input type="text" id="Supplier" v-model="formData.supplier" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Date_Request" class="block text-gray-700 text-sm dark:text-white mb-2">Date Request for Fund:</label>
        <input type="date" id="Date_Request" v-model="formData.date_request_for_fund" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Ideal_No" class="block text-gray-700 text-sm dark:text-white mb-2">Ideal No. of Days to Complete:</label>
        <input type="text" id="Ideal_No" :value="formData.ideal_no_of_days_to_complete" @input="updateIdealDays($event)" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div>
        <label for="Actual_days" class="block text-gray-700 text-sm dark:text-white mb-2">Actual Days Completed:</label>
        <input type="text" id="Actual_days" :value="formData.actual_days_to_complete" @input="updateActualDays($event)" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div>
    <label for="Difference" class="block text-gray-700 text-sm dark:text-white mb-2">Difference:</label>
    <input type="text" id="Difference" :value="formData.difference" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline" readonly>
</div>

      <div>
        <label for="PurchaseOrder" class="block text-gray-700 text-sm dark:text-white mb-2">Purchase/Work/Job Order:</label>
        <input type="text" id="PurchaseOrder" v-model="formData.purchase_order" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Delivery_Status" class="block text-gray-700 text-sm dark:text-white mb-2">Delivery Status:</label>
        <input type="text" id="Delivery_Status" v-model="formData.delivery_status" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="Remarks" class="block text-gray-700 text-sm dark:text-white mb-2">Remarks:</label>
        <input type="text" id="Remarks" v-model="formData.remarks" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
    
    </div>
<div class="flex justify-end">
  <Button class="dark:bg-green-600 mt-4" @click="submitForm">Submit</Button>
</div>


    </form>
</PageWrapper>
        
</template>

<style lang="">
    
</style>
 