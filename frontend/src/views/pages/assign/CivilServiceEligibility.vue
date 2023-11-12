<script setup>
import { computed, reactive, watch, onMounted } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/Button.vue';
import { initDropdowns } from 'flowbite';

const store = useStore();

// Reactive state for the form data, binding to the Vuex store
const formData = computed({
  get() {
    return store.state.formData.page4;
  },
  set(value) {
    store.commit('updateFormData', { page: 'page4', data: value });
  },
});

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
      careerService: '',
      rating: '',
      dateOfExamination: '',
      placeOfExamination: '',
      licenseNumber: '',
      dateOfValidity: ''
    });
  } else {
    // Reset entries to an array with one new entry if it's not an array
    eligibilityEntries.entries = [{
      careerService: '',
      rating: '',
      dateOfExamination: '',
      placeOfExamination: '',
      licenseNumber: '',
      dateOfValidity: ''
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

</script>



<template>
    <div class="container mx-auto p-4">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                Career Service/RA 1080 (Board/Bar) Under Special Laws/CES/CSEE Barangay Eligibility/Driver's License
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                Rating (If Applicable)
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                Date of Examination/ Conferment
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                Place of Examination/ Conferment
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                License Number (If Applicable)
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                Date of Validity
              </th>
              <!-- Include a header for the delete button column -->
              <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <!-- Table rows and other code remains the same -->
            <tr v-for="(entry, index) in eligibilityEntries.entries" :key="index">
            <!-- ... input fields ... -->
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.career_service" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.rating" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="date" v-model="entry.date_of_examination" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.place_of_examination" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.license_number" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="date" v-model="entry.license_date_of_validity" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
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
    <div class="mt-4 flex justify-between">
  <Button :to="{ name: 'Educational Background' }" class="mr-2">
    Back
  </Button>
  <Button :to="{ name: 'Work Experience' }">
    Next
  </Button>
</div>

  </template>
  