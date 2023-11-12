<script setup>
import axios from 'axios';
import { reactive, onMounted } from 'vue';
import Button from '@/components/Button.vue';
import { initDropdowns } from 'flowbite';

const dropdownData = reactive({
  designations: [],
  positions: [],
  sections: []
});

onMounted(async () => {
  initDropdowns();
  try {
    const response = await axios.post('employee/getDropdownData');
    if (response && response.data) {
      dropdownData.designations = response.data.designations;
      dropdownData.positions = response.data.positions;
      dropdownData.sections = response.data.sections;
    }
  } catch (error) {
    console.error('Error fetching dropdown data:', error);
    // Handle error appropriately
  }
});
</script>

<template>
    <form>
      <p class="text-xl text-gray-900 dark:text-white">Family Background</p>
      <div class="max-w-4xl mx-auto py-6">
  <div class="mb-6">
    <!-- Spouse's Information -->
    <div class="grid grid-cols-6 gap-4 mb-4">
      <div class="col-span-2">
        <label for="spouse_surname" class="block text-sm font-bold mb-1">Spouse's Surname:</label>
        <input type="text" id="spouse_surname" name="spouse_surname" class="border rounded w-full py-2 px-3">
      </div>
      <div class="col-span-2">
        <label for="spouse_first_name" class="block text-sm font-bold mb-1">First Name:</label>
        <input type="text" id="spouse_first_name" name="spouse_first_name" class="border rounded w-full py-2 px-3">
      </div>
      <div class="col-span-1">
        <label for="spouse_middle_name" class="block text-sm font-bold mb-1">Middle Name:</label>
        <input type="text" id="spouse_middle_name" name="spouse_middle_name" class="border rounded w-full py-2 px-3">
      </div>
      <div class="col-span-1">
        <label for="spouse_name_extension" class="block text-sm font-bold mb-1">Name Extension (JR., SR):</label>
        <input type="text" id="spouse_name_extension" name="spouse_name_extension" class="border rounded w-full py-2 px-3">
      </div>
    </div>
    <div class="grid grid-cols-3 gap-4 mb-4">
      <div class="col-span-1">
        <label for="spouse_occupation" class="block text-sm font-bold mb-1">Occupation:</label>
        <input type="text" id="spouse_occupation" name="spouse_occupation" class="border rounded w-full py-2 px-3">
      </div>
      <div class="col-span-1">
        <label for="employer_business_name" class="block text-sm font-bold mb-1">Employer/Business Name:</label>
        <input type="text" id="employer_business_name" name="employer_business_name" class="border rounded w-full py-2 px-3">
      </div>
      <div class="col-span-1">
        <label for="business_address" class="block text-sm font-bold mb-1">Business Address:</label>
        <input type="text" id="business_address" name="business_address" class="border rounded w-full py-2 px-3">
      </div>
    </div>
    <div class="mb-4">
      <label for="spouse_telephone" class="block text-sm font-bold mb-1">Telephone No.:</label>
      <input type="tel" id="spouse_telephone" name="spouse_telephone" class="border rounded w-full py-2 px-3">
    </div>
  </div>
</div>



<div class="flex justify-between">
  <div>
    <Button :to="{ name: 'Personal Information' }">
      Back
    </Button>
  </div>
  <div>
    <Button :to="{ name: 'Educational Background' }">
      Next
    </Button>
  </div>
</div>





</form>


</template>
