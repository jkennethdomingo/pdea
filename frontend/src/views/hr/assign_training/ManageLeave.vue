<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import { initFlowbite } from 'flowbite';
import { useStore } from 'vuex';
import { errorToast, successToast } from '@/toast/index';
import Button from '@/components/base/Button';
import userAvatar from '@/assets/images/avatar.jpg'
import apiService from '@/composables/axios-setup';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

const categories = ref({
  Pending: [
    {
      id: 1,
      title: 'Does drinking coffee make you smarter?',
      date: '5h ago',
      commentCount: 5,
      shareCount: 2,
    },
    {
      id: 2,
      title: "So you've bought coffee... now what?",
      date: '2h ago',
      commentCount: 3,
      shareCount: 2,
    },
  ],
  Approved: [
    {
      id: 1,
      title: 'Is tech making coffee better or worse?',
      date: 'Jan 7',
      commentCount: 29,
      shareCount: 16,
    },
    {
      id: 2,
      title: 'The most innovative things happening in coffee',
      date: 'Mar 19',
      commentCount: 24,
      shareCount: 12,
    },
  ],
  Denied: [
    {
      id: 1,
      title: 'Ask Me Anything: 10 answers to your questions about coffee',
      date: '2d ago',
      commentCount: 9,
      shareCount: 5,
    },
    {
      id: 2,
      title: "The worst advice we've ever heard about coffee",
      date: '4d ago',
      commentCount: 1,
      shareCount: 2,
    },
  ],
})

const store = useStore();
const calendarRef = ref(null);
const date = ref(new Date()); // Assuming this is your VDatePicker model
const drawerRef = ref(null);
const leaveTypes = ref([]);
// Reactive form data
const employeeId = ref('');
const leaveTypeId = ref('');
const startDate = ref('');
const endDate = ref('');
const reason = ref('');
const employeesOnLeave = ref([]);


function openRightDrawer() {
  // Remove 'translate-x-full' and add 'translate-x-0' to show the drawer
  drawerRef.value.classList.remove('translate-x-full');
  drawerRef.value.classList.add('translate-x-0');
}


const employees = ref([]);

// Fetch employees data
async function fetchEmployees() {
  try {
    const response = await apiService.post('/manageLeave/getAllEmployees'); // Update the endpoint if needed
    employees.value = response.data;
  } catch (error) {
    console.error('Error fetching employees:', error);
  }
}

async function fetchLeaveTypes() {
  try {
    const response = await apiService.post('/manageLeave/getAllLeaveTypes'); // Adjust the endpoint if needed
    leaveTypes.value = response.data;
  } catch (error) {
    console.error('Error fetching leave types:', error);
  }
}

// Function to handle form submission
async function submitLeaveRequest() {
  try {
    const response = await apiService.post('/manageLeave/manualInputLeave', {
      EmployeeID: employeeId.value,
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

      await fetchEmployeesOnLeave();
    }
  } catch (error) {
    // Handle errors
    console.error('Error submitting leave request:', error);
    alert('Failed to submit leave request.');

  }
}

async function fetchEmployeesOnLeave() {
  try {
    const response = await apiService.post('/manageLeave/getEmployeeOnLeave');
    employeesOnLeave.value = response.data.EmployeeOnLeave;
  } catch (error) {
    console.error('Error fetching employees on leave:', error);
  }
}

const leaveEvents = computed(() => {
  return employeesOnLeave.value.map(leave => ({
    id: leave.id,
    title: `${leave.surname}, ${leave.first_name} - ${leave.LeaveTypeName}`,
    start: leave.start_date,
    end: leave.end_date
    // Add more fields if needed
  }));
});

watch(leaveEvents, (newEvents) => {
  if (calendarRef.value) {
    const calendarApi = calendarRef.value.getApi();
    calendarApi.removeAllEvents(); // Remove old events
    calendarApi.addEventSource(newEvents); // Add new events
  }
}, { deep: true });

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
  await store.dispatch('getEmployeeOnLeave'); // Dispatch the action to fetch employee leave data
  await fetchEmployees(); // Fetch the employees data
  await fetchLeaveTypes();
  await fetchEmployeesOnLeave();
});

// Calendar options
const calendarOptions = ref({
  plugins: [
    dayGridPlugin,
    timeGridPlugin,
    interactionPlugin,
    listPlugin
  ],
  headerToolbar: {
    left: 'prev,next,addEventButton',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek,today'
  },
  customButtons: {
    addEventButton: {
      text: 'Add event',
      click: () => openAddEventDialog()
    },
  },
  initialView: 'dayGridMonth',
  initialEvents: leaveEvents.value, // Assuming trainingEvents is a reactive ref
  editable: true,
  selectable: true,
  selectMirror: true,
  dayMaxEvents: true,
  weekends: true,
  select: handleDateSelect, // Assuming handleDateSelect is a method
  eventClick: handleEventClick, // Assuming handleEventClick is a method
  eventsSet: handleEvents, // Assuming handleEvents is a method
  height: 'auto', // or set a specific numeric value
  contentHeight: 'auto', // or set a specific numeric value
});



function openAddEventDialog() {
  // Logic to open the dialog to add a new event
}

function handleDateSelect(selectInfo) {

  startDate.value = selectInfo.startStr;
  date.value = selectInfo.startStr;
  openRightDrawer();

  console.log(leaveEvents.value)
}

async function handleEventClick(clickInfo) {
  // Extract event data from clicked event
}


function handleEvents(events) {
  // Handle events set
}

function handleWeekendsToggle() {
  // Handle weekends toggle
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

    <!-- dynamic drawer component -->
    <div ref="drawerRef"
        id="dynamic-drawer" 
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" 
        tabindex="-1" 
        aria-labelledby="drawer-label">
        
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 uppercase dark:text-gray-400"><svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
        </svg>Add Leave</h5>
        <button type="button" data-drawer-hide="dynamic-drawer" aria-controls="dynamic-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <form class="mb-6" @submit.prevent="submitLeaveRequest">
        <!-- Title Field -->
        <div class="mb-4">
  <label for="employeeSelect" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Employee</label>
  <select v-model="employeeId" id="employeeSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    <!-- Non-selectable placeholder option -->
    <option disabled selected value="">Please select an employee</option>

    <!-- Employee options -->
    <option v-for="employee in employees" :key="employee.EmployeeID" :value="employee.EmployeeID">
      {{ employee.FirstName }} {{ employee.MiddleName }} {{ employee.Surname }}
    </option>
  </select>
</div>

<div class="mb-4">
    <label for="leaveTypeSelect" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Leave Type</label>
    <select v-model="leaveTypeId" id="leaveTypeSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      <!-- Non-selectable placeholder option -->
      <option disabled selected value="">Please select a leave type</option>

      <!-- Leave type options -->
      <option v-for="type in leaveTypes" :key="type.LeaveTypeID" :value="type.LeaveTypeID">
        {{ type.LeaveTypeName }}
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
  <button type="submit" class="text-white justify-center flex items-center bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
    <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z"/>
      <path d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z"/>
    </svg> Create event
  </button>
</form>
        <!-- Dynamic content goes here -->
        
    </div>

    <!-- Add Modal End-->
    
<!--Bawal-->
<div class='flex flex-wrap min-h-full font-sans text-sm'>
  <!-- Left sidebar for mini calendar and TabGroup -->
  <div class="w-full lg:w-1/4 px-2 mb-4"> <!-- Sidebar takes 1/4 of the width on large screens -->
    <!-- Mini calendar (VDatePicker) -->
    <div class="mb-4">
      <VDatePicker class="px-4" v-model="date" />
    </div>

    <!-- TabGroup Component -->
    <div class="max-w-xs px-2 py-4 sm:px-0">
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
                          : 'text-blue-100 hover:bg-white/[0.12] hover:text-white',
                  ]"
              >
                  {{ category }}
              </button>
          </Tab>
        </TabList>
        <TabPanels class="mt-2">
          <TabPanel
              v-for="(posts, idx) in Object.values(categories)"
              :key="idx"
              class="rounded-xl bg-white dark:bg-dark-bg p-2 border-2 border-gray-200 dark:border-gray-700"
          >
              <ul>
                  <li
                      v-for="post in posts"
                      :key="post.id"
                      class="relative rounded-md p-2 hover:bg-gray-100 dark:hover:bg-green-500"
                  >
                      <h3 class="text-sm font-medium leading-5">
                          {{ post.title }}
                      </h3>
                      <ul
                          class="mt-1 flex space-x-1 text-xs font-normal leading-4 text-gray-500"
                      >
                          <li>{{ post.date }}</li>
                          <li>&middot;</li>
                          <li>{{ post.commentCount }} comments</li>
                          <li>&middot;</li>
                          <li>{{ post.shareCount }} shares</li>
                      </ul>
                      <a
                          href="#"
                          class="absolute inset-0 rounded-md"
                      ></a>
                  </li>
              </ul>
          </TabPanel>
        </TabPanels>
      </TabGroup>
    </div>
  </div>

  <!-- Main content area for FullCalendar -->
  <div class="w-full lg:w-3/4 px-2"> <!-- Main content takes 3/4 of the width on large screens -->
    <div class='flex-grow p-12 text-md text-black dark:text-green-400 bg-white dark:bg-dark-bg px-3 py-3 rounded-xl'>
      <FullCalendar ref="calendarRef" :options="calendarOptions"></FullCalendar>
    </div>
  </div>
</div>
</template>





