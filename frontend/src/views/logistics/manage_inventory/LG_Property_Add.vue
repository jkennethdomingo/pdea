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
  asset_type_name: '',
  description: '',
  yr_acquired: '',
  serial_number: '',
  property_number: '',
  unit_of_measure: '',
  unit_value: '',
  qty_per_property_card: '',
  physical_count: '',
  shortage_overage_qty: '',
  shortage_overage_value: '',
  status: '',
  remarks_whereabouts: '',
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

  <form @submit.prevent="submitForm">
    <Button class="dark:bg-green-600" :to="{ name: 'LG_Property_Monitoring' }">View Details</Button>
<div class="grid grid-cols-3 gap-4 pt-2">
      <div>
        <label for="asset_type_name" class="block text-gray-700 text-sm dark:text-white mb-2">Article:</label>
        <select id="asset_type_name" v-model="formData.asset_type_name" class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
          <option v-for="pc in propertyStatus" :key="pc.value" :value="pc.value">
            {{ pc.label }}
          </option>
        </select>
      </div>
      <div>
        <label for="description" class="block text-gray-700 text-sm dark:text-white mb-2">Description:</label>
        <input type="text" id="description" v-model="formData.description" class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="yr_acquired" class="block text-gray-700 text-sm dark:text-white mb-2">Year Acquired:</label>
        <input type="date" id="yr_acquired" v-model="formData.yr_acquired"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="serial_number" class="block text-gray-700 text-sm dark:text-white mb-2">Serial Number:</label>
        <input type="text" id="serial_number" v-model="formData.serial_number"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="property_number" class="block text-gray-700 text-sm dark:text-white mb-2">Property Number:</label>
        <input type="text" id="property_number" v-model="formData.property_number"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="unit_of_measure" class="block text-gray-700 text-sm dark:text-white mb-2">Unit of Measure:</label>
        <input type="text" id="unit_of_measure" v-model="formData.unit_of_measure"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="unit_value" class="block text-gray-700 text-sm dark:text-white mb-2">Unit of Value:</label>
        <input type="text" id="unit_value" v-model="formData.unit_value"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="qty_per_property_card" class="block text-gray-700 text-sm dark:text-white mb-2">Quantity Per Property Card:</label>
        <input type="text" id="qty_per_property_card" v-model="formData.qty_per_property_card"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="physical_count" class="block text-gray-700 text-sm dark:text-white mb-2">Quantity Per Physical Count:</label>
        <input type="text" id="physical_count" v-model="formData.physical_count"  class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div> 
      <div>
        <label for="shortage_overage_qty" class="block text-gray-700 text-sm dark:text-white mb-2">Shortage/Overage of Quantity:</label>
        <input type="text" id="shortage_overage_qty" v-model="formData.shortage_overage_qty" class="shadow border  dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="shortage_overage_value" class="block text-gray-700 text-sm dark:text-white mb-2">Shortage/Overage of Value:</label>
        <input type="text" id="shortage_overage_value" v-model="formData.shortage_overage_value" class="shadow border  dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="status" class="block text-gray-700 text-sm dark:text-white mb-2">Status:</label>
        <input type="text" id="status" v-model="formData.status" class="shadow border  dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="remarks_whereabouts" class="block text-gray-700 text-sm dark:text-white mb-2">Remarks & Where Abouts:</label>
        <input type="text" id="remarks_whereabouts" v-model="formData.remarks_whereabouts" class="shadow border  dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
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
 