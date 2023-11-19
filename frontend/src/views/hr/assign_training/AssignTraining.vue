<script setup>
import { ref, computed, onMounted } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import { INITIAL_EVENTS } from '@/composables/event-utils';
import { initFlowbite } from 'flowbite';


onMounted(() => {
  initFlowbite();
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
  eventsSet: handleEvents
});


function handleWeekendsToggle() {
}

function handleDateSelect(selectInfo) {
  
}

function handleEventClick(clickInfo) {

}

function handleEvents(events) {
}
</script>

<template>
    <div class='flex min-h-full font-sans text-sm'>
        <div class="text-center section">

            <VDatePicker v-model="date" />

    </div>
    <div class='flex-grow p-12'>
        <FullCalendar
            class='demo-app-calendar'
            :options='calendarOptions'  data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example"
        >
            <template v-slot:eventContent='arg'>
            </template>
        </FullCalendar>
        </div>
    </div>
</template>


