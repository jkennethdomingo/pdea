<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import { useStore } from 'vuex';

const store = useStore();
const calendarRef = ref(null);

const combinedEvents = computed(() => store.state.combinedEvents);


const employeeBirthdays = computed(() => {
  const currentYear = new Date().getFullYear();
  return combinedEvents.value.employeeBirthdays.map(birthday => {
    const birthdayDate = new Date(birthday.date_of_birth);
    birthdayDate.setFullYear(currentYear); // Set the year to the current year
    return {
      title: `${birthday.surname}, ${birthday.first_name} - Birthday`,
      start: birthdayDate.toISOString().split('T')[0], // Convert to YYYY-MM-DD format
      // More properties if needed
    };
  });
});


const trainingEvents = computed(() => {
  return combinedEvents.value.training.map(training => ({
    title: training.title,
    start: training.period_from,
    end: training.period_to,
    // More properties if needed
  }));
});

const employeeLeaveEvents = computed(() => {
  if (combinedEvents.value.EmployeeOnLeave) {
    return combinedEvents.value.EmployeeOnLeave.map(leave => ({
      title: `${leave.surname}, ${leave.first_name} - ${leave.LeaveTypeName}`,
      start: leave.start_date,
      end: leave.end_date,
      // More properties if needed
    }));
  }
  return []; // Return an empty array if employeeOnLeave is not defined
});


const allEvents = computed(() => {
  return [...employeeBirthdays.value, ...trainingEvents.value, ...employeeLeaveEvents.value];
});

watch(allEvents, (newEvents) => {
  if (calendarRef.value) {
    const calendarApi = calendarRef.value.getApi();
    calendarApi.removeAllEvents();
    calendarApi.addEventSource(newEvents);
  }
}, { deep: true });



// Fetch training data on component mount
onMounted(async () => {
await store.dispatch('fetchCombinedEvents');
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
    left: 'prev,next,today',
    center: 'title',
    right: 'dayGridMonth,listWeek'
  },
  initialView: 'dayGridMonth',
  initialEvents: allEvents.value, // Use training events here
  editable: true,
  selectable: true,
  selectMirror: true,
  dayMaxEvents: true,
  weekends: true,
  select: handleDateSelect,
  eventClick: handleEventClick,
  eventsSet: handleEvents
});



function openAddEventDialog() {
  // Logic to open the dialog to add a new event
}

function handleDateSelect(selectInfo) {
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
      <FullCalendar ref="calendarRef" :options="calendarOptions"></FullCalendar>
</template>





