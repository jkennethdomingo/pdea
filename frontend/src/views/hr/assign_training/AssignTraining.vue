<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import { initFlowbite } from 'flowbite';
import { useStore } from 'vuex';
import AddTrainingModal from '@/components/modals/AddTrainingModal.vue';

const store = useStore();
const calendarRef = ref(null);
const date = ref(new Date()); // Assuming this is your VDatePicker model

// Computed property for transforming training data
const trainingEvents = computed(() => {
  return store.state.training.map(event => ({
    title: event.title,
    start: event.period_from,
    end: event.period_to
    // Add more fields if needed
  }));
});

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
    left: 'addEventButton,today',
    center: 'prev,title,next',
    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
  },
  customButtons: {
    addEventButton: {
      text: 'Add event',
      click: () => openAddEventDialog()
    },
  },
  initialView: 'dayGridMonth',
  initialEvents: trainingEvents.value, // Use training events here
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
  // Handle date selection
}

function handleEventClick(clickInfo) {
  // Handle event click
}

function handleEvents(events) {
  // Handle events set
}

function handleWeekendsToggle() {
  // Handle weekends toggle
}

function onModalClose() {
  // Logic to execute when the modal is closed
  console.log('Modal closed');
}
</script>


<template>
<AddTrainingModal @close="onModalClose"/>
    <div class='flex min-h-full font-sans text-sm'>
        <div class="text-center section">
          <div class="hidden lg:flex">
            <VDatePicker v-model="date" />

      </div>
    </div>
    <div class='flex-grow p-12'>
      <FullCalendar ref="calendarRef" :options="calendarOptions"></FullCalendar>

        </div>
    </div>
</template>





