<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import PageWrapper from '@/components/layout/PageWrapper.vue';
import Button from '@/components/base/Button';
import apiService from '@/composables/axios-setup';


const store = useStore();
// Create a reactive object for your form data
const formData = ref({
  article: '',
  asset_type_id: '',
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
  store.dispatch('getAssetType');
});

const assetTypes = computed(() => {
  // Access asset types from the store
  return store.state.asset_type;
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
  try {
    // You might want to validate formData here or set a loading state
    const response = await apiService.post('/ppeMonitoring/insertAssetData', formData.value);
    
    // Handle the successful submission
    if (response.data.success) {
      // Commit the response data to the store if necessary
      // e.g., commit('addAsset', response.data.asset)
      console.log('Form submitted successfully:', response.data.message);
      // Here you could redirect to another route or clear the form
    } else {
      throw new Error(response.data.message || 'Form submission failed');
    }
  } catch (error) {
    console.error('Error submitting form:', error);
    // Handle the error (e.g., show a notification or set an error state)
  }
};

</script>

<template>
  <PageWrapper>

  <form @submit.prevent="submitForm">
    <Button class="dark:bg-green-600" :to="{ name: 'LG_Property_Monitoring' }">View Details</Button>
<div class="grid grid-cols-3 gap-4 pt-2">
  <div>
        <label for="article" class="block text-gray-700 text-sm dark:text-white mb-2">Article:</label>
        <input type="text" id="article" v-model="formData.article" class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <div>
        <label for="asset_type_name" class="block text-gray-700 text-sm dark:text-white mb-2">Asset Type:</label>
        <select
              id="asset_type_name"
              v-model="formData.asset_type_id"
              class="shadow border dark:bg-dark-eval-2 rounded w-5/6 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline"
            >
              <option :value="null" disabled selected>Select an asset type</option>
              <option v-for="assetType in assetTypes" :key="assetType.asset_type_id" :value="assetType.asset_type_id">
                {{ assetType.type_name }}
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
 