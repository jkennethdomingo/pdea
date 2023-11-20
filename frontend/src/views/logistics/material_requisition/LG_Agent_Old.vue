<script setup>
import Button from '@/components/base/Button.vue';
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const showModal = ref(false);
const selectedDate = ref(null); // Use this to get/set the date value

const toggleModal = () => {
  showModal.value = !showModal.value;
};

const fileInput = ref(null);

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    console.log('File selected:', file.name);
    // Handle the file selection
  }
};

// New code starts here
const article = ref('');
const description = ref('');
const yrAcquired = ref('');
const serialNumber = ref('');
const propertyNumber = ref('');
const unitOfMeasure = ref('');
const unitValue = ref('');
const qtyPerPropertyCard = ref('');
const physicalCount = ref('');
const shortageOverageQty = ref('');
const shortageOverageValue = ref('');
const status = ref('');
const remarksWhereabouts = ref('');

const records = ref([]);

const addRecord = () => {
    records.value.push({
        article: article.value,
        description: description.value,
        yrAcquired: yrAcquired.value,
        serialNumber: serialNumber.value,
        propertyNumber: propertyNumber.value,
        unitOfMeasure: unitOfMeasure.value,
        unitValue: unitValue.value,
        qtyPerPropertyCard: qtyPerPropertyCard.value,
        physicalCount: physicalCount.value,
        shortageOverageQty: shortageOverageQty.value,
        shortageOverageValue: shortageOverageValue.value,
        status: status.value,
        remarksWhereabouts: remarksWhereabouts.value
    });

    // Reset form fields
    article.value = '';
    description.value = '';
    yrAcquired.value = '';
    serialNumber.value = '';
    propertyNumber.value = '';
    unitOfMeasure.value = '';
    unitValue.value = '';
    qtyPerPropertyCard.value = '';
    physicalCount.value = '';
    shortageOverageQty.value = '';
    shortageOverageValue.value = '';
    status.value = '';
    remarksWhereabouts.value = '';
};

onMounted(async () => {
  await store.dispatch('getData');
});

</script>


<template>
    <section class="bg-white h-full rounded-lg dark:bg-gray-900">
<!-- component -->
<div class="flex flex-col min-h-3/6 rounded-lg bg-gray-900">
  <div class="container m-4">
    <div class="max-w-3xl w-72 ml-0 grid gap-4 grid-cols-1">
      <!-- profile card -->
      <div class="flex flex-col">
        <div class="bg-gray-800 border border-gray-800 shadow-lg rounded-2xl p-4">
          <div class="flex-none sm:flex">
            <div class=" relative h-32 w-32   sm:mb-0 mb-3">
              <img src="https://tailwindcomponents.com/storage/avatars/njkIbPhyZCftc4g9XbMWwVsa7aGVPajYLRXhEeoo.jpg" alt="aji" class=" w-32 h-32 object-cover rounded-2xl">
            </div>
            <div class="flex-auto sm:ml-5 mt-8 justify-evenly">
              <div class="flex items-center justify-between sm:mt-2">
                <div class="flex items-center">
                  <div class="flex flex-col">
                    <div class="w-4 flex-none text-xl text-gray-200 font-bold leading-none">JD</div>
                    <div class="flex-auto text-gray-400 my-1">
                      <span class="mr-1 ">Agent</span><span class="mr-1 border-r border-gray-600  max-h-0"></span><span>PDEA</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex pt-2  text-sm text-gray-400">
                <button data-modal-target="timeline-modal" data-modal-toggle="timeline-modal" 
                    class="flex-no-shrink bg-green-400 hover:bg-green-500 mr-1 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300">
                    View
                </button>
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" 
                    class="flex-no-shrink bg-green-400 hover:bg-green-500 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300">
                    Assign
                </button>



<!-- Main modal of View -->
<div id="timeline-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Records
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="timeline-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 overflow-y-auto max-h-[500px]">
                    <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                    <li v-for="(record, index) in records" :key="index" class="mb-4">
                        <!-- Display each record's details here -->
                        <div>article: {{ record.article }}</div>
                        <div>description: {{ record.description }}</div>
                        <div>yrAcquired: {{ record.yrAcquired }}</div>
                        <div>serialNumber: {{ record.serialNumber }}</div>
                        <div>propertyNumber: {{ record.propertyNumber }}</div>
                        <div>unitOfMeasure: {{ record.unitOfMeasure }}</div>
                        <div>unitValue: {{ record.unitValue }}</div>
                        <div>qtyPerPropertyCard: {{ record.qtyPerPropertyCard }}</div>
                        <div>physicalCount: {{ record.physicalCount }}</div>
                        <div>shortageOverageQty: {{ record.shortageOverageQty }}</div>
                        <div>shortageOverageValue: {{ record.shortageOverageValue }}</div>
                        <div>status: {{ record.status }}</div>
                        <div>remarksWhereabouts: {{ record.remarksWhereabouts }}</div>
                        <!-- Add other fields as needed -->
                    </li>
                </ol>
                </div>
            </div>
    </div>
</div> 


                 <!-- Main modal Assign-->
                <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-1 md:p-1 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold ml-40 text-gray-900 dark:text-white">
                                    ASSIGN
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>


                    <!-- Modal body -->
                    <form action="#" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="article" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Article</label>
                                <input type="text" name="article" id="article" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type article name" required="">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="description" rows="1" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write description here"></textarea>
                            </div>
                        </div>

                       <div class="grid grid-cols-2 gap-4 pb-2"> <!-- Adjust the gap as needed -->
                        <div>
                            <label for="yr_acquired" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Acquired</label>
                            <input 
                            id="yr_acquired"
                            type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            v-model="yr_acquired"
                            />
                        </div>
                        <div>
                            <label for="serial_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial</label>
                            <input 
                            id="serial_number"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Type serial number"
                            required=""
                            />
                        </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pb-2"> <!-- Pnum Umes -->
                        <div>
                            <label for="property_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Property Num.</label>
                            <input 
                            id="property_number"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Type property number"
                            required=""
                            />
                        </div>
                        <div>
                            <label for="unit_of_measure" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit Measure</label>
                            <input 
                            id="unit_of_measure"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Type unit measure"
                            required=""
                            />
                        </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 pb-2"> <!-- qnty-->
                        <div>
                            <label for="unit_value" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit Value</label>
                            <input 
                            id="unit_value"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="unit value"
                            required=""
                            />
                        </div>
                        <div>
                            <label for="qty_per_property_card" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">QTY Prprty Card</label>
                            <input 
                            id="qty_per_property_card"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="quantity"
                            required=""
                            />
                        </div>
                        <div>
                            <label for="physical_count" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">QTY Physical Card</label>
                            <input 
                            id="physical_count"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="quantity"
                            required=""
                            />
                        </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 pb-2"> <!-- shrtge -->
                        <!-- Quantity input -->
                        <div>
                            <label for="shortage_overage_qty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                            <input 
                            id="shortage_overage_qty"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="shortage/overage"
                            required=""
                            />
                        </div>
                        
                        <!-- Value input -->
                        <div>
                            <label for="shotage_overage_value" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Value</label>
                            <input 
                            id="shotage_overage_value"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="shortage/overage"
                            required=""
                            />
                        </div>
                        
                        <!-- Status dropdown -->
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select 
                            id="status"
                            class="bg-gray-50 border border-gray-300 text-black dark:text-white text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500"
                            required=""
                            >
                            <option value="">Select status</option>
                            <option value="svc">svc</option>
                            <option value="unsvc">unsvc</option>
                            </select>
                        </div>
                        </div>

                        <div class="gap-4 mb-4">
                            <div class="col-span-2">
                                <label for="remarks_whereabouts" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks & Whereabouts</label>
                                <input type="text" name="name" id="remarks_whereabouts" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type Remarks & Whereabouts" required="">
                            </div>
                        </div>


                        <div class="flex justify-center">
                        <button type="submit" class="text-white inline-flex items-center w- bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                            Save
                        </button>
                        </div>
                    </form>


                        </div>
                    </div>
                </div> 
            </div>
            </div>
        </div>
            </div>
         </div>
      </div>
    </div>

  </div>


    </section>
</template>

