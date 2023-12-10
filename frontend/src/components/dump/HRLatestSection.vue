<script setup>
import { onMounted, computed } from 'vue';
import BaseCard from '@/components/ui/BaseCard.vue'
import Button from '@/components/base/Button.vue'
import Calendar from '@/components/dump/HRCalendarOfEvents.vue'
import { Icon } from '@iconify/vue'
import { useStore } from 'vuex';

const store = useStore();

const allEvents = computed(() => {
  return {
    birthdays: store.state.upcomingEmployeeBirthdays,
    trainings: store.state.upcomingTraining,
    leaves: store.state.upcomingEmployeeOnLeave
  };
});


onMounted(async () => {
await store.dispatch('fetchUpcomingCombinedEvents');
});

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>

<template>
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <h2 class="sr-only">Upcoming Events</h2>

        <!-- Latest users -->
        <BaseCard title="Upcoming Events">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">All</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Birthdays</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Trainings</button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Leaves</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content">
        <!-- All Tab -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Event Type</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="birthday in allEvents.birthdays" :key="birthday.EmployeeID" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">Birthday</td>
                            <td class="px-6 py-4">{{ birthday.surname }}, {{ birthday.first_name }}</td>
                            <td class="px-6 py-4">{{ formatDate(birthday.date_of_birth) }}</td>
                        </tr>
                        <tr v-for="training in allEvents.trainings" :key="training.training_id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">Training</td>
                            <td class="px-6 py-4">{{ training.title }}</td>
                            <td class="px-6 py-4">Participants: {{ training.participants }}</td>
                        </tr>
                        <tr v-for="leave in allEvents.leaves" :key="leave.id" class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4">Leave</td>
                            <td class="px-6 py-4">{{ leave.surname }}, {{ leave.first_name }}</td>
                            <td class="px-6 py-4">{{ leave.LeaveTypeName }} ({{ formatDate(leave.start_date) }} to {{ formatDate(leave.end_date) }})</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Birthdays Tab -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Surname</th>
                            <th scope="col" class="px-6 py-3">First Name</th>
                            <th scope="col" class="px-6 py-3">Date of Birth</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="birthday in allEvents.birthdays" :key="birthday.EmployeeID" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4"> {{ birthday.surname }}</td>
                            <td class="px-6 py-4"> {{ birthday.first_name }}</td>
                            <td class="px-6 py-4">{{ formatDate(birthday.date_of_birth) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Trainings Tab -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Participants</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="training in allEvents.trainings" :key="training.training_id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ training.title }}</td>
                            <td class="px-6 py-4">{{ training.participants }}</td>
                            <td class="px-6 py-4">{{ formatDate(training.period_from) }} - {{ formatDate(training.period_to) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Leaves Tab -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Surname</th>
                            <th scope="col" class="px-6 py-3">First Name</th>
                            <th scope="col" class="px-6 py-3">Leave Type</th>
                            <th scope="col" class="px-6 py-3">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="leave in allEvents.leaves" :key="leave.id" class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4">Leave</td>
                            <td class="px-6 py-4">{{ leave.surname }}, {{ leave.first_name }}</td>
                            <td class="px-6 py-4">{{ leave.LeaveTypeName }}</td>
                            <td class="px-6 py-4">({{ formatDate(leave.start_date) }} to {{ formatDate(leave.end_date) }})</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</BaseCard>



        <!-- Recent cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            <!-- Recent contacts -->
            <BaseCard
            >
                <Calendar/>
            </BaseCard>
            
        </div>
    </section>
</template>
