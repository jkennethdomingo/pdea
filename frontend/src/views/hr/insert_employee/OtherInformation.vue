<script setup>
import { computed, reactive, watch, onMounted } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { initDropdowns } from 'flowbite';
import { ref } from 'vue';

const isModalOpen = ref(false);

const store = useStore();

// Reactive state for the form data, binding to the Vuex store
const formData = computed(() => store.state.formData.page8);

// Function to parse entries from localStorage or initialize as empty array
const getInitialEntries = () => {
  const savedEntries = localStorage.getItem('eligibilityEntries');
  return savedEntries ? JSON.parse(savedEntries) : [];
};

// Reactive state for eligibility entries
const eligibilityEntries = reactive({
  entries: getInitialEntries(),
});

// Watcher to save to localStorage
watch(eligibilityEntries.entries, (newEntries) => {
  localStorage.setItem('eligibilityEntries', JSON.stringify(newEntries));
}, { deep: true });

// Function to add a new entry
const addNewEntry = () => {
  if (Array.isArray(eligibilityEntries.entries)) {
    eligibilityEntries.entries.push({
      organization_name: '',
      period_from: '',
      period_to: '',
      number_of_hours: '',
      position: ''
    });
  } else {
    // Reset entries to an array with one new entry if it's not an array
    eligibilityEntries.entries = [{
      organization_name: '',
      period_from: '',
      period_to: '',
      number_of_hours: '',
      position: ''
    }];
  }
};

// Function to delete an entry
const deleteEntry = (index) => {
  if (Array.isArray(eligibilityEntries.entries)) {
    eligibilityEntries.entries.splice(index, 1);
  }
};

// Initiate any dropdowns when the component is mounted
onMounted(() => {
  initDropdowns();
});

// Submit form data handler
const handleSubmit = () => {
  store.dispatch('submitFormData', formData.value);
};

// TODO separate the things that are not included in this page


</script>

<template>
<p class="text-xl text-gray-900 dark:text-white font-bold">Other Information</p>
    <div class="container mx-auto p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              SPECIAL SKILLS and HOBBIES 
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              NON-ACADEMIC DISTINCTIONS / RECOGNITION (Write in full)
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in full)
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
            <!-- Table rows and other code remains the same -->
            <tr v-for="(entry, index) in eligibilityEntries.entries" :key="index">
            <!-- ... input fields ... -->
            <td class="px-6 py-4 whitespace-nowrap ">
              <input type="text" v-model="entry.special_skills_hobbies" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.non_academic_distinctions_recognition" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.membership_association_organization" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right">
              <button @click="deleteEntry(index)" class="text-red-500 hover:text-red-700">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  

    <div class="mt-4 ml-6 flex justify-end">
      <button @click="addNewEntry" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-4 rounded">
        Add Entry
      </button>
    </div>
   <hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
    <!-- answersheet -->
    
  <div class="border border-green-600 rounded p-4 shadow-lg my-4">
    <div class="max-w-4xl mx-auto p-4">
  <!-- Question 34 -->
  <div class="mb-8">
    <label class="block  text-black dark:text-white text-l mb-2">
     1.) Are you related by consanguinity or affinity to the appointing or recommending authority, or to chief of bureau or office or to the person who has immediate supervision over you in the Bureau or Department where you will be appointed,
    </label>
    <div class="flex flex-col space-y-4">
      <div>
        <label class="inline-flex items-center text-black dark:text-white">
          <span class="ml-2">A. within the third degree?</span>
        </label>
        <label class="inline-flex items-center ml-6">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">YES</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">NO</span>
        </label>
      </div>
      <div>
        <label class="inline-flex items-center text-black dark:text-white">
          <span class="ml-2">B. within the fourth degree (for Local Government Unit - Career Employees)?</span>
        </label>
        <label class="inline-flex items-center ml-6">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" id="yesCheckbox">
          <span class="ml-2 text-black dark:text-white">YES</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox  bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">NO</span>
        </label>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>
<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <div class="mb-4">
    <label class="block text-black dark:text-white mb-2" for="guilty">
      a. Have you ever been found guilty of any administrative offense?
    </label>
    <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
    <input id="guilty-details" name="guilty-details" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="If YES, give details:">
  </div>

  <div class="mb-4">
    <label class="block text-black dark:text-white text-l mb-2" for="charged">
      b. Have you been criminally charged before any court?
    </label>
    <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="charged-yes" name="charged" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="charged-no" name="charged" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
    <input id="charged-details" name="charged-details" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="If YES, give details:">
    <input id="charged-date" name="charged-date" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="Date Filed:">
    <input id="case-status" name="case-status" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="Status of Case/s:">
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 2 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      2.) Have you ever been convicted of any crime or violation of any law, decree, ordinance or 
      regulation by any court or tribunal?
    </label>
    <div class="flex flex-col space-y-4">
      <div>
        <label class="inline-flex items-center text-black dark:text-white">
          <span class="ml-2">b. within the fourth degree (for Local Government Unit - Career Employees)?</span>
        </label>
        <label class="inline-flex items-center ml-6">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">YES</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">NO</span>
        </label>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>
    
<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 3 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      3.) Have you ever been separated from the service in any of the following modes: resignation, 
      retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or 
      phased out (abolition) in the public or private sector?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      a. Have you ever been a candidate in a national or local election held within the last year 
     (except Barangay election)?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
      <div class="py-4 mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      b. Have you resigned from the government service during the three (3)-month period before 
      the last election to promote/actively campaign for a national or local candidate?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
    </div>
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 4 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      4.) Have you acquired the status of an immigrant or permanent resident of another country?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details (country): " class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 5 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      5.) Have you acquired the status of an immigrant or permanent resident of another country?
          Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons 
          (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following;
    </label>
  </div>
      <!-- A. -->
      a. Are you a member of any indigenous group?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, please specify:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
      
      <div class="py-4 mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      <!-- B -->
      b. Are you a person with disability?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="f YES, please specify ID No:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>

    <div class="py-4 mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      <!-- C -->
      C. re you a solo parent?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="f YES, please specify ID No:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>
    </div>
  </div>
</div>
</div>

<!-- Ref section -->

<p class="text-l text-gray-900 dark:text-white font-semibold">REFERENCES</p>
<p class="text-l text-red-700 "><p class="text-l text-red-700 ">(Person not related by consanguinity or affinity to applicant /appointee)</p></p>
    <div class="container mx-auto p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th scope="col" class="px-6 py-3  text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              NAME
            </th>
            <th scope="col" class="px-6 py-3 text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
             ADDRESS
            </th>
            <th scope="col" class="px-6 py-3 text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              TEL. NO.
            </th>
            <th scope="col" class="px-6 py-3 text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
            <!-- Table rows and other code remains the same -->
            <tr v-for="(entry, index) in eligibilityEntries.entries" :key="index">
            <!-- ... input fields ... -->
            <td class="px-6 py-4 whitespace-nowrap ">
              <input type="text" v-model="entry.organization_name" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.number_of_hours" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.position" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right hover:text-green-800">
              <button @click="deleteEntry(index)" class="text-red-500 hover:text-red-700">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-4 ml-6 flex justify-end">
      <button @click="addNewEntry" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-4 rounded">
        Add Entry
      </button>
    </div>
    </div>
  </div>

  <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />
  <p class="text-l text-gray-900 dark:text-white font-semibold">Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.) </p>
<p class="text-l text-red-700 "><p class="text-l text-red-700 ">(PLEASE INDICATE ID Number and Date of Issuance)</p></p>
      <!-- GSIS, PAG-IBIG, PHILHEALTH IDs -->
      <div class="mb-4 md:grid md:grid-cols-3 md:gap-4">
        <div class="mb-4 md:mr-2">
          <label for="gsis" class="block text-gray-700 text-sm dark:text-white mb-2">Government Issued ID.:</label>
          <input type="text" id="gsis" v-model="formData.gsis_id_no" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4 md:mx-2">
          <label for="pagibig" class="block text-gray-700 text-sm dark:text-white mb-2">D/License/Passport No.:</label>
          <input type="text" id="pagibig" v-model="formData.pag_ibig_id_no" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4 md:ml-2">
          <label for="philhealth" class="block text-gray-700 text-sm dark:text-white mb-2">Date/Place of Issuance:</label>
          <input type="text" id="philhealth" v-model="formData.philhealth_no" class="shadow appearance-none  dark:bg-dark-eval-2 border rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
        </div>
      </div>
      <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

      
  <!-- Modal toggle button -->
  <button @click="isModalOpen = true" class="justify-self-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Submit
  </button>

  <!-- Main modal -->
  <div v-show="isModalOpen" id="default-modal" tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Terms of Service
          </h3>
          <button @click="isModalOpen = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and
            complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the
            Philippines.
          </p>
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            I authorize the agency head/authorized representative to verify/validate the contents stated
            herein. I agree that any misrepresentation made in this document and its attachments shall cause the
            filing of administrative/criminal case/s against me.
          </p>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button @click="isModalOpen = false" data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
          <button @click="isModalOpen = false" data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
        </div>
      </div>
    </div>
  </div>


    <div class="mt-4 flex justify-between">
    <Button :to="{ name: 'Learning And Development' }">
  Back
</Button>

<Button :to="{ name: 'Questions And Others' }">
  Next
</Button>
</div>
</template>
