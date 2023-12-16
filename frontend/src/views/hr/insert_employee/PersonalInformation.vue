<script setup>
import { computed, ref, onMounted, watch } from 'vue'; // Ensure 'computed' is imported here
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { initDropdowns } from 'flowbite';
import bloodTypesData from '@/assets/json/bloodtype.json';
import addressData from '@/assets/json/address.json';
import countriesData from '@/assets/json/countries.json';
import useZipCodes from '@/composables/useZipCodes';
import { useRouter } from 'vue-router';

const pagIbigTouched = ref(false);
const philHealthTouched = ref(false);
const sssTouched = ref(false);
const tinTouched = ref(false);
const gsisTouched = ref(false);
const showPassword = ref(false);
const store = useStore();
const bloodTypes = bloodTypesData.bloodTypes;
const jsonData = computed(() => addressData);
const countryData = computed(() => countriesData);

const { findLocationByZipCode } = useZipCodes();

const isGsisValid = computed(() => {
  return gsisTouched.value ? /^\d{11}$/.test(formData.value.gsis_id_no) : true;
});
const isPagIbigValid = computed(() => {
  return pagIbigTouched.value ? /^\d{4}-\d{4}-\d{4}$/.test(formData.value.pag_ibig_id_no) : true;
});

const isPhilHealthValid = computed(() => {
  return philHealthTouched.value ? /^\d{2}-\d{9}-\d{1}$/.test(formData.value.philhealth_no) : true;
});

const isSssValid = computed(() => {
  return sssTouched.value ? /^\d{2}-\d{7}-\d{1}$/.test(formData.value.sss_no) : true;
});

const isTinValid = computed(() => {
  return tinTouched.value ? /^\d{3}-\d{3}-\d{3}$/.test(formData.value.tin_no) : true;
});

  

// Assuming your Vuex store has an action called 'getDropdownData'
onMounted(() => {
  initDropdowns();
  store.dispatch('getDropdownData');
});

// Your SVG icon as a string

// Create a data URL for the SVG

const fileInput = ref(null);

const photoPreviewUrl = computed({
  get: () => store.state.photoPreviewUrl,
  set: (url) => store.commit('updatePhotoPreviewUrl', url)
});


const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    store.commit('setSelectedFile', file);
    reader.onload = (e) => {
      // Update Vuex store with the new image name
      store.commit('updateFormDataPicture', { path: 'page1.photo', value: file.name });
    };
    reader.readAsDataURL(file);

    // Update the photo preview URL in Vuex store
    photoPreviewUrl.value = URL.createObjectURL(file);
  }
};

// Simplify formData to directly refer to the store state
const formData = computed(() => store.state.formData.page1);

// Generalized function to reset form fields
function resetFormFields(formType, fieldType) {
  if (fieldType === 'region') {
    formData.value[formType].province = '';
    formData.value[formType].municipality = '';
    formData.value[formType].barangay = '';
  } else if (fieldType === 'province') {
    formData.value[formType].municipality = '';
    formData.value[formType].barangay = '';
  } else if (fieldType === 'municipality') {
    const zipCode = findLocationByZipCode(formData.value[formType].municipality);
    if (zipCode) {
      formData.value[formType].zip_code = zipCode;
    }
  }
}

// Generalized function to set up watchers
function setupWatchers(formType) {
  watch(() => formData.value[formType].region, (newRegion, oldRegion) => {
    if (newRegion !== oldRegion) {
      resetFormFields(formType, 'region');
    }
  });

  watch(() => formData.value[formType].province, (newProvince, oldProvince) => {
    if (newProvince !== oldProvince) {
      resetFormFields(formType, 'province');
    }
  });

  watch(() => formData.value[formType].municipality, (newMunicipality) => {
    resetFormFields(formType, 'municipality');
  });
}

// Function to reset the entire permanent form
function resetPermanentForm() {
  resetFormFields('permanentForm', 'region');
}

watch(formData, (newValue) => {
  console.log('Form Data Updated:', newValue);
}, { deep: true });

// Watching changes in residentialForm to update permanentForm
watch(
  () => formData.value.residentialForm,
  (newResidentialForm) => {
    if (isSameAsResidential.value) {
      formData.value.permanentForm = { ...newResidentialForm };
    }
  },
  { deep: true }
);

// Watching the checkbox's state
const isSameAsResidential = ref(false);
watch(isSameAsResidential, (newValue) => {
  if (newValue) {
    formData.value.permanentForm = { ...formData.value.residentialForm };
  } else {
    resetPermanentForm();
  }
});

// Initialize watchers for both forms
setupWatchers('residentialForm');
setupWatchers('permanentForm');


const designationsDropdown = computed(() => store.state.dropdownData.designations);
const positionsDropdown = computed(() => store.state.dropdownData.positions);
const sectionsDropdown = computed(() => store.state.dropdownData.sections);
const divisionsDropdown = computed(() => store.state.dropdownData.divisions);

const router = useRouter();

const goToFamBackground = () => {
  router.push({ name: 'Family Background' });
};
const goToEducBg = () => {
  router.push({ name: 'Educational Background' });
};
const goToCvEligibility = () => {
  router.push({ name: 'Civil Service Eligibility' });
};
const goToWorkExp = () => {
  router.push({ name: 'Work Experience' });
};
const goToVolWork = () => {
  router.push({ name: 'Voluntary Work' });
};
const goToLearnDev = () => {
  router.push({ name: 'Learning And Development' });
};

</script>

<template>
  <form>
    <ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
      <li class="flex items-center text-green-600 dark:text-green-500 space-x-2.5 rtl:space-x-reverse cursor-pointer">
        <span class="flex items-center justify-center w-8 h-8 border border-green-600 rounded-full shrink-0 dark:green-blue-500">
            S1
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Personal Information</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToFamBackground">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S2
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Family Background</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToEducBg">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S3
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Educational Background</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToCvEligibility">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S4
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Civil Service Eligibility</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToWorkExp">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S5
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Work Experience</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToVolWork">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S6
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Voluntary Work</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToLearnDev">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S7
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Learning And Development</h3>
        </span>
    </li>
  
</ol>

<hr class="my-3 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

    <p class="text-xl text-gray-900 dark:text-white font-bold">Personal Information</p>

<!-- Employee ID -->
<div class="flex items-center space-x-4 mb-4">
  <div class="relative h-32 w-32">
    <!-- Image bound with userImage variable -->
    <img :src="photoPreviewUrl" alt="Employee" class="w-28 h-28 object-cover rounded-2xl">
    <input type="file" ref="fileInput" @change="handleFileChange" class="hidden" />
    <!-- Button to trigger file input -->
    <button @click="triggerFileInput" class="absolute -right-0 bottom-4 text-white p-1 text-xs bg-green-400 hover:bg-green-500 font-medium tracking-wider rounded-full transition ease-in duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
      </svg>
    </button>
  </div>
  

  
  <div class="flex flex-col"> <!-- Container for the Employee ID field -->
    <label for="EmployeeID" class="block text-gray-700 text-sm dark:text-white mb-2">
      Employee ID: <span class="text-red-500">*</span>
    </label>
    <input type="text" id="EmployeeID" v-model="formData.EmployeeID" class="shadow border dark:bg-dark-eval-2 rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
  </div>
</div>


<!-- Form Fields -->
<div class="mb-4 grid grid-cols-4 gap-4">
  <!-- Surname -->
  <div>
  <label for="surname" class="block text-gray-700 text-sm dark:text-white mb-2">
    Surname: <span class="text-red-500">*</span>
  </label>
  <input type="text" id="surname" v-model="formData.surname" placeholder="Dela Cruz" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
</div>
<!-- First Name -->
<div>
  <label for="firstname" class="block text-gray-700 text-sm dark:text-white mb-2">
    First Name: <span class="text-red-500">*</span>
  </label>
  <input type="text" id="firstname" v-model="formData.first_name" placeholder="Juan" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
</div>
  <!-- Middle Name -->
  <div>
    <label for="middlename" class="block text-gray-700 text-sm dark:text-white mb-2">Middle Name:</label>
    <input type="text" id="middlename" v-model="formData.middle_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
  </div>
  <!-- Name Extension -->
  <div>
    <label for="name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
    <input type="text" id="name_extension" v-model="formData.name_extension" placeholder="e.g., Jr, Sr" class="shadow border dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
  </div>
</div>

<!-- Date of Birth and Place of Birth Section -->
<div class="mb-4 grid grid-cols-4 gap-4 items-center ">
      <!-- Date of Birth -->
      <div class="col-span-1">
        <label for="dob" class="block text-gray-700 text-sm dark:text-white mb-2">
          Date of Birth (mm/dd/yyyy): <span class="text-red-500">*</span>
        </label>
        <input type="date" id="dob" v-model="formData.date_of_birth" class="shadow border  dark:bg-dark-eval-2 rounded w-40 py-2 px-3 text-gray-700 leading-tight dark:text-white focus:outline-none focus:shadow-outline">
      </div>
      <!-- Place of Birth -->
      <div class="col-span-2">
        <label for="placeofbirth" class="block text-gray-700 text-sm dark:text-white mb-2">
          Place of Birth:
        </label>
        <input type="text" id="placeofbirth" placeholder="Sta. Isabel Calapan City, Oriental Mindoro" v-model="formData.place_of_birth" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
      </div>
    </div>

    <div class="mb-4 flex justify-between items-center gap-28">
      <!-- Sex Section -->
      <div>
        <span class="block text-gray-700 text-sm dark:text-white mb-2">
          Sex: <span class="text-red-500 text-lg">*</span></span>
        <label class="inline-flex items-center">
          <input type="radio" class="form-radio h-5 w-5 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.sex" value="M"><span class="ml-2 text-gray-700 dark:text-white">Male</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.sex" value="F"><span class="ml-2 text-gray-700 dark:text-white">Female</span>
        </label>
      </div>
      <!-- Civil Status Section -->
      <div class="flex-grow">
        <span class="block text-gray-700 text-sm dark:text-white mb-2">Civil Status:</span>
        <div class="flex items-center">
          <label class="inline-flex items-center">
          <input type="radio" class="form-radio h-5 w-5 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.civil_status" value="Single">
          <span class="ml-2 text-gray-700 dark:text-white">Single</span>
        </label>
          <label class="inline-flex items-center ml-4">
            <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.civil_status" value="Married"><span class="ml-2 text-gray-700 dark:text-white">Married</span>
          </label>
          <label class="inline-flex items-center ml-4">
            <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.civil_status" value="Widowed"><span class="ml-2 text-gray-700 dark:text-white">Widowed</span>
          </label>
          <label class="inline-flex items-center ml-4">
            <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.civil_status" value="Separated"><span class="ml-2 text-gray-700 dark:text-white">Separated</span>
          </label>
          <label class="inline-flex items-center ml-4">
            <input type="radio" class="form-radio h-5 w-5  dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200" v-model="formData.civil_status"><span class="ml-2 text-gray-700 dark:text-white">Other/s:</span>
          </label>
          <input type="text" id="other_civilstatus" v-model="formData.civil_status" class="ml-2 shadow border rounded py-2 px-3  dark:bg-dark-eval-2 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="Please specify">
        </div>
      </div>
    </div>

    <!-- Height, Weight, and Blood Type in one line with shorter input boxes -->
    <div class="mb-4 grid grid-cols-3 gap-4 items-center">
      <!-- Height -->
      <div>
        <label for="height" class="block text-gray-700 text-sm dark:text-white mb-2">Height (m):</label>
        <input type="text" id="height" v-model="formData.height" placeholder="5'5" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-32 py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Weight -->
      <div>
        <label for="weight" class="block text-gray-700 text-sm dark:text-white mb-2">Weight (kg):</label>
        <input type="text" id="weight" v-model="formData.weight" placeholder="50" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-32 py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Blood Type -->
      <div>
        <label for="bloodtype" class="block text-gray-700 text-sm dark:text-white mb-2">Blood Type:</label>
        <select id="bloodtype" v-model="formData.blood_type" class="shadow appearance-none dark:bg-dark-eval-2 border rounded w-32 py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
          <option v-for="bloodType in bloodTypes" :key="bloodType.value" :value="bloodType.value">
            {{ bloodType.text }}
          </option>
        </select>
      </div>

    </div>

    <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

      <!-- GSIS, PAG-IBIG, PHILHEALTH IDs -->
      <div class="mb-4 md:grid md:grid-cols-3 md:gap-4">
        <div class="mb-4 md:mr-2">
          <label for="gsis" class="block text-gray-700 text-sm dark:text-white mb-2">GSIS ID No.:</label>
          <input type="text" id="gsis" v-model="formData.gsis_id_no" placeholder="12345678901" :class="{'border-red-500': !isGsisValid}" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
          @input="gsisTouched = true">
          <p v-if="!isGsisValid" class="text-red-500 text-xs italic">Invalid format.</p>
        </div>
        <div class="mb-4 md:mx-2">
          <label for="pagibig" class="block text-gray-700 text-sm dark:text-white mb-2">PAG-IBIG ID No.:</label>
          <input type="text" id="pagibig" v-model="formData.pag_ibig_id_no" placeholder="1234-5678-9012" :class="{'border-red-500': !isPagIbigValid}" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
          @input="pagIbigTouched = true">
          <p v-if="!isPagIbigValid" class="text-red-500 text-xs italic">Invalid format.</p>
        </div>
        <div class="mb-4 md:ml-2">
          <label for="philhealth" class="block text-gray-700 text-sm dark:text-white mb-2">PHILHEALTH No.:</label>
          <input type="text" id="philhealth" v-model="formData.philhealth_no" placeholder="00-123456789-0" :class="{'border-red-500': !isPhilHealthValid}" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
            @input="philHealthTouched = true">
          <p v-if="!isPhilHealthValid" class="text-red-500 text-xs italic">Please enter a valid PHILHEALTH number in the format 00-123456789-0.</p>
        </div>

        <div class="mb-4 md:mr-2">
          <label for="gsis" class="block text-gray-700 text-sm dark:text-white mb-2">SSS No.:</label>
          <input type="text" id="sss" v-model="formData.sss_no" placeholder="01-2345678-9" :class="{'border-red-500': !isSssValid}" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
          @input="sssTouched = true">
          <p v-if="!isSssValid" class="text-red-500 text-xs italic">Invalid format.</p>
        </div>
        <div class="mb-4 md:mx-2">
          <label for="pagibig" class="block text-gray-700 text-sm dark:text-white mb-2">TIN No.:</label>
          <input type="text" id="tin" v-model="formData.tin_no" placeholder="123-456-789" :class="{'border-red-500': !isTinValid}" class="shadow appearance-none dark:bg-dark-eval-2  border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
          @input="tinTouched = true">
          <p v-if="!isTinValid" class="text-red-500 text-xs italic">Invalid format.</p>
        </div>
        <div class="mb-4 md:ml-2">
          <label for="philhealth" class="block text-gray-700 text-sm  dark:text-white mb-2">AGENCY EMPLOYEE No.:</label>
          <input type="text" id="agency" v-model="formData.agency_employee_no" class="shadow appearance-none dark:bg-dark-eval-2  border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
        </div>
      </div>

    <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

    <div class="flex items-center space-x-4">
 <!-- Citizenship Section -->
<div class="flex flex-col space-y-3 dark:text-white">
  <div>Citizenship: <span class="text-red-500 text-lg">*</span></div>

  <!-- Filipino Radio Button -->
  <label class="inline-flex items-center">
    <input type="radio" class="form-radio dark:bg-dark-eval-2" name="citizenship" value="Filipino" v-model="formData.citizenship">
    <span class="ml-2">Filipino</span>
  </label>

  <!-- Dual Citizenship Radio Button -->
  <label class="inline-flex items-center">
    <input type="radio" class="form-radio dark:bg-dark-eval-2" name="citizenship" value="Dual Citizenship" v-model="formData.citizenship">
    <span class="ml-2">Dual Citizenship</span>
  </label>

  <!-- Additional Choices for Dual Citizenship -->
  <div v-if="formData.citizenship === 'Dual Citizenship'">
    <div class="flex items-center space-x-2">
      <label class="inline-flex items-center">
        <input type="radio" class="form-radio dark:bg-dark-eval-2" name="dual_citizenship_type" value="by birth" v-model="formData.dual_citizenship_type">
        <span class="ml-2">by birth</span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio" class="form-radio dark:bg-dark-eval-2" name="dual_citizenship_type" value="by naturalization" v-model="formData.dual_citizenship_type">
        <span class="ml-2">by naturalization</span>
      </label>
    </div>

    <!-- Country Input Field -->
    <div>
      <label for="country" class="block text-sm mb-2">Country:</label>
      <select id="country" v-model="formData.country" class="  dark:bg-dark-eval-2 border border-gray-300 bg-white rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2"> <!-- Adjusted padding -->
        <option value="" disabled selected>Select a country</option>
        <option v-for="country in countryData" :key="country.code" :value="country.name">{{ country.name }}</option>
      </select>
    </div>
  </div>
</div>
</div>



<hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />



    <!-- Address Section -->
    <div class="mb-4">
    <span class="block text-gray-700 text-sm dark:text-white mb-2">Residential Address:</span>
    <div class="flex flex-wrap gap-2">
        <!-- House/Block/Lot No., Street, Subdivision/Village -->
        <input type="text" placeholder="House/Block/Lot No." v-model="formData.residentialForm.house_block_lot_no" class="shadow appearance-none dark:bg-dark-eval-2 border rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline w-full md:w-auto">
        <input type="text" placeholder="Street" v-model="formData.residentialForm.street" class="shadow appearance-none dark:bg-dark-eval-2 border rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline w-full md:w-auto">
        <input type="text" placeholder="Subdivision/Village" v-model="formData.residentialForm.subdivision_village" class="shadow appearance-none dark:bg-dark-eval-2 border rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline w-full md:w-auto">

        <!-- Region -->
        <select id="residential_region" v-model="formData.residentialForm.region" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full md:w-auto">
            <option value="" disabled selected>Select Region</option>
            <option v-for="(region, regionCode) in jsonData" :key="regionCode" :value="regionCode">{{ region.region_name }}</option>
        </select>

        <!-- ZIP Code -->
        <input type="text" placeholder="ZIP Code" v-model="formData.residentialForm.zip_code" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full md:w-auto md:ml-auto">

        <!-- Province Select -->
        <div v-if="formData.residentialForm.region" class="w-96">
            <label for="residential_province" class="block text-sm mb-2 dark:text-white">Province:</label>
            <select id="residential_province" v-model="formData.residentialForm.province" class="dark:text-white shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Select Province</option>
                <option v-for="(provinceData, provinceName) in jsonData[formData.residentialForm.region].province_list" :key="provinceName" :value="provinceName">{{ provinceName }}</option>
            </select>
        </div>

        <!-- Municipality Select -->
        <div v-if="formData.residentialForm.region && formData.residentialForm.province" class="w-96">
            <label for="residential_municipality" class="block text-sm mb-2 dark:text-white">Municipality:</label>
            <select id="residential_municipality" v-model="formData.residentialForm.municipality" class="dark:text-white shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Select Municipality</option>
                <option v-for="(municipalityData, municipalityName) in jsonData[formData.residentialForm.region].province_list[formData.residentialForm.province].municipality_list" :key="municipalityName" :value="municipalityName">{{ municipalityName }}</option>
            </select>
        </div>

        <!-- Barangay Select -->
        <div v-if="formData.residentialForm.region && formData.residentialForm.province && formData.residentialForm.municipality" class=" w-96">
            <label for="residential_barangay" class="block text-sm mb-2 dark:text-white">Barangay:</label>
            <select id="residential_barangay" v-model="formData.residentialForm.barangay" class="dark:text-white shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Select Barangay</option>
                <option v-for="barangay in jsonData[formData.residentialForm.region].province_list[formData.residentialForm.province].municipality_list[formData.residentialForm.municipality].barangay_list" :key="barangay" :value="barangay">{{ barangay }}</option>
            </select>
        </div>
    </div>
</div>



    <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />


    <div class="mb-4">
    <span class="block text-gray-700 text-sm dark:text-white mb-2">Permanent Address:</span>
    <div class="flex items-center mb-4">
        <input type="checkbox" id="sameAsResidential" v-model="isSameAsResidential" class="mr-2">
        <label for="sameAsResidential" class="text-sm dark:text-white">Same as residential address</label>
    </div>
    <div class="flex flex-wrap gap-2">
        <!-- House/Block/Lot No., Street, Subdivision/Village -->
        <input type="text" placeholder="House/Block/Lot No." v-model="formData.permanentForm.house_block_lot_no" class="shadow appearance-none dark:bg-dark-eval-2 border rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline w-full md:w-auto">
        <input type="text" placeholder="Street" v-model="formData.permanentForm.street" class="shadow appearance-none dark:bg-dark-eval-2 border rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline w-full md:w-auto">
        <input type="text" placeholder="Subdivision/Village" v-model="formData.permanentForm.subdivision_village" class="shadow appearance-none dark:bg-dark-eval-2 border rounded py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline w-full md:w-auto">

        <!-- Region -->
        <select id="permanent_region" v-model="formData.permanentForm.region" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full md:w-auto">
            <option value="" disabled selected>Select Region</option>
            <option v-for="(region, regionCode) in jsonData" :key="regionCode" :value="regionCode">{{ region.region_name }}</option>
        </select>

           <!-- ZIP Code -->
           <input type="text" placeholder="ZIP Code" v-model="formData.permanentForm.zip_code" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight dark:text-white dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full md:w-auto md:ml-auto">

    <!-- Province Select -->
    <div v-if="formData.permanentForm.region" class="w-96">
        <label for="permanent_province" class="block text-sm mb-2 dark:text-white">Province:</label>
        <select id="permanent_province" v-model="formData.permanentForm.province" class="dark:text-white shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>Select Province</option>
            <option v-for="(provinceData, provinceName) in jsonData[formData.permanentForm.region].province_list" :key="provinceName" :value="provinceName">{{ provinceName }}</option>
        </select>
    </div>

    <!-- Municipality Select -->
    <div v-if="formData.permanentForm.region && formData.permanentForm.province" class="w-96">
        <label for="permanent_municipality" class="block text-sm mb-2 dark:text-white">Municipality:</label>
        <select id="permanent_municipality" v-model="formData.permanentForm.municipality" class="dark:text-white shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>Select Municipality</option>
            <option v-for="(municipalityData, municipalityName) in jsonData[formData.permanentForm.region].province_list[formData.permanentForm.province].municipality_list" :key="municipalityName" :value="municipalityName">{{ municipalityName }}</option>
        </select>
    </div>

    <!-- Barangay Select -->
    <div v-if="formData.permanentForm.region && formData.permanentForm.province && formData.permanentForm.municipality" class="w-96">
        <label for="permanent_barangay" class="block text-sm mb-2 dark:text-white">Barangay:</label>
        <select id="permanent_barangay" v-model="formData.permanentForm.barangay" class="dark:text-white shadow border rounded w-full py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>Select Barangay</option>
            <option v-for="barangay in jsonData[formData.permanentForm.region].province_list[formData.permanentForm.province].municipality_list[formData.permanentForm.municipality].barangay_list" :key="barangay" :value="barangay">{{ barangay }}</option>
        </select>
    </div>
  </div>
</div>


    <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
    <!-- Contact Information Section -->
    <div class="mb-4 grid grid-cols-3 gap-4 items-center">
      <!-- Telephone No. -->
      <div>
        <label for="telephone" class="block text-gray-700 text-sm dark:text-white mb-2">Telephone No.:</label>
        <input type="tel" id="telephone" v-model="formData.telephone_no" class="shadow border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight  dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="(555) 123-4567">
      </div>
      <!-- Mobile No. -->
      <div>
        <label for="mobile" class="block text-gray-700 text-sm dark:text-white mb-2">Mobile No.:</label>
        <input type="tel" id="mobile" v-model="formData.mobile_no" class="shadow border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tigh  dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="09123456789">
      </div>
      <!-- E-mail Address -->
      <div>
        <label for="email" class="block text-gray-700 text-sm dark:text-white mb-2">E-mail Address (if any):</label>
        <input type="email" id="email" v-model="formData.Email" class="shadow border rounded w-full py-2 px-3 text-gray-800 dark:text-gray-200 leading-tight  dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="example@email.com">
      </div>
    </div>
      
      <!-- Other sections... -->
    <!-- Dropdowns for Designation, Position, and Section -->
    <div class="flex flex-row items-end gap-4">

              <!-- Division -->
  <div class="flex flex-col w-1/3">
    <label for="division" class="text-sm mb-1 dark:text-white">Division:</label>
    <select id="division" v-model="formData.division" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full">
      <option value="" disabled selected>Select division</option>
      <option v-for="division in divisionsDropdown" :key="division.DivisionID" :value="division.DivisionID">{{ division.DivisionName }}</option>
    </select>
  </div>
        <!-- Section -->
  <div class="flex flex-col w-1/3">
    <label for="section" class="text-sm mb-1 dark:text-white">Section:</label>
    <select id="section" v-model="formData.section" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full">
      <option value="" disabled selected>Select Section</option>
      <option v-for="section in sectionsDropdown" :key="section.SectionID" :value="section.SectionID">{{ section.SectionName }}</option>
    </select>
  </div>


  <!-- Position -->
  <div class="flex flex-col w-1/3">
    <label for="position" class="text-sm mb-1 dark:text-white">Position:</label>
    <select id="position" v-model="formData.position" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full">
      <option value="" disabled selected>Select Position</option>
      <option v-for="position in positionsDropdown" :key="position.PositionID" :value="position.PositionID">{{ position.PositionName }}</option>
    </select>
  </div>


  <!-- Designation -->
  <div class="flex flex-col w-1/3">
    <label for="designation" class="text-sm mb-1 dark:text-white">Designation:</label>
    <select id="designation" v-model="formData.designation" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline w-full">
      <option value="" disabled>Select Designation</option>
      <option v-for="designation in designationsDropdown" :key="designation.DesignationID" :value="designation.DesignationID">{{ designation.DesignationName }}</option>
    </select>
  </div>

</div>


    <div class="mb-4 grid grid-cols-3 gap-4 py-5 items-end">
  <!-- Date Picker for Date of Entry -->
  <div>
    <label for="date_of_entry" class="block text-sm mb-2 dark:text-white">Date of Entry: <span class="text-red-500 text-lg">*</span></label>
    <input type="date" id="date_of_entry" v-model="formData.DateOfEntry" class="dark:text-white shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline">
  </div>

  <!-- Password Input -->
  <div>
    <label for="password" class="block text-sm mb-2 dark:text-white">Password:</label>
    <div class="flex items-center gap-2">
      <input :type="showPassword ? 'text' : 'password'" id="password" v-model="formData.Password" class="shadow border rounded py-2 px-3 leading-tight text-gray-800 dark:text-gray-200 dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline flex-grow" placeholder="Enter password">
      <div class="flex items-center">
        <input type="checkbox" id="show_password" v-model="showPassword" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
        <label for="show_password" class="ml-2 block text-xs dark:text-white">Show Password</label>
      </div>
    </div>
  </div>

  <!-- IPCR Input -->
  <div>
    <label for="ipcr" class="block text-sm mb-2 dark:text-white">IPCR:</label>
    <input type="text" id="ipcr" v-model="formData.IPCR" class="text-gray-800 dark:text-gray-200 shadow border rounded py-2 px-3 leading-tight dark:bg-dark-eval-2 focus:outline-none focus:shadow-outline" placeholder="Enter IPCR value">
  </div>
</div>


<div class="flex justify-end">
  <Button :to="{ name: 'Family Background' }" class="bg-green-500 text-gray-800 dark:text-gray-200 hover:bg-green-600">
    Next
  </Button>
</div>

  </form>
</template>