<script setup>
import Button from '@/components/Button.vue';
import { ref, onMounted } from 'vue';
import { initDropdowns } from 'flowbite';

onMounted(() => {
    initDropdowns();
    // Any additional logic for onMounted
  });
</script>

<template>
    <form>
      <p class="text-xl text-gray-900 dark:text-white">Personal Information</p>
  <!-- Name and Date of Birth Section -->
<div class="mb-4 grid grid-cols-4 gap-4">
  <!-- Surname -->
  <div>
    <label for="surname" class="block text-gray-700 text-sm dark:text-white mb-2">Surname:</label>
    <input type="text" id="surname" name="surname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
  </div>
  
  <!-- First Name -->
  <div>
    <label for="firstname" class="block text-gray-700 text-sm dark:text-white mb-2">First Name:</label>
    <input type="text" id="firstname" name="firstname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
  </div>
  
  <!-- Middle Name -->
  <div>
    <label for="middlename" class="block text-gray-700 text-sm dark:text-white mb-2">Middle Name:</label>
    <input type="text" id="middlename" name="middlename" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
  </div>
  
  <!-- Name Extension -->
  <div>
    <label for="name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
    <input type="text" id="name_extension" name="name_extension" placeholder="e.g., Jr, Sr" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

</div>

<!-- Date of Birth and Place of Birth Section -->
<div class="mb-4 grid grid-cols-4 gap-4 items-center ">
  <!-- Date of Birth -->
  <div class="col-span-1">
    <label for="dob" class="block text-gray-700 text-sm dark:text-white mb-2">
      Date of Birth (mm/dd/yyyy):
    </label>
    <input type="date" id="dob" name="dob" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
  </div>
  
  <!-- Place of Birth -->
  <div class="col-span-2">
    <label for="placeofbirth" class="block text-gray-700 text-sm dark:text-white mb-2">
      Place of Birth:
    </label>
    <input type="text" id="placeofbirth" name="placeofbirth" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
  </div>
</div>


<div class="mb-4 flex justify-between items-center gap-28">
  
  <!-- Sex Section -->
  <div>
    <span class="block text-gray-700 text-sm dark:text-white mb-2">Sex:</span>
    <label class="inline-flex items-center">
      <input type="radio" class="form-radio h-5 w-5 dark:bg-dark-eval-2 text-gray-600" name="sex" value="male"><span class="ml-2 text-gray-700 dark:text-white">Male</span>
    </label>
    <label class="inline-flex items-center ml-4">
      <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-600" name="sex" value="female"><span class="ml-2 text-gray-700 dark:text-white">Female</span>
    </label>
  </div>

  <!-- Civil Status Section -->
  <div class="flex-grow">
    <span class="block text-gray-700 text-sm dark:text-white mb-2">Civil Status:</span>
    <div class="flex items-center">
      <label class="inline-flex items-center">
        <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-600" name="civilstatus" value="single"><span class="ml-2 text-gray-700 dark:text-white">Single</span>
      </label>
      <label class="inline-flex items-center ml-4">
        <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-600" name="civilstatus" value="married"><span class="ml-2 text-gray-700 dark:text-white">Married</span>
      </label>
      <label class="inline-flex items-center ml-4">
        <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-600" name="civilstatus" value="widowed"><span class="ml-2 text-gray-700 dark:text-white">Widowed</span>
      </label>
      <label class="inline-flex items-center ml-4">
        <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-600" name="civilstatus" value="separated"><span class="ml-2 text-gray-700 dark:text-white">Separated</span>
      </label>
      <label class="inline-flex items-center ml-4">
        <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-600" name="civilstatus" value="other"><span class="ml-2 text-gray-700 dark:text-white">Other/s:</span>
      </label>
      <input type="text" id="other_civilstatus" name="other_civilstatus" class="ml-2 shadow border rounded py-2 px-3  dark:bg-dark-eval-2 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="Please specify">
    </div>
  </div>

</div>

<!-- Height, Weight, and Blood Type in one line with shorter input boxes -->
<div class="mb-4 grid grid-cols-3 gap-4 items-center">
  <!-- Height -->
  <div>
    <label for="height" class="block text-gray-700 text-sm dark:text-white mb-2">Height (m):</label>
    <input type="text" id="height" name="height" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <!-- Weight -->
  <div>
    <label for="weight" class="block text-gray-700 text-sm dark:text-white mb-2">Weight (kg):</label>
    <input type="text" id="weight" name="weight" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <!-- Blood Type -->
  <div>
    <label for="bloodtype" class="block text-gray-700 text-sm dark:text-white mb-2">Blood Type:</label>
    <input type="text" id="bloodtype" name="bloodtype" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-32 py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
  </div>
</div>

<hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
  <!-- GSIS, PAG-IBIG, PHILHEALTH IDs -->
  <div class="mb-4 md:grid md:grid-cols-3 md:gap-4">
    <div class="mb-4 md:mr-2">
      <label for="gsis" class="block text-gray-700 text-sm dark:text-white mb-2">GSIS ID No.:</label>
      <input type="text" id="gsis" name="gsis" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4 md:mx-2">
      <label for="pagibig" class="block text-gray-700 text-sm dark:text-white mb-2">PAG-IBIG ID No.:</label>
      <input type="text" id="pagibig" name="pagibig" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4 md:ml-2">
      <label for="philhealth" class="block text-gray-700 text-sm dark:text-white mb-2">PHILHEALTH No.:</label>
      <input type="text" id="philhealth" name="philhealth" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4 md:mr-2">
      <label for="gsis" class="block text-gray-700 text-sm dark:text-white mb-2">SSS No.:</label>
      <input type="text" id="sss" name="sss" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4 md:mx-2">
      <label for="pagibig" class="block text-gray-700 text-sm dark:text-white mb-2">TIN No.:</label>
      <input type="text" id="tin" name="tin" class="shadow appearance-none dark:bg-dark-eval-2  border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4 md:ml-2">
      <label for="philhealth" class="block text-gray-700 text-sm  dark:text-white mb-2">AGENCY EMPLOYEE No.:</label>
      <input type="text" id="agency" name="agency" class="shadow appearance-none dark:bg-dark-eval-2  border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
  </div>
  <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<!-- Address Section -->
<div class="mb-4">
  <span class="block text-gray-700 text-sm dark:text-white mb-2">Residential Address:</span>
  <div class="grid grid-cols-6 gap-4">
    <!-- House/Block/Lot No. -->
    <div class="col-span-2">
      <input type="text" placeholder="House/Block/Lot No." name="house_block_lot_no" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <!-- Street -->
    <div class="col-span-3">
      <input type="text" placeholder="Street" name="street" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
    <!-- Subdivision/Village -->
    <div class="col-span-1">
      <input type="text" placeholder="Subdivision/Village" name="subdivision_village" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
    <!-- Barangay Address Picker -->
    <div class="col-span-1">
      <select id="barangay" name="barangay" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
        <option value="">Select Barangay</option>
        <!-- Additional options will be populated by the API -->
      </select>
    </div>
    <!-- City/Municipality Address Picker -->
    <div class="col-span-2">
      <select id="city_municipality" name="city_municipality" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
        <option value="">Select City/Municipality</option>
        <!-- Additional options will be populated by the API -->
      </select>
    </div>
    <!-- Province Address Picker -->
    <div class="col-span-2">
      <select id="province" name="province" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
        <option value="">Select Province</option>
        <!-- Additional options will be populated by the API -->
      </select>
    </div>
    <!-- ZIP Code -->
    <div class="col-span-1">
      <input type="text" placeholder="ZIP Code" name="zip_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
    </div>
  </div>
</div>

<hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />


<div class="mb-4">
  <span class="block text-gray-700 text-sm dark:text-white mb-2">Permanent Address:</span>
  <div class="grid grid-cols-6 gap-4">
    <!-- House/Block/Lot No. -->
    <div class="col-span-2">
      <input type="text" placeholder="House/Block/Lot No." name="house_block_lot_no" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <!-- Street -->
    <div class="col-span-3">
      <input type="text" placeholder="Street" name="street" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
    <!-- Subdivision/Village -->
    <div class="col-span-1">
      <input type="text" placeholder="Subdivision/Village" name="subdivision_village" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
    </div>
    <!-- Barangay Address Picker -->
    <div class="col-span-1">
      <select id="barangay" name="barangay" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
        <option value="">Select Barangay</option>
        <!-- Additional options will be populated by the API -->
      </select>
    </div>
    <!-- City/Municipality Address Picker -->
    <div class="col-span-2">
      <select id="city_municipality" name="city_municipality" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
        <option value="">Select City/Municipality</option>
        <!-- Additional options will be populated by the API -->
      </select>
    </div>
    <!-- Province Address Picker -->
    <div class="col-span-2">
      <select id="province" name="province" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
        <option value="">Select Province</option>
        <!-- Additional options will be populated by the API -->
      </select>
    </div>
    <!-- ZIP Code -->
    <div class="col-span-1">
      <input type="text" placeholder="ZIP Code" name="zip_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
    </div>
  </div>
</div>
<hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
<!-- Contact Information Section -->
<div class="mb-4 grid grid-cols-3 gap-4 items-center">
  <!-- Telephone No. -->
  <div>
    <label for="telephone" class="block text-gray-700 text-sm dark:text-white mb-2">Telephone No.:</label>
    <input type="tel" id="telephone" name="telephone" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white  dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="(555) 123-4567">
  </div>
  <!-- Mobile No. -->
  <div>
    <label for="mobile" class="block text-gray-700 text-sm dark:text-white mb-2">Mobile No.:</label>
    <input type="tel" id="mobile" name="mobile" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white  dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="09123456789">
  </div>
  <!-- E-mail Address -->
  <div>
    <label for="email" class="block text-gray-700 text-sm dark:text-white mb-2">E-mail Address (if any):</label>
    <input type="email" id="email" name="email" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:text-white  dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="example@domain.com">
  </div>
</div>

    <!-- Dropdowns for Designation, Position, and Section -->
    <div class="grid grid-cols-3 gap-4">
      <!-- Designation -->
      <div>
        <label for="designation" class="block text-sm mb-2  dark:text-white ">Designation:</label>
        <select id="designation" name="designation" class=" dark:text-white  shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
          <option value="">Select Designation</option>
          <!-- Additional options here -->
        </select>
      </div>

      <!-- Position -->
      <div>
        <label for="position" class="block text-sm mb-2  dark:text-white ">Position:</label>
        <select id="position" name="position" class=" dark:text-white  shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
          <option value="">Select Position</option>
          <!-- Additional options here -->
        </select>
      </div>

      <!-- Section -->
      <div>
        <label for="section" class="block text-sm mb-2  dark:text-white ">Section:</label>
        <select id="section" name="section" class=" dark:text-white  shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
          <option value="">Select Section</option>
          <!-- Additional options here -->
        </select>
      </div>
    </div>

    <div class="mb-4 grid grid-cols-3 gap-4 py-5 items-end">
  <!-- Date Picker for Date of Entry -->
  <div>
    <label for="date_of_entry" class="block text-sm mb-2  dark:text-white ">Date of Entry:</label>
    <input type="date" id="date_of_entry" name="date_of_entry" class=" dark:text-white  shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
  </div>

  <!-- Password Input -->
  <div>
    <label for="password" class="block text-sm mb-2  dark:text-white ">Password:</label>
    <input type="password" id="password" name=" dark:text-white  password" class="shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="Enter password">
  </div>

  <!-- IPCR Input -->
  <div>
    <label for="ipcr" class="block text-sm mb-2  dark:text-white ">IPCR:</label>
    <input type="text" id="ipcr" name="ipcr" class=" dark:text-white  shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="Enter IPCR value">
  </div>
</div>

<Button :to="{ name: 'Family Background' }">
  Next
</Button>



</form>


</template>
  
