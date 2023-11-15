<script setup>
import { computed, reactive, watch, onMounted } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { initDropdowns } from 'flowbite';

const store = useStore();

// Simplify formData to directly refer to the store state
const formData = computed(() => store.state.formData.page7);
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

</script>


<template>

<p class="text-xl text-gray-900 dark:text-white font-bold">Learning & Development</p>
    <div class="container mx-auto p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS (Write in full)
            </th>
            <th scope="col" colspan="2" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              INCLUSIVE DATES OF ATTENDANCE (mm/dd/yyyy)
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              NUMBER OF HOURS
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              Type of LD( Managerial/ Supervisory/Technical/etc)
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              CONDUCTED/ SPONSORED BY (Write in full)
            </th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              Actions
            </th>
          </tr>
          <tr>
            <!-- Empty cell for spacing under the organization name -->
            <th scope="col" class="border-0"></th>
            <!-- Sub-headers for the inclusive dates -->
            <th scope="col" class="px-6 py-1 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              FROM
            </th>
            <th scope="col" class="px-6 py-1 text-center text-xs font-semibold text-black dark:text-white uppercase tracking-wider">
              TO
            </th>
            <!-- Empty cells for spacing under the other headers -->
            <th scope="col" class="border-0"></th>
            <th scope="col" class="border-0"></th>
            <th scope="col" class="border-0"></th>
          </tr>
        </thead>
        <tbody>
            <!-- Table rows and other code remains the same -->
            <tr v-for="(entry, index) in eligibilityEntries.entries" :key="index">
            <!-- ... input fields ... -->
            <td class="px-6 py-4 whitespace-nowrap ">
              <input type="text" v-model="entry.title" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="date" v-model="entry.date_from" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="date" v-model="entry.date_to" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.num_of_hours" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.type_ld" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="text" v-model="entry.sponsor" class="dark:bg-dark-eval-2 mt-1 block w-full border border-green-600 rounded-md shadow-sm" />
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

    <Button :to="{ name: 'Voluntary Work' }">
  Back
</Button>

<Button :to="{ name: 'Other Information' }">
  Next
</Button>
</div>
</template>
