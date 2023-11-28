<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import BaseCard from '@/components/ui/BaseCard.vue'
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import apiService from '@/composables/axios-setup';

const calendarRef = ref(null);
const employeesOnLeave = ref([]); 
const employeesBirthdays = ref({});
const employeesTraining = ref({});

async function fetchCombinedEvents()  {
  try {
    const response = await apiService.post('/hrDashboard/getCombinedEvents');
    employeesOnLeave.value = response.data.EmployeeOnLeave;
    employeesBirthdays.value = response.data.employeeBirthdays;
    employeesTraining.value = response.data.training;
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


const birthdayEvents = computed(() => {
  return employeesBirthdays.value.map(birthday => ({
    id: birthday.EmployeeID,
    title: `${birthday.surname}, ${birthday.first_name}'s' Birthday`,
    start: birthday.date_of_birth,
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

onMounted(async () => {
  await fetchCombinedEvents();
});

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
    right: 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  initialView: 'dayGridMonth',
  initialEvents: leaveEvents.value, // Use training events here
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
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <h2 class="sr-only">Upcoming Events</h2>

        <!-- Latest users -->
        <BaseCard title="Latest Users" :actions="[{ title: 'View', to: '#' }]">
            <!-- Table -->
        </BaseCard>

        <!-- Recent cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            <BaseCard
            >
            <FullCalendar
                class='demo-app-calendar'
                :options='calendarOptions'
            >
            </FullCalendar>

            </BaseCard>
        </div>
    </section>
</template>

<style lang='css'>

h2 {
  margin: 0;
  font-size: 16px;
}

ul {
  margin: 0;
  padding: 0 0 0 1.5em;
}

li {
  margin: 1.5em 0;
  padding: 0;
}

b { /* used for event dates/times */
  margin-right: 3px;
}

.demo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.demo-app-sidebar {
  width: 300px;
  line-height: 1.5;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}

.demo-app-sidebar-section {
  padding: 2em;
}

.demo-app-main {
  flex-grow: 1;
  padding: 3em;
}

.fc { /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}

</style>
