<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import ApexCharts from 'apexcharts'
import BaseCard from '@/components/ui/BaseCard.vue'
import { isDark } from '@/composables';
import { Icon } from '@iconify/vue'
import { useStore } from 'vuex';

const store = useStore();
const earningChartEl = ref(null)
const calendar = ref(null);

// Vuex state
const activeEmployees = computed(() => store.state.activeEmployees);
const todayTrainingCount = computed(() => store.state.todayTrainingCount);
const upcomingEmployeeBirthdays = computed(() => store.state.upcomingEmployeeBirthdays);
const upcomingTraining = computed(() => store.state.upcomingTraining);
const upcomingEmployeeOnLeave = computed(() => store.state.upcomingEmployeeOnLeave);

const attributes = ref([]);
const apiUrl = 'hrDashboard';
const selectedColor = ref('blue');
const date = new Date();
const year = date.getFullYear();
const month = date.getMonth();

const employeeStatusChartEl = ref(null);

function moveToday() {
  calendar.value.move(new Date());
}

function generateAttributes() {
    const birthdayAttributes = store.state.upcomingEmployeeBirthdays.map(event => ({
    key: `birthday-${event.EmployeeID}`,
    highlight: {
      color: 'blue',
      fillMode: 'light',
    },
    dates: new Date(event.date_of_birth),
    popover: { visibility: 'hover', content: () => ` ${event.first_name} ${event.surname}` },
  }));


const trainingAttributes = store.state.upcomingTraining.map(event => ({
    key: `training-${event.training_id}`,
    highlight: {
      color: 'green',
      fillMode: 'solid',
    },
    dates: { start: new Date(event.period_from), end: new Date(event.period_to) },
    popover: { content: () => ` ${event.title}` },
  }));

  const leaveAttributes = store.state.upcomingEmployeeOnLeave.map(event => ({
    key: `leave-${event.id}`,
    highlight: {
      color: 'red',
      fillMode: 'outline',
    },
    dates: { start: new Date(event.start_date), end: new Date(event.end_date) },
    popover: { content: () => `${event.LeaveTypeName}` },
  }));

  attributes.value = [...birthdayAttributes, ...trainingAttributes, ...leaveAttributes];
}

watch([upcomingEmployeeBirthdays, upcomingTraining, upcomingEmployeeOnLeave], generateAttributes, { immediate: true });


onMounted(async () => {
await store.dispatch('fetchChartCountData', apiUrl);
await store.dispatch('fetchEmployeeStatusPercentages');

const { activePercentage, onTrainingPercentage, onLeavePercentage } = store.state.employeeStatusPercentages;

let employeeStatusChart = new ApexCharts(employeeStatusChartEl.value, {
series: [activePercentage, onTrainingPercentage, onLeavePercentage],
chart: {
    type: 'pie',
    toolbar: { show: false },
},
labels: ['Active', 'On Training', 'On Leave'],
colors: ['#f8963e', '#10e2b8', '#3498db'],
dataLabels: { enabled: false },
legend: { show: false },
stroke: { width: 0 },
plotOptions: {
    pie: {
    donut: {
        labels: {
        show: true,
        total: {
            show: true,
            label: 'Total',
            formatter: () => '100%'
        }
        }
    }
    }
}
});

employeeStatusChart.render();
});
</script>

<template>
    <section class="grid grid-cols-1">
        <h2 class="sr-only">Employee Status Distribution</h2>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Today's user -->
                    <BaseCard no-header bg-classes="dark:bg-[#393E46] bg-[#EFEFF4]">
                        <div class="pt-12 p-4 flex flex-col items-center justify-center gap-2">
                            <!-- Row for Icon and +1% -->
                            <div class="flex items-center space-x-2">
                                <Icon
                                    icon="clarity:employee-group-line"
                                    aria-hidden="true"
                                    class="w-10 h-10 text-[#10e2b8]"
                                />
                                <p class="text-base font-medium text-green-800 dark:text-green-300">
                                    +1%
                                </p>
                            </div>

                            <!-- Centered active employees number -->
                            <p class="text-6xl font-extrabold text-gray-800 dark:text-gray-200">
                                {{ activeEmployees }}
                            </p>

                            <!-- Subtitle -->
                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                Today's Active Employees
                            </p>
                        </div>
                    </BaseCard>

                    <!-- Today's sales -->
                    <BaseCard no-header bg-classes="dark:bg-[#393E46] bg-[#EFEFF4]">
                    <div class="pt-12 p-4 flex flex-col items-center justify-center gap-2">
                        <!-- Icon and Percentage -->
                        <div class="flex items-center space-x-2">
                            <Icon
                                icon="mdi:chart-bar"
                                aria-hidden="true"
                                class="w-10 h-10 text-[#10e2b8]"
                            />
                            <p class="text-base font-medium text-green-800 dark:text-green-300">
                                +4%
                            </p>
                        </div>

                        <!-- Today's Training Count - Large and Centered -->
                        <p class="text-6xl font-extrabold text-gray-800 dark:text-gray-200">
                            {{ todayTrainingCount }}
                        </p>

                        <!-- Description Text -->
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            Today's Number of Trainings
                        </p>
                    </div>
                </BaseCard>
                </div>

                <!-- Employee Status Distribution Card -->
            <BaseCard noHeader class="grid grid-cols-2 items-center"> <!-- Added items-center for vertical alignment -->
                <div class="flex flex-col gap-2"> <!-- Reduced gap and switched to flex for a tighter layout -->
                    <h4 class="text-2xl font-medium text-green-800 dark:text-green-300">Employee Status Distribution</h4>
                    <p class="text-lg font-medium text-gray-800 dark:text-gray-200">
                        This Month
                    </p>
                    <p class="text-base font-medium text-green-400">
                        +20.5%
                    </p>
                    <p class="text-2xl font-medium text-gray-800 dark:text-gray-200">
                        $5070.80
                    </p>
                </div>

                <!-- Donut chart for Employee Status -->
                <div class="flex w-full h-full items-center justify-center"> 
                    <div ref="employeeStatusChartEl"></div>
                </div>
            </BaseCard>
            </div>

            <!-- Bar chart -->
            <BaseCard
                title="Calendar of Events"
            >
                <div class="p-6">
                    <VCalendar 
                        ref="calendar" 
                        :attributes="attributes" 
                        expanded 
                        :rows="2" 
                        :is-dark="isDark" 
                        transparent 
                        borderless
                    >
                        <!-- day-popover slot to show event details -->
                        <template #day-popover="{ day, dayTitle, attributes }">
                        <div class="bg-white shadow-lg rounded-lg p-4">
                            <div class="font-bold mb-2">{{ dayTitle }}</div>
                            <div v-for="attr in attributes" :key="attr.key" class="mb-1">
                            <!-- Custom content based on the type of event -->
                            <div v-if="attr.key.startsWith('birthday-')">
                                <span class="text-blue-500 font-semibold">Birthday:</span> {{ attr.popover.content() }}
                            </div>
                            <div v-else-if="attr.key.startsWith('training-')">
                                <span class="text-green-500 font-semibold">Training:</span> {{ attr.popover.content() }}
                            </div>
                            <div v-else-if="attr.key.startsWith('leave-')">
                                <span class="text-red-500 font-semibold">Leave:</span> {{ attr.popover.content() }}
                            </div>
                            </div>
                        </div>
                        </template>

                        <!-- Existing footer slot -->
                        <template #footer>
                        <div class="w-full px-4 pb-3">
                            <button
                            class="bg-green-600 hover:bg-green-700 text-white font-bold w-full px-3 py-1 rounded-md"
                            @click="moveToday"
                            >
                            Today
                            </button>
                        </div>
                        </template>
                    </VCalendar>
                </div> 
            </BaseCard>
        </div>
    </section>
</template>
