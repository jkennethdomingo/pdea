<script setup>
import { ref, onMounted, computed } from 'vue'
import BaseCard from '@/components/ui/BaseCard.vue'
import Button from '@/components/base/Button.vue'
import { Icon } from '@iconify/vue'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { useStore } from 'vuex';

const store = useStore();

onMounted(async () => {
await store.dispatch('fetchUpcomingCombinedEvents');
});

const upcomingEmployeeBirthdays = computed(() => store.state.upcomingEmployeeBirthdays);
const upcomingTraining = computed(() => store.state.upcomingTraining);
const upcomingEmployeeOnLeave = computed(() => store.state.upcomingEmployeeOnLeave);

// Helper function to format date difference
function calculateTimeToBirthday(dob) {
    const today = new Date();
    const birthDate = new Date(dob);
    const nextBirthday = new Date(birthDate.setFullYear(today.getFullYear()));

    // Adjust for next year if birthday already passed
    if (today > nextBirthday) {
        nextBirthday.setFullYear(today.getFullYear() + 1);
    }

    const diffTime = Math.abs(nextBirthday - today);
    const diffSeconds = Math.floor(diffTime / 1000);
    const diffMinutes = Math.floor(diffSeconds / 60);
    const diffHours = Math.floor(diffMinutes / 60);
    const diffDays = Math.floor(diffHours / 24);
    const diffWeeks = Math.floor(diffDays / 7);
    const diffMonths = Math.floor(diffDays / 30);

    let timeString = "";

    if (diffMonths > 0) timeString = diffMonths > 1 ? `${diffMonths} months` : "a month";
    else if (diffWeeks > 0) timeString = diffWeeks > 1 ? `${diffWeeks} weeks` : "a week";
    else if (diffDays > 0) timeString = diffDays > 1 ? `${diffDays} days` : "a day";
    else if (diffHours > 0) timeString = diffHours > 1 ? `${diffHours} hours` : "an hour";
    else if (diffMinutes > 0) timeString = diffMinutes > 1 ? `${diffMinutes} minutes` : "a minute";
    else timeString = diffSeconds > 1 ? `${diffSeconds} seconds` : "a second";

    return `In ${timeString}`;
}
// Transform data into the required formats
const birthdays = upcomingEmployeeBirthdays.value.map(employee => ({
    id: employee.EmployeeID,
    title: `${employee.first_name} ${employee.surname}'s Birthday`,
    date: calculateTimeToBirthday(employee.date_of_birth),
}));

const training = upcomingTraining.value.map(train => ({
    id: train.training_id,
    title: train.title,
    date: `${train.period_from} to ${train.period_to}`,
    commentCount: 'Conducted by ' + train.conducted_by,
    shareCount: train.participants ? 'Assigned' : 'Unassigned',
    shareCountColor: train.participants ? 'text-green-600 dark:text-green-400' : 'text-red-500'
}));

const leaves = upcomingEmployeeOnLeave.value.map(leave => ({
    id: leave.id,
    title: `${leave.first_name} ${leave.surname} - ${leave.LeaveTypeName}`,
    date: `${leave.start_date} to ${leave.end_date}`,
    commentCount: leave.reason,
    shareCount: leave.status,
}));

// Combine categories
const allEvents = [...birthdays, ...training, ...leaves];

// Define categories
const categories = ref({
    All: allEvents,
    Birthdays: birthdays,
    Training: training,
    'On Leave': leaves,
});
</script>

<template> <!--TODO Bug Upcoming Events-->
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <h2 class="sr-only">Upcoming Events</h2> 

        <!-- Upcoming Events -->
        <BaseCard title="Upcoming Events">
            <div class="py-6">
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
                                ? 'bg-[#10e2b8] text-white dark:text-gray-800 shadow'
                                : 'text-gray-600 dark:text-gray-200 hover:bg-white/[0.12] hover:text-green-500',
                        ]"
                        >
                            {{ category }}
                        </button>
                        </Tab>
                    </TabList>
    
                    <TabPanels class="mt-2">
                        <TabPanel v-for="(posts, idx) in Object.values(categories)" :key="idx" class="rounded-xl bg-white dark:bg-[#0F172A] p-2 border-2 border-gray-200 dark:border-gray-700 max-h-96 overflow-y-auto">
                            <ul>
                            <li v-for="post in posts" :key="post.id" class="rounded-md p-2 hover:bg-gray-300 dark:hover:bg-green-600">
                                <h3 class="text-sm font-medium leading-5">{{ post.title }}</h3>
                                <ul class="mt-1 flex space-x-1 text-xs font-normal leading-4 text:gray-700 dark:text-gray-300">
                                <li>{{ post.date }}</li>
                                <li v-if="post.commentCount">&middot;</li>
                                <li v-if="post.commentCount">{{ post.commentCount }}</li>
                                <li v-if="post.shareCount">&middot;</li>
                                <li v-if="post.shareCount" :class="post.shareCountColor">{{ post.shareCount }}</li>
                                </ul>
                            </li>
                            </ul>
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </BaseCard>

        <!-- Recent cards --> <!-- TODO Static Recently Approved-->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            <!-- Recent contacts -->
            <BaseCard title="Recently Approved Leaves" :actions="[{ title: 'View', to: '#' }]">
                <!-- Scrollable container -->
                <div class="max-h-64 overflow-y-auto"> <!-- Adjust max-h-64 as needed -->
                    <div
                        class="mt-4 flex items-center justify-between"
                        v-for="i in 10"
                        :key="i"
                    >
                        <div class="flex items-center gap-2">
                            <img
                                class="w-10 h-10 rounded-md object-cover"
                                src="@/assets/images/avatar.jpg" alt="Avatar"
                            />
                            <div>
                                <h5 class="text-xs text-gray-600 dark:text-gray-300">
                                    Jose Anyayahan
                                </h5>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    ID: 111002
                                </p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                Sick Leave &middot; 12-14-23 - 12-20-23
                            </p>
                        </div>
                        <Button
                            sr-text="Actions"
                            size="sm"
                            icon-only
                            icon="mdi:dots-vertical"
                            variant="secondary"
                        />
                    </div>
                </div>
            </BaseCard>


            <!-- Recent transactions -->  <!--TODO Unassigned Training-->
            <BaseCard title="Unassigned Trainings" :actions="[{ title: 'View', to: '#' }]">
                <div class="max-h-32 overflow-y-auto">
                    <div
                        class="mt-4 flex items-center justify-between"
                        v-for="i in 5"
                        :key="i"
                    >
                        <div class="flex items-center gap-4">
                            <!-- SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48" class="w-10 h-10 rounded-md">
                                <path fill="currentColor" fill-rule="evenodd" d="M6 6h31v5h-2V8H8v23h21.387v2H6zm30 13a3 3 0 1 0 0-6a3 3 0 0 0 0 6m2.031 2.01c1.299 0 2.327.584 3 1.486c.629.845.895 1.89.955 2.855a7.626 7.626 0 0 1-.397 2.92c-.3.87-.807 1.77-1.589 2.387V40.5a1.5 1.5 0 0 1-2.98.247L35.73 33h-.298l-1.458 7.776A1.5 1.5 0 0 1 31 40.5V26.233a63.223 63.223 0 0 0-.592.919l-.078.123l-.02.032l-.005.009a1.5 1.5 0 0 1-1.274.707h-5a1.5 1.5 0 1 1 0-3h4.177c.243-.376.563-.864.899-1.354c.35-.511.736-1.052 1.08-1.476c.167-.207.354-.423.542-.6c.092-.087.22-.2.376-.3a1.72 1.72 0 0 1 .926-.282z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h5 class="text-xs text-gray-600 dark:text-gray-300">
                                    Holding a Gun
                                </h5>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                Sick Leave &middot; 12-14-23 - 12-20-23
                            </p>
                        </div>
                        <Button
                            sr-text="Actions"
                            size="sm"
                            icon-only
                            icon="mdi:dots-vertical"
                            variant="secondary"
                        />
                    </div>
                </div>
            </BaseCard>

        </div>
    </section>
</template>
