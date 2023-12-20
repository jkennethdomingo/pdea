<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useStore } from 'vuex';
import { usePhotoUrl } from '@/composables/usePhotoUrl';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue';
import apiService from '@/composables/axios-setup';

const store = useStore();
const isOpen = ref(false);
const isModalVisible = ref(false);
const assetInformation = ref(null);
const assetData = ref({});
const isViewModalOpen = ref(false);
const { getPhotoUrl } = usePhotoUrl(); // Using the composable
const agentData = computed(() => store.state.agentData);
const selectedType = ref(null);
const selectedDescription = ref(null);
const selectedEmployeeId = ref(null);


function closeViewModal() {
    isViewModalOpen.value = false;
}

function closeModal() {
  isOpen.value = false;
  isModalVisible.value = false;
}

function openModal(employeeId) {
  isModalVisible.value = true;
  selectedEmployeeId.value = employeeId;
}

async function fetchAssetData() {
  try {
    const response = await apiService.post('/materialRequisition/getPropertyPlantAndEquipmentDropdown');
    assetData.value = response.data.data; // Store the data in local state
    console.log(assetData.value)
  } catch (error) {
    console.error('Error fetching asset data:', error);
  }
}

async function openViewModal(id) {
  isViewModalOpen.value = true;
  assetInformation.value = null; // Reset the asset information

  try {
    const response = await apiService.post('/materialRequisition/getAssignedAssetInformation', { EmployeeID: id });
    if (response && response.data) {
      if (response.data.data && response.data.data.length > 0) {
        assetInformation.value = response.data.data;
      } else {
        assetInformation.value = response.data.message;
      }
    }
  } catch (error) {
    console.error('Error fetching asset information:', error);
  }
}

const assetTypes = computed(() => {
  return Object.keys(assetData.value);
});

const assetDescriptions = computed(() => {
  if (selectedType.value && assetData.value[selectedType.value]) {
    return assetData.value[selectedType.value].map(asset => {
      return { id: asset.asset_id, description: asset.description };
    });
  }
  return [];
});

async function postAssetAssignments() {
  // Assuming you want to use the selected description ID for some API call or logic
  const selectedAssetId = selectedDescription.value;
  const selectedEmployeeId = selectedEmployeeId.value;

  if (!selectedAssetId) {
    console.error('No asset selected');
    return;
  }

  // Example of using the selected asset ID in an API call
  try {
    const response = await apiService.post('/your/api/endpoint', { assetId: selectedAssetId });
    // Handle the response
    console.log('Response:', response);
  } catch (error) {
    console.error('Error in posting training assignments:', error);
  }
}



watch(selectedType, () => {
  selectedDescription.value = null; // Reset description when type changes
});


onMounted(async () => {
  store.dispatch('fetchagentData');
  await fetchAssetData(); // Await the fetching of asset data
});
</script>


<template>
<section class="flex flex-col min-h-3/6 w-full p-1 rounded-lg bg-white dark:bg-gray-900">
    <!-- component -->
        <div class="container m-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 gap-y-6">
                <!-- profile cards -->
                <div class="flex flex-col" v-for="agent in agentData" :key="agent.EmployeeID">
                    <div class="bg-gray-300 dark:bg-gray-800 border border-gray-800 shadow-lg rounded-2xl max-w-sm p-4">
                        <div class="flex-none sm:flex">
                            <div class="relative h-32 w-36 sm:mb-0 mb-3">
                                <!-- Conditional rendering based on agent.Photo -->
                                <template v-if="agent.photo">
                                    <!-- Render image if agent.photo is not null -->
                                    <img :src="getPhotoUrl(agent.photo)" alt="Profile Picture not found" class="w-32 h-32 object-cover rounded-2xl">
                                </template>
                                <template v-else>
                                    <!-- Render default icon if agent.Photo is null -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 512 512"><path fill="currentColor" d="M332.64 64.58C313.18 43.57 286 32 256 32c-30.16 0-57.43 11.5-76.8 32.38c-19.58 21.11-29.12 49.8-26.88 80.78C156.76 206.28 203.27 256 256 256s99.16-49.71 103.67-110.82c2.27-30.7-7.33-59.33-27.03-80.6M432 480H80a31 31 0 0 1-24.2-11.13c-6.5-7.77-9.12-18.38-7.18-29.11C57.06 392.94 83.4 353.61 124.8 326c36.78-24.51 83.37-38 131.2-38s94.42 13.5 131.2 38c41.4 27.6 67.74 66.93 76.18 113.75c1.94 10.73-.68 21.34-7.18 29.11A31 31 0 0 1 432 480"/></svg>
                                </template>
                            </div>
                            <div class="flex-auto sm:ml-5 mt-8 justify-evenly">
                                <div class="flex items-center justify-between sm:mt-2">
                                    <div class="flex items-center">
                                        <div class="flex flex-col">
                                            <!-- Display name and position -->
                                            <div class="text-lg dark:text-gray-200 text-gray-800 font-bold leading-none">{{ agent.first_name }} {{ agent.surname }}</div>
                                            <div class="text-gray-700 dark:text-gray-400 my-1">
                                                <span class="mr-2 text-sm text-green-600 dark:text-green-400">{{ agent.EmployeeID }}</span>
                                                <span class="text-sm">&middot; {{ agent.PositionName }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex pt-2 text-sm text-gray-400">
                                    <!-- Buttons can be updated or used as is -->
                                   <!-- View button -->
                                    <button
                                        @click="openViewModal(agent.EmployeeID)"
                                        class="bg-green-600 hover:bg-green-700 mr-1 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300"
                                    >
                                        View
                                    </button>

                                    <!--TODO View Modal -->
                                    <TransitionRoot :show="isViewModalOpen" as="template">
    <Dialog as="div" class="relative z-50">
        <TransitionChild
            as="template"
            enter="duration-50 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-40 ease-in"
            leave-from="opacity-30"
            leave-to="opacity-0"
        >
            <div class="fixed inset-0" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <TransitionChild
                    as="template"
                    enter="duration-50 ease-out"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-30 scale-100"
                    leave="duration-40 ease-in"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                            Assigned Asset Details
                        </DialogTitle>
                        <div class="mt-4">
                            <div v-if="assetInformation == 'No assigned asset information found for the provided Employee ID.'">
                                <!-- Display the assigned assets here -->
                                <p>No assigned asset information found for the provided Employee ID.</p>
                            </div>
                            <div v-else>
                                <!-- Display the message if no assets are assigned -->
                                <div v-for="(asset, index) in assetInformation" :key="index">
                                    <!-- Format your asset details here -->
                                    <p>{{ asset.name }} - {{ asset.description }}</p>
                                </div>
                            </div>
                            <button
                                type="button"
                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                @click="closeViewModal"
                            >
                                Close
                            </button>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </div>
    </Dialog>
</TransitionRoot>


                                    <!-- Assign button --> 
                                <button
                                    @click="openModal"
                                    class="bg-green-600 hover:bg-green-700 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300"
                                >
                                    Assign
                                </button>

                                <!-- TODO Assign Modal -->
                                <TransitionRoot as="template" :show="isModalVisible">
                                    <Dialog v-model="isModalVisible" as="div" class="relative z-50">
                                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                                        <div class="fixed inset-05" aria-hidden="true"></div>
                                    </TransitionChild>

                                    <div class="fixed inset-0 overflow-y-auto">
                                        <div class="flex min-h-full items-center justify-center p-4 text-center">
                                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                                            <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-lg bg-white  dark:bg-gray-700 p-6 text-left align-middle shadow-xl transition-all">
                                            <!-- Modal header -->
                                            <div class="flex justify-between items-start p-4 md:p-5 border-b dark:border-gray-600">
                                                <DialogTitle class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Choose Employee
                                                </DialogTitle>
                                                <!-- Placeholder for alignment -->
                                                <div class="w-8 h-8"></div>
                                            </div>
                                            
                                            <!-- Absolute positioned Close button -->
                                            <button type="button" class="absolute top-4 right-5 text-red-500 bg-transparent hover:bg-red-400 hover:text-red-600 rounded-full text-sm p-1.5 dark:hover:bg-red-500 dark:hover:text-gray-800" @click="closeModal">
                                                <!-- SVG for Close Icon -->
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <!-- ... SVG Code ... -->
                                                <span class="sr-only">Close modal</span>
                                            </button>

                                            <!-- Modal body -->
                                            <div class="relative p-4 md:p-5 space-y-4 max-h-[500px] overflow-y-auto bg-[#f5f5f7] dark:bg-[#0F172A] border border-gray-600 rounded-b-lg">
                                                <div class="absolute top-0 right-0 pt-2 pr-4">
                                            </div>

                                        <div class="grid grid-cols-3 gap-4">
                                            <select v-model="selectedType">
    <option disabled value="">Select a Type</option>
    <option v-for="type in assetTypes" :key="type" :value="type">{{ type }}</option>
  </select>

  <select v-model="selectedDescription" :disabled="!selectedType">
  <option disabled value="">Select a Description</option>
  <option v-for="item in assetDescriptions" :key="item.id" :value="item.id">{{ item.description }}</option>
</select>
                                        </div>

                                                <!-- Modal footer -->
                                                <div class="flex justify-center items-center px-4 py-3">
                                                <button @click="postAssetAssignments()" class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-1/2 md:w-32 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                                    Assign 
                                                </button>
                                                </div>
                                            </div>
                                            </DialogPanel>
                                        </TransitionChild>
                                        </div>
                                    </div>
                                    </Dialog>
                                </TransitionRoot>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
</template>
