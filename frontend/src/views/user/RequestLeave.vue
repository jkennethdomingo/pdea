<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import { initFlowbite } from 'flowbite';
import { useStore } from 'vuex';
import apiService from '@/composables/axios-setup';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { isDark } from '@/composables';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
  } from '@headlessui/vue'


const store = useStore();
const calendarRef = ref(null);
const calendar = ref(null);
const date = ref(new Date());
const drawerRef = ref(null);
const leaveTypes = ref([]);
const employeeId = ref('');
const leaveTypeId = ref('');
const startDate = ref('');
const endDate = ref('');
const reason = ref('');
const EmployeeID = computed(() => store.state.employeeID);

const isLoading = ref(true); 
const leaveTypesWithBalance = computed(() => store.state.employeeLeaveTypesWithBalance);



// Fetch employees data

// Function to handle form submission
async function submitLeaveRequest() {
  try {
    const response = await apiService.post('/manageLeave/requestLeave', {
      EmployeeID: EmployeeID.value,
      leave_type_id: leaveTypeId.value,
      start_date: startDate.value,
      end_date: endDate.value,
      reason: reason.value
    });

    if (response.status === 201) {
      // Handle success
      alert('Leave entry added successfully.');
      // Reset form
      employeeId.value = '';
      leaveTypeId.value = '';
      startDate.value = '';
      endDate.value = '';
      reason.value = '';

    }
  } catch (error) {
    // Handle errors
    console.error('Error submitting leave request:', error);
    alert('Failed to submit leave request.');

  }
}


// Watch for changes in the date picker and update the calendar
watch(date, (newDate) => {
  if (calendarRef.value) {
    const calendarApi = calendarRef.value.getApi();
    calendarApi.gotoDate(newDate);
  }
});


// Fetch training data on component mount
onMounted(async () => {
  initFlowbite();
  
  if (EmployeeID.value) {
        try {
          await store.dispatch('fetchEmployeeInformation', EmployeeID.value);
          await store.dispatch('fetchEmployeeLeaveTypesWithBalance', EmployeeID.value);
          updateEmployeeName(response.employee);
        } catch (error) {
          console.error('Failed to fetch employee information:', error);
          // Handle the error appropriately
        }
      }
    
      await store.dispatch('fetchEmployeeLeaveRequests', EmployeeID.value);
  setTimeout(() => {
    isLoading.value = false; // Stop loading after a delay
  }, 2000);
});


const calendarOptions = ref({
  plugins: [
    dayGridPlugin,
    timeGridPlugin,
    interactionPlugin, // needed for dateClick
    listPlugin
  ],
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
  },
  initialView: 'dayGridMonth',
  editable: true,
  selectable: true,
  selectMirror: true,
  dayMaxEvents: true,
  weekends: true,
  select: handleDateSelect,
  eventClick: handleEventClick,
  eventsSet: handleEvents,
  height: 'auto', // or set a specific numeric value
  contentHeight: 'auto', // or set a specific numeric value
});


function handleWeekendsToggle() {
}

function handleDateSelect(selectInfo) {

startDate.value = selectInfo.startStr;
date.value = selectInfo.startStr;
openRightDrawer();

}

function handleEventClick(clickInfo) {

}

function handleEvents(events) {
}


const formatTimeAgo = (dateString) => {
  const now = new Date();
  const requestedTime = new Date(dateString);
  const differenceInMilliseconds = now - requestedTime;
  const hours = differenceInMilliseconds / 36e5; // 36e5 milliseconds in an hour
  const days = hours / 24;
  const weeks = days / 7;
  const months = days / 30; // approximate value for a month
  const years = days / 365;

  const pluralize = (value, word) => value === 1 ? `${value} ${word} ago` : `${value} ${word}s ago`;

  if (hours < 24) {
    return pluralize(Math.round(hours), 'hour');
  } else if (days < 7) {
    return pluralize(Math.round(days), 'day');
  } else if (weeks < 4) {
    return pluralize(Math.round(weeks), 'week');
  } else if (months < 12) {
    return pluralize(Math.round(months), 'month');
  } else {
    return pluralize(Math.round(years), 'year');
  }
};

const categories = computed(() => ({
  Pending: isLoading.value ? [] : store.state.employeeleaveRequests.pending.map(request => ({
    id: request.LeaveID,
    title: `${request.EmployeeName} requesting a leave`,
    date: formatTimeAgo(request.TimeRequested)
  })),
  Approved: store.state.employeeleaveRequests.approved.map(request => ({
    id: request.LeaveID,
    title: `${request.EmployeeName}'s leave request approved`,
    date: formatTimeAgo(request.TimeRequested)
  })),
  Rejected: store.state.employeeleaveRequests.rejected.map(request => ({
    id: request.LeaveID,
    title: `${request.EmployeeName}'s leave request rejected`,
    date: formatTimeAgo(request.TimeRequested)
  })),
}));


function moveToday() {
  const calendarApi = calendarRef.value.getApi();
  calendar.value.move(new Date());
    calendarApi.gotoDate(new Date());
}

const CancelRequest = async (id) => {
  // Implement the denial logic, possibly dispatching a Vuex action
  await store.dispatch('deleteEmployeeLeaveRequest', id);
  await store.dispatch('fetchEmployeeLeaveRequests', EmployeeID.value);
  show.value = false;
};

const show = ref(false);
const viewModalOpen = ref(false);
const openViewModal = (post) => {
  viewModalOpen.value = true;
};

const closeModal = () => {
  viewModalOpen.value = false;
};

function toggleModal() {
  show.value = !show.value;
}

const isDrawerOpen = ref(false);

function openDrawer() {
  isDrawerOpen.value = true;
}

function closeDrawer() {
  isDrawerOpen.value = false;
}

function openRightDrawer() {
  isDrawerOpen.value = true; // Opens the DaisyUI drawer
}

</script>

<template>


      <!-- Add Modal Start-->
    <!-- drawer init and toggle -->
    <div class="text-center hidden">
        <button 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
            type="button" 
            data-drawer-target="dynamic-drawer" 
            data-drawer-show="dynamic-drawer" 
            data-drawer-placement="right" 
            aria-controls="dynamic-drawer">
            Show right drawer
        </button>
    </div>

    <div ref="drawerRef"
id="dynamic-drawer" 
class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" 
tabindex="-1" 
aria-labelledby="drawer-label">
</div>


<div ref="drawerRef" class="drawer drawer-end" :class="{'z-50': isDrawerOpen}">
    <input id="dynamic-drawer" type="checkbox" class="drawer-toggle" v-model="isDrawerOpen" />
    <div class="drawer-content">
      <!-- Main page content here (if you have any content that should be outside the drawer) -->
    </div>

    <div class="drawer-side">
      <label for="dynamic-drawer" class="drawer-overlay"></label>
      <ul class="p-4 w-80 dark:bg-base-100 bg-gray-200 text-base-content h-screen">
<h5 id="drawer-label" class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 uppercase dark:text-gray-400"><svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
</svg>Request Leave</h5>
        <button type="button" @click="closeDrawer" aria-controls="dynamic-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
          <span class="sr-only">Close menu</span>
        </button>

        <form class="mb-6" @submit.prevent="submitLeaveRequest">
            <div class="mb-6 px-4">
              <!-- Title Field -->
              <div class="mb-4">
              <input 
                  type="hidden" 
                  id="employeeName" 
                  v-model="EmployeeID"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                  readonly
                  >
              </div>

              <div class="mb-4">
                  <label for="leaveTypeSelect" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Leave Type</label>
                  <select v-model="leaveTypeId" id="leaveTypeSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option disabled value="">Please select a leave type</option>
                  <option v-for="type in leaveTypesWithBalance" :key="type.LeaveTypeID" :value="type.LeaveTypeID">
                  {{ type.LeaveTypeName }} ({{ type.RemainingBalance }} days remaining)
                  </option>
                  </select>

                  </div>

                  <!-- Start Date Field -->
                  <div class="mb-6">
                  <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                  <input type="date" id="start_date" v-model="startDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                  </div>

                  <!-- End Date Field -->
                  <div class="mb-6">
                  <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                  <input type="date" id="end_date" v-model="endDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                  </div>

                  <!-- Reason Field -->
                  <div class="mb-6">
                  <label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason for Leave</label>
                  <textarea id="reason" v-model="reason" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required></textarea>
                  </div>

                  <!-- Conducted By Field (Removed as it's not in the DB schema) -->

                  <!-- Submit Button -->
                  <!-- Submit Button -->
                  <div class="flex justify-start space-x-2">
                  <button type="submit" class="text-white justify-center flex items-center bg-green-700 hover:bg-green-600 w-40 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><path fill="currentColor" d="M224 30v256h-64l96 128l96-128h-64V30h-64zM32 434v48h448v-48H32z"/>
                    </svg> Save
                  </button>
                  <button type="" class="text-white justify-center flex items-center bg-red-700 hover:bg-red-600 w-40 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg> Delete
                  </button>
                  </div>

              </div>
            </form>
          </ul>
              <!-- Dynamic content goes here -->

      </div>
  </div>

    <!-- Add Modal End-->


    <!--Bawal-->
    <div class='flex flex-wrap min-h-full font-sans text-sm'>
  <!-- Left sidebar for mini calendar and TabGroup -->
  <div class="w-full lg:w-1/4 px-2 mb-4"> <!-- Sidebar takes 1/4 of the width on large screens -->
    <!-- Mini calendar (VDatePicker) -->
    <div class="mb-4">
      <VDatePicker  class="px-4" ref="calendar" v-model="date" :is-dark="isDark">
        <template #footer>
          <div class="w-full px-4 pb-3">
            <button
              class="bg-green-600 hover:bg-green-700 text-white font-bold w-full px-3 py-1 rounded-md"
              @click="moveToday"
            >
              Today
            </button>
          </div>
        </template>
     </VDatePicker>
    </div>

    <!-- TabGroup Component -->
    <div class="max-w-xs px-2 py-0 sm:px-0">
      <TabGroup>
        <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
          <Tab
              v-for="category in Object.keys(categories)"
              as="template"
              :key="category"
              v-slot="{ selected }"
          >
              <button
                  :class="[
                      'w-full rounded-lg py-1 text-sm font-medium leading-5', 
                      'ring-white/60 ring-offset-2 ring-offset-black focus:outline-none focus:ring-2',
                      selected
                          ? 'bg-green-600 dark:bg-green-600 text-white dark:text-white shadow'
                          : 'text-gray-600 dark:text-gray-200 hover:bg-white/[0.12] hover:text-green-500',
                  ]"
              >
                  {{ category }}
              </button>
          </Tab>
        </TabList>
        <TabPanels class="mt-2">
          <TabPanel
    v-for="(posts, category) in categories"
    :key="category"
    class="rounded-xl bg-white dark:bg-[#0F172A] p-2 border-2 border-gray-200 dark:border-gray-700"
  >
    <div class="loading loading-spinner" v-if="isLoading && category === 'Pending'">
    </div>
    <ul v-else class="max-h-40 overflow-y-auto ">
      <li
        v-for="post in posts"
        :key="post.id"
        class="rounded-md p-2 hover:bg-gray-300 dark:hover:bg-green-500"
      >
        <h3 class="text-sm font-medium leading-5">
          {{ post.title }}
        </h3>
        <ul class="mt-1 flex space-x-1 text-xs font-normal leading-4 text:gray-700 dark:text-gray-300">
          <li>{{ post.date }}</li>
        </ul>
        <!-- Conditionally render Approval and Denial Buttons -->
        <div 
          class="flex justify-end space-x-2 mt-2" 
          v-if="category === 'Pending'"
        >

        <button
  type="button"
  @click="openViewModal(post)"
  class="text-white bg-green-600 hover:bg-green-800 rounded-lg text-xs px-4 py-1"
>
  View
</button>

<TransitionRoot :show="viewModalOpen" as="template">
  <Dialog as="div" @close="() => viewModalOpen.value = false" class="relative z-10">
    <TransitionChild
      as="template"
      enter="duration-300 ease-out"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <div class="fixed inset-0 bg-black/25" />
    </TransitionChild>

    <div class="fixed inset-0 overflow-y-auto">
      <div class="flex min-h-full items-center justify-center p-4 text-center">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-[#DDE6ED] dark:bg-gray-600 p-6 text-left align-middle shadow-xl transition-all">
            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-green-800 dark:text-green-200">
             You are requesting for a leave
            </DialogTitle>
            <div class="mt-2">
              <p class="text-sm text-gray-800 dark:text-gray-200">
                Reason for leave: 

                <!-- Include other relevant details here -->
              </p>
            </div>

            <div class="mt-4">
              <button
              type="button"
              class="flex justify-end rounded-md border border-transparent bg-green-600 hover:bg-green-800 px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
              @click="closeModal"
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


      <button
    @click="toggleModal"
    class="text-white bg-red-600 hover:bg-red-700 rounded-lg text-xs px-4 py-1">
    Cancel
  </button>

  <TransitionRoot :show="show" as="template">
  <Dialog as="div" @close="toggleModal" class="relative z-10">
    <TransitionChild
      as="template"
      enter="duration-300 ease-out"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <div class="fixed inset-0 bg-black/25" />
    </TransitionChild>

    <div class="fixed inset-0 overflow-y-auto">
      <div class="flex min-h-full items-center justify-center p-4 text-center">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel class="max-w-xs transform overflow-hidden rounded-2xl bg-[#f5f5f7] dark:bg-base-100 border border-green-500 shadow-xl transition-all">
            <DialogTitle class="flex justify-center font-semibold text-xl text-red-600 dark:text-red-600">Wait!</DialogTitle>
            <div class="mt-2">
              <p class="text-lg font-bold text-center text-gray-800 dark:text-gray-200">
                Are you sure you want to cancel your Leave Request?
              </p>
            </div>
            <div class="modal-action flex justify-center pt-2 pb-2 space-x-3">
              <button @click="CancelRequest(post.id)" class="text-xs px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg">Yes</button>
              <button @click="toggleModal" class="text-xs px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg">No</button>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </div>
  </Dialog>
</TransitionRoot>


        </div>
      </li>
    </ul>
  </TabPanel>
</TabPanels>
      </TabGroup>
    </div>
  </div>

  
  

  <!-- Main content area for FullCalendar -->
  <div class="w-full lg:w-3/4 px-2"> <!-- Main content takes 3/4 of the width on large screens -->
    <div class="flex-grow p-12 text-md text-black dark:text-green-400 bg-white dark:bg-[#0F172A] px-3 py-7 rounded-xl">
      <FullCalendar ref="calendarRef" :options="calendarOptions"></FullCalendar>
    </div>
  </div>
</div>
</template>


