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
import { usePhotoUrl } from '@/composables/usePhotoUrl';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

const isDark = ref(false);
const isLoading = ref(true); 



const store = useStore();
const calendarRef = ref(null);
const date = ref(new Date()); // Assuming this is your VDatePicker model
const drawerRef = ref(null);
const editdrawerRef = ref(null);
const openAssignModalRef = ref(null);

const { getPhotoUrl } = usePhotoUrl(); 


const newEvent = ref({
  title: '',
  period_from: '',
  period_to: '',
  number_of_hours: '',
  conducted_by: '',
  employees: [],
  photos: [],
  employee_ids:[],
});



const trainingbyTitle = computed(() => store.state.trainingbyTitle);

// Computed property for transforming training data
const trainingEvents = computed(() => {
  return store.state.training.map(event => ({
    id: event.training_id,
    title: event.title,
    start: event.period_from,
    end: event.period_to
    // Add more fields if needed
  }));
});

const employeeCheckboxes = ref([]);

const clearCheckboxes = () => {
  employeeCheckboxes.value.forEach(checkbox => {
    checkbox.checked = false;
  });
};


const employeeInfo = computed(() => {
  return store.state.employeeInfo.map(employee => ({
    EmployeeID: employee.EmployeeID,
    first_name: employee.first_name,
    surname: employee.surname,
    photo: employee.photo,
    DateOfEntry: employee.DateOfEntry,
    IPCR: employee.IPCR,
    // Add more fields if needed
  }));
});


const resetNewEvent = () => {
  newEvent.value = {
    title: '',
    period_from: '',
    period_to: '',
    number_of_hours: '',
    conducted_by: '',
    employees: [],
  };
  clearCheckboxes();
};


// Watch for changes in the date picker and update the calendar
watch(date, (newDate) => {
  if (calendarRef.value) {
    const calendarApi = calendarRef.value.getApi();
    calendarApi.gotoDate(newDate);
  }
});


// Watch for changes in training events and update the calendar
watch(trainingEvents, (newEvents) => {
  if (calendarRef.value) {
    const calendarApi = calendarRef.value.getApi();
    calendarApi.removeAllEvents(); // Remove old events
    calendarApi.addEventSource(newEvents); // Add new events
  }
}, { deep: true });

// Fetch training data on component mount
onMounted(async () => {
  initFlowbite();
  await store.dispatch('getTraining'); // Dispatch the action to fetch training data
  await store.dispatch('fetchEmployeeInfo');
  isLoading.value = true; // Start loading
  await store.dispatch('fetchTrainingsWithoutEmployees');
  setTimeout(() => {
    isLoading.value = false; // Stop loading after a delay
  }, 2000);
  await store.dispatch('fetchTrainingSessions');
  setTimeout(() => {
    isLoading.value = false; // Stop loading after a delay
  }, 2000);
});

const trainingCategories = computed(() => ({
  Unassigned: isLoading.value ? [] : store.state.trainingSessions.unassigned_or_pending.map(session => ({
    id: session.TrainingID,
    title: `${session.Title} training session is pending`,
    date: session.CreatedAt // Format this date as needed
  })),
  Upcoming: store.state.trainingSessions.upcoming.map(session => ({
    id: session.TrainingID,
    title: `${session.Title} training session has no employees assigned`,
    date: session.PeriodFrom // Assuming you want to show the start date for upcoming sessions
  })),
  Finished: store.state.trainingSessions.finished.map(session => ({
    id: session.TrainingID,
    title: `${session.Title} training session has finished`,
    date: session.PeriodTo // Assuming you want to show the end date for finished sessions
  })),
}));

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
      text: 'Assign Training',
      click: () => openAddEventDialog()
    },
  },
  initialView: 'dayGridMonth',
  initialEvents: trainingEvents.value, // Assuming trainingEvents is a reactive ref
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

function openEditRightDrawer() {
  // Remove 'translate-x-full' and add 'translate-x-0' to show the drawer
  editdrawerRef.value.classList.remove('translate-x-full');
  editdrawerRef.value.classList.add('translate-x-0');
}


function openRightDrawer() {
  // Remove 'translate-x-full' and add 'translate-x-0' to show the drawer
  drawerRef.value.classList.remove('translate-x-full');
  drawerRef.value.classList.add('translate-x-0');
}

function openAddEventDialog() {
  // Logic to open the dialog to add a new event
  
  newEvent.value = {
    title: '',
    period_from: '',
    period_to: '',
    number_of_hours: null,
    conducted_by: '',
  };

  openRightDrawer();
}

function handleDateSelect(selectInfo) {

  newEvent.value = {
    title: '',
    period_from: selectInfo.startStr,
    period_to: selectInfo.startStr,
    number_of_hours: null,
    conducted_by: '',
    employees: [],
  };

  date.value = selectInfo.startStr;
  openRightDrawer();

}


watch(trainingbyTitle, (newTraining) => {
  if (newTraining && newTraining.length > 0) {
    const trainingData = newTraining[0]; // Assuming you want the first item
    newEvent.value = {
      training_id: trainingData.training_id,
      title: trainingData.title,
      period_from: trainingData.period_from,
      period_to: trainingData.period_to,
      number_of_hours: trainingData.number_of_hours,
      conducted_by: trainingData.conducted_by,
      photo: trainingData.photos,
      employee_ids: trainingData.employee_ids,
    };
  }
}, { immediate: true });

async function handleEventClick(clickInfo) {
  // Extract event data from clicked event
  const eventData = clickInfo.event;

  await store.dispatch('getTrainingByTitle', eventData.title);

  // Open the edit right drawer
  openEditRightDrawer();
}


function handleEvents(events) {
  // Handle events set
}

function handleWeekendsToggle() {
  // Handle weekends toggle
}

const updateEmployeeList = (employeeId) => {
  // Initialize employees as an array if it's undefined
  if (!Array.isArray(newEvent.value.employees)) {
    newEvent.value.employees = [];
  }

  // Now proceed with the logic
  const index = newEvent.value.employees.indexOf(employeeId);
  if (index > -1) {
    newEvent.value.employees.splice(index, 1);
  } else {
    newEvent.value.employees.push(employeeId);
  }
};


const addEvent = async () => {
  await store.dispatch('addEvent', newEvent.value);
  await store.dispatch('getTraining');
  // Reset newEvent here
  resetNewEvent();
};

const editEvent = async () => {
  await store.dispatch('editEvent', newEvent.value);
  await store.dispatch('getTraining');
  // Reset newEvent here
  resetNewEvent();
};

const approveRequest = (postId) => {
  // Logic to approve the request
  console.log('Approved request:', postId);
};

const denyRequest = (postId) => {
  // Logic to deny the request
  console.log('Denied request:', postId);
};


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
        </svg>Assign Training</h5>
        <button type="button" data-drawer-hide="dynamic-drawer" aria-controls="dynamic-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <form @submit.prevent="addEvent" class="mb-6">
        <!-- Title Field -->
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" v-model="newEvent.title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Event Title" required>
        </div>

        <!-- Period From Field -->
        <div class="mb-6">
            <label for="period_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period From</label>
            <input type="date" v-model="newEvent.period_from" id="period_from" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <!-- Period To Field -->
        <div class="mb-6">
            <label for="period_to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period To</label>
            <input type="date" v-model="newEvent.period_to" id="period_to" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <!-- Number of Hours Field -->
        <div class="mb-6">
            <label for="number_of_hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Hours</label>
            <input type="number" v-model="newEvent.number_of_hours" id="number_of_hours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <!-- Conducted By Field -->
        <div class="mb-6">
            <label for="conducted_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conducted By</label>
            <input type="text" v-model="newEvent.conducted_by" id="conducted_by" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Conductor's Name" required>
        </div>

        <div class="mb-4">
          

          <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Choose Employee
      </button>
        </div>

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
    </form>
        <!-- Dynamic content goes here -->
        
    </div>

    <!-- Add Modal End-->

    <!--Edit Modal Start-->

    <!-- drawer init and toggle -->
    <div class="text-center hidden">
        <button 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
            type="button" 
            data-drawer-target="edit-dynamic-drawer" 
            data-drawer-show="edit-dynamic-drawer" 
            data-drawer-placement="right" 
            aria-controls="edit-dynamic-drawer">
            Show right drawer
        </button>
    </div>

    <!-- dynamic drawer component -->
    <div ref="editdrawerRef"
        id="edit-dynamic-drawer" 
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" 
        tabindex="-1" 
        aria-labelledby="drawer-label">
        
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 uppercase dark:text-gray-400"><svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
        </svg>Edit event</h5>
        <button type="button" data-drawer-hide="edit-dynamic-drawer" aria-controls="edit-dynamic-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <form @submit.prevent="editEvent" class="mb-6">
        <!-- Title Field -->
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" v-model="newEvent.title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Event Title" required>
        </div>

        <!-- Period From Field -->
        <div class="mb-6">
            <label for="period_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period From</label>
            <input type="date" v-model="newEvent.period_from" id="period_from" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <!-- Period To Field -->
        <div class="mb-6">
            <label for="period_to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period To</label>
            <input type="date" v-model="newEvent.period_to" id="period_to" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <!-- Number of Hours Field -->
        <div class="mb-6">
            <label for="number_of_hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Hours</label>
            <input type="number" v-model="newEvent.number_of_hours" id="number_of_hours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <!-- Conducted By Field -->
        <div class="mb-6">
            <label for="conducted_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conducted By</label>
            <input type="text" v-model="newEvent.conducted_by" id="conducted_by" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Conductor's Name" required>
        </div>

        <div class="mb-4">
          
          <div v-if="newEvent.employee_ids && newEvent.employee_ids.length > 0">
          <div class="flex mb-4 -space-x-4 rtl:space-x-reverse">
          <img v-for="(photo, index) in newEvent.photo" :key="index" :src="getPhotoUrl(photo)" class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800" alt="Employee photo not found">
        </div>
        </div>

        <div v-else>
              <!-- Show text if no employees are assigned -->
              <p>Training not assigned to any employee.</p>
            </div>

          <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Choose Employee
      </button>
        </div>
        


        <!-- Submit Button -->
        <div class="flex justify-start space-x-2">
        <button type="submit" class="text-white justify-center flex items-center bg-green-700 hover:bg-green-600 w-40 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-gray-300">
            <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z"/>
                <path d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z"/>
            </svg> Update
        </button>
        <button type="submit" class="text-white justify-center flex items-center bg-red-700 hover:bg-red-600 w-40 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-gray-300">
            <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z"/>
                <path d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z"/>
            </svg> Delete
        </button>
      </div>
    </form>
        
    </div>

    <!--Edit Modal End-->

     <!--Read Modal Start-->

     <!-- Main modal -->
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Choose Employee
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
  <!-- Dynamic Employee Data -->
  <div v-for="employee in employeeInfo" :key="employee.EmployeeID" class="mx-auto flex items-center bg-gray-800 border border-gray-800 shadow-lg rounded-2xl p-4">
    <!-- Avatar -->
    <div class="shrink-0">
      <template v-if="employee.photo">
        <img :src="getPhotoUrl(employee.photo)" class="h-16 w-16 object-cover rounded-full" :alt="employee.first_name + ' ' + employee.surname + ' Avatar'">
      </template>
      <template v-else>
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M16 9a4 4 0 1 1-8 0a4 4 0 0 1 8 0Zm-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0Z"/><path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1ZM3 12c0 2.09.713 4.014 1.908 5.542A8.986 8.986 0 0 1 12.065 14a8.984 8.984 0 0 1 7.092 3.458A9 9 0 1 0 3 12Zm9 9a8.963 8.963 0 0 1-5.672-2.012A6.992 6.992 0 0 1 12.065 16a6.991 6.991 0 0 1 5.689 2.92A8.964 8.964 0 0 1 12 21Z"/></g></svg>
      </template>
    </div>
    <!-- Name and details -->
    <div class="flex-grow ml-4">
      <div class="text-lg text-white font-bold">{{ employee.first_name + ' ' + employee.surname }}</div>
      <div class="text-sm text-gray-400">
        <p>ID: {{ employee.EmployeeID }}</p>
        <p>Date of Entry: {{ employee.DateOfEntry }}</p>
        <p>IPCR: {{ employee.IPCR }}</p>
      </div>
    </div>
    <!-- Checkbox -->
    <div class="ml-4 flex items-center">
      <input ref="employeeCheckboxes" @change="updateEmployeeList(employee.EmployeeID)" type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" :value="employee.EmployeeID">
    </div>
  </div>
  <!-- Footer -->
  <div class="items-center px-4 py-3">
    <button id="ok-btn" class="px-4 py-2 bg-gray-800 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
      Update Event
    </button>
  </div>
</div>

            <!-- Modal footer -->
        </div>
    </div>
</div>

<!--Read Modal End-->

<!--Bawal-->
<div class='flex flex-wrap min-h-full font-sans text-sm'>
  <!-- Left sidebar for mini calendar and TabGroup -->
  <div class="w-full lg:w-1/4 px-2 mb-4"> <!-- Sidebar takes 1/4 of the width on large screens -->
    <!-- Mini calendar (VDatePicker) -->
    <div class="mb-4">
      <VDatePicker is-dark="system" class="px-4 my-datepicker" v-model="date" />
    </div>

    <!-- TabGroup Component -->
     <!-- TabGroup Component -->
     <div class="max-w-xs px-2 py-0 sm:px-0">
  <TabGroup>
    <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
      <Tab
        v-for="category in Object.keys(trainingCategories)"
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
        v-for="(sessions, category) in trainingCategories"
        :key="category"
        :class="{
          'rounded-xl bg-[#f5f5f7] dark:bg-[#0F172A] p-2 border-2 border-gray-200 dark:border-gray-700': !isLoading,
          'rounded-xl bg-[#f5f5f7] dark:bg-[#0F172A] p-4': isLoading
        }"
      >
        <div v-if="isLoading" class="flex justify-center items-center">
          <div class=" text-white dark:text-white font-medium text-sm px-4 py-2 rounded-md shadow-md">
            Loading...
          </div>
        </div>
        <ul v-else class="max-h-40 overflow-y-auto">
          <li
            v-for="session in sessions"
            :key="session.id"
            class="rounded-md p-2 hover:bg-gray-300 dark:hover:bg-green-500"
          >
            <h3 class="text-sm font-medium leading-5">
              {{ session.title }}
            </h3>
            <ul class="mt-1 flex space-x-1 text-xs font-normal leading-4 text-gray-700 dark:text-gray-300">
              <li>{{ session.date }}</li>
            </ul>
            <!-- Conditionally render Action button based on category -->
            <div class="flex justify-end space-x-2 mt-2">
              <button
                v-if="category === 'Unassigned'"
                type="button"
                @click="assignTraining(session.id)"
                class="text-white bg-green-600 hover:bg-green-800 rounded-lg text-xs px-4 py-1"
              >
                Assign
              </button>
              <button
                v-else
                type="button"
                @click="viewTrainingDetails(session.id)"
                class="text-white bg-green-600 hover:bg-green-800 rounded-lg text-xs px-4 py-1"
              >
                View Details
              </button>
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
    <div class='flex-grow p-12 text-md text-black dark:text-green-400 bg-white dark:bg-dark-bg px-3 py-3 rounded-xl'>
      <FullCalendar ref="calendarRef" :options="calendarOptions"></FullCalendar>
    </div>
  </div>
</div>
</template>




