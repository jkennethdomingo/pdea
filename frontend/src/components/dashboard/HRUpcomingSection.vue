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
    shareCountColor: train.participants ? '' : 'text-red-500'
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

<template>
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
                                ? 'bg-green-600 dark:bg-green-600 text-white dark:text-white shadow'
                                : 'text-gray-600 dark:text-gray-200 hover:bg-white/[0.12] hover:text-green-500',
                        ]"
                        >
                            {{ category }}
                        </button>
                        </Tab>
                    </TabList>
    
                    <TabPanels class="mt-2">
                        <TabPanel v-for="(posts, idx) in Object.values(categories)" :key="idx" class="rounded-xl bg-white dark:bg-[#0F172A] p-2 border-2 border-gray-200 dark:border-gray-700">
                            <ul>
                            <li v-for="post in posts" :key="post.id" class="rounded-md p-2 hover:bg-gray-300 dark:hover:bg-green-500">
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

        <!-- Recent cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            <!-- Recent contacts -->
            <BaseCard
                title="Recently Approved Leaves"
                :actions="[{ title: 'View', to: '#' }]"
            >
                <div
                    class="mt-4 flex items-center justify-between"
                    v-for="i in 4"
                    :key="i"
                >
                    <div class="flex items-center gap-2">
                        <img
                            class="w-10 h-10 rounded-md object-cover"
                            src="https://placekitten.com/200/300"
                        />
                        <div>
                            <h5
                                class="text-xs text-gray-600 dark:text-gray-300"
                            >
                                Name
                            </h5>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                email@example.com
                            </p>
                        </div>
                    </div>
                    <Button
                        sr-text="Actions"
                        size="sm"
                        icon-only
                        icon="mdi:dots-vertical"
                        variant="secondary"
                    />
                </div>
            </BaseCard>

            <!-- Recent transactions -->
            <BaseCard
                title="Unassigned Trainings"
                :actions="[{ title: 'View', to: '#' }]"
            >
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon
                            icon="mdi:plus-circle-outline"
                            aria-hidden="true"
                            class="w-6 h-6 text-green-500"
                        />
                        <div>
                            <h5
                                class="text-xs text-gray-600 dark:text-gray-300"
                            >
                                Gillette
                            </h5>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                17 Oct, 2021
                            </p>
                        </div>
                    </div>

                    <span class="text-base font-medium text-green-500"
                        >+$360.00</span
                    >
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon
                            icon="mdi:minus-circle-outline"
                            aria-hidden="true"
                            class="w-6 h-6 text-red-500"
                        />
                        <div>
                            <h5
                                class="text-xs text-gray-600 dark:text-gray-300"
                            >
                                IBM
                            </h5>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                01 Oct, 2021
                            </p>
                        </div>
                    </div>

                    <span class="text-base font-medium text-red-500"
                        >-$254.00</span
                    >
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon
                            icon="mdi:checkbox-blank-circle-outline"
                            aria-hidden="true"
                            class="w-6 h-6 text-gray-500"
                        />

                        <div>
                            <h5
                                class="text-xs text-gray-600 dark:text-gray-300"
                            >
                                Louis Vuitton
                            </h5>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                8 Oct, 2021
                            </p>
                        </div>
                    </div>

                    <span class="text-base font-medium text-gray-500"
                        >Pending</span
                    >
                </div>
            </BaseCard>
        </div>
    </section>
</template>
