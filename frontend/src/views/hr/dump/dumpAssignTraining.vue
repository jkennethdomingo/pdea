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
import { isDark } from '@/composables';


const selectedEmployeeIds = ref([]);

const selectEmployee = (employeeId) => {
  const index = selectedEmployeeIds.value.indexOf(employeeId);
  if (index > -1) {
    selectedEmployeeIds.value.splice(index, 1);
  } else {
    selectedEmployeeIds.value.push(employeeId);
  }
};

const isSelected = (employeeId) => {
  return selectedEmployeeIds.value.includes(employeeId);
};

const selectAll = () => {
  selectedEmployeeIds.value = employeeInfo.value.map(employee => employee.EmployeeID);
};

const clearAll = () => {
  selectedEmployeeIds.value = [];
};

const allSelected = computed({
  get: () => employeeInfo.value && selectedEmployeeIds.value.length === employeeInfo.value.length,
  set: (value) => {
    if (value) {
      selectAll();
    } else {
      clearAll();
    }
  }
});



const isLoading = ref(true); 
const store = useStore();
const calendarRef = ref(null);
const calendar = ref(null);
const date = ref(new Date()); // Assuming this is your VDatePicker model
const drawerRef = ref(null);
const editdrawerRef = ref(null);

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



function moveToday() {
  const calendarApi = calendarRef.value.getApi();
  calendar.value.move(new Date());
    calendarApi.gotoDate(new Date());
}

const trainingsMap = computed(() => ({
  Upcoming: store.state.trainingsWithoutEmployees.map(training => ({
    id: training.training_id,
    title: `Training: ${training.title}`,
    date: training.period_from // Format this date as needed
  }))
}))

const isDrawerOpen = ref(false);
const isEditDrawerOpen = ref(false);

// ... your existing setup ...

function openDrawer() {
  isDrawerOpen.value = true;
}

function closeDrawer() {
  isDrawerOpen.value = false;
}

function openRightDrawer() {
  isDrawerOpen.value = true; // Opens the DaisyUI drawer
}

// Open the edit event drawer
function openEditRightDrawer() {
  isEditDrawerOpen.value = true; // Open the edit drawer
}

// Close the edit event drawer
function closeEditRightDrawer() {
  isEditDrawerOpen.value = false; // Close the edit drawer
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
    <div ref="drawerRef" class="drawer drawer-end" :class="{'z-50': isDrawerOpen}">
  <input id="dynamic-drawer" type="checkbox" class="drawer-toggle" v-model="isDrawerOpen" />
  <div class="drawer-content">
    <!-- Main page content here -->
  </div> 
  <div class="drawer-side">
    <label for="dynamic-drawer" class="drawer-overlay"></label>
    <!-- Remove the 'overflow-y-hidden' class if you want the content to scroll when it overflows -->
    <ul class="p-4 w-80 dark:bg-base-100 bg-gray-200 text-base-content h-screen">
      <!-- Your dynamic drawer content -->
      <h5 id="drawer-label" class="inline-flex items-center mb-6 text-base font-semibold text-gray-600 uppercase dark:text-gray-100"><svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
        </svg>Assign Training</h5>
        <button
          type="button"
          @click="closeDrawer"
          aria-controls="dynamic-drawer"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
        >
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
          </svg>
          <span class="sr-only">Close menu</span>
        </button>
      <li>
        <form class="mb-6" @submit.prevent="addEvent">
          <div class="mb-6 px-4">
          <!-- Title Field -->
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" v-model="newEvent.title" id="title" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" placeholder="Event Title" required>
        </div>

        <!-- Period From Field -->
        <div class="mb-6">
            <label for="period_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period From</label>
            <input type="date" v-model="newEvent.period_from" id="period_from" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>

        <!-- Period To Field -->
        <div class="mb-6">
            <label for="period_to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period To</label>
            <input type="date" v-model="newEvent.period_to" id="period_to" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>

        <!-- Number of Hours Field -->
        <div class="mb-6">
            <label for="number_of_hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Hours</label>
            <input type="number" v-model="newEvent.number_of_hours" id="number_of_hours" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>

        <!-- Conducted By Field -->
        <div class="mb-6">
            <label for="conducted_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conducted By</label>
            <input type="text" v-model="newEvent.conducted_by" id="conducted_by" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>
      
        <div class="mb-4">
        </div>
          

        <div class="flex flex-col space-y-2">
  <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Choose Employee
  </button>

  <div class="flex space-x-2">
    <button type="submit" class="flex-1 text-white bg-green-700 hover:bg-green-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-gray-800">
      Save
    </button>
    <button type="button" class="flex-1 text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-gray-800">
      Delete
    </button>
  </div>
</div>
</div>

        </form>
      </li>
    </ul>
  </div>
</div>
        <!-- Dynamic content goes here -->
        


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

    <!-- Edit Drawer Component -->
    <div ref="editdrawerRef" class="drawer drawer-end" :class="{'z-50': isEditDrawerOpen}">
  <input id="edit-dynamic-drawer" type="checkbox" class="drawer-toggle" v-model="isEditDrawerOpen" />
  <div class="drawer-side">
    <label for="edit-dynamic-drawer" class="drawer-overlay"></label>
    <ul class="p-4 w-80 dark:bg-base-100 bg-gray-200 text-base-content h-screen">
      <h5 id="drawer-label" class="inline-flex items-center mb-6 text-base font-semibold text-gray-600 uppercase dark:text-gray-100">
        <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
        </svg>
        Edit Event
      </h5>
      <button
        type="button"
        @click="closeEditRightDrawer"
        aria-controls="edit-dynamic-drawer"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
      >
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
        <span class="sr-only">Close menu</span>
      </button>
      <li class="flex flex-col items-center">
        <form class="mb-6 w-full" @submit.prevent="editEvent">
          <div class="mb-6 px-4">
        <!-- Title Field -->
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" v-model="newEvent.title" id="title" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" placeholder="Event Title" required>
        </div>

        <!-- Period From Field -->
        <div class="mb-6">
            <label for="period_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period From</label>
            <input type="date" v-model="newEvent.period_from" id="period_from" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>

        <!-- Period To Field -->
        <div class="mb-6">
            <label for="period_to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Period To</label>
            <input type="date" v-model="newEvent.period_to" id="period_to" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>

        <!-- Number of Hours Field -->
        <div class="mb-6">
            <label for="number_of_hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Hours</label>
            <input type="number" v-model="newEvent.number_of_hours" id="number_of_hours" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" required>
        </div>

        <!-- Conducted By Field -->
        <div class="mb-6">
            <label for="conducted_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conducted By</label>
            <input type="text" v-model="newEvent.conducted_by" id="conducted_by" class="bg-gray-300 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-green-500 focus:green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-400 dark:text-gray-200 dark:focus:ring-green-500 dark:focus:border-green-600" placeholder="Conductor's Name" required>
        </div>

        <div class="mb-4">
        </div>

        <div class="flex flex-col space-y-2">
          <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Choose Employee
          </button>
          <div v-if="newEvent.employee_ids && newEvent.employee_ids.length > 0" class="mt-4 gap-2">
            <img v-for="(photo, index) in newEvent.photo" :key="index" :src="getPhotoUrl(photo)" class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800" alt="Employee photo not found">
          </div>
          

        <div v-else>
              <!-- Show text if no employees are assigned -->
              <p class="mt-4 text-center">Training not assigned to any employee.</p>
            </div>
                  <!-- Update and Delete Buttons -->
                  <div class="flex space-x-2">
            <button type="submit" class="flex-1 text-white bg-green-700 hover:bg-green-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-gray-800">
              Update
            </button>
            <button type="button" class="flex-1 text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-gray-800">
              Delete
            </button>
          </div>
        </div>
      </div>

            
        </form>
      </li>
    </ul>
  </div>
</div>

    <!--Edit Modal End-->

     <!--Read Modal Start-->

     <!-- Main modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class=" py-12 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 flex flex-col">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 md:p-5 border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Choose Employee
                    </h3>
                    <!-- Placeholder for alignment -->
                    <div class="w-8 h-8"></div>
                </div>
                <!-- Absolute positioned Close button -->
                <button type="button" class="absolute top-4 right-5 transform translate-x-1/2 -translate-y-1/2 text-red-500 bg-transparent hover:bg-red-400 hover:text-red-600 rounded-full text-sm p-1.5 dark:hover:bg-red-500 dark:hover:text-gray-800" data-modal-hide="static-modal">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                  <!-- Rest of your modal content -->

            <!-- Modal body -->
            <div class="relative p-4 md:p-5 space-y-4 max-h-[500px] overflow-y-auto bg-[#f5f5f7] dark:bg-[#0F172A] border border-gray-600 rounded-b-lg">
              <!-- Select All Checkbox -->
              <div class="absolute top-0 right-0 pt-2 pr-4">
                <label class="cursor-pointer flex items-center">
                  <span class="label-text text-sm text-gray-900 dark:text-gray-300">Select All</span>
                  <input type="checkbox" checked="checked" class="checkbox checkbox-success ml-2" v-model="allSelected" />
                </label>
              </div>

          <div class="grid grid-cols-3 gap-4">
          <div v-for="employee in employeeInfo" :key="employee.EmployeeID"
              @click="selectEmployee(employee.EmployeeID)"
              :class="{'ring-2 ring-green-400': isSelected(employee.EmployeeID), 'bg-gray-300 dark:bg-gray-800': !isSelected(employee.EmployeeID)}"
              class="flex flex-col border border-gray-400 shadow-lg rounded-2xl p-4 cursor-pointer">
              <!-- Avatar -->
              <div class="self-center mb-3 ">
                <template v-if="employee.photo">
                  <img :src="getPhotoUrl(employee.photo)" class="h-12 w-12 object-cover rounded-full" :alt="employee.first_name + ' ' + employee.surname + ' Avatar'">
                </template>
                <template v-else>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4Z"/></svg>
                </template>
              </div>
              <!-- Name and details -->
              <div class="flex-grow">
                <div class="underline text-lg text-green-700 dark:text-gray-200  font-semibold text-center">{{ employee.first_name + ' ' + employee.surname }}</div>
                <div class="text-md text-gray-800 dark:text-gray-200 mt-1">
                  <p><span class="dark:text-green-400 text-green-800">ID:</span> {{ employee.EmployeeID }}</p>
                  <p><span class="dark:text-green-400 text-green-800">IPCR:</span> {{ employee.IPCR }}</p>
                  <p><span class="dark:text-green-400 text-green-800">Date of Entry:</span> {{ employee.DateOfEntry }}</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Footer -->
          <div class="flex justify-center items-center px-4 py-3">
            <button class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-1/2 md:w-32 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
              Assign
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
      <VDatePicker class="px-4" ref="calendar" v-model="date" :is-dark="isDark">
        <template #footer>
          <div class="w-full px-4 pb-3">
            <button
              class="bg-green-600 hover:bg-green-700 text-gray-200 font-bold w-full px-3 py-1 rounded-md"
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
          <div class="text-white dark:text-white font-medium text-sm px-4 py-2 rounded-md shadow-md">
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
    <div class='flex-grow p-12 text-md text-black dark:text-green-400 bg-[#f5f5f7] dark:bg-[#0F172A] px-3 py-7 rounded-xl border-2 border-gray-200 dark:border-gray-700'>
      <FullCalendar ref="calendarRef" :options="calendarOptions"></FullCalendar>
    </div>
  </div>
</div>
</template>




