<script setup>
import { onMounted, ref, computed } from 'vue'
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

const apiUrl = 'hrDashboard';

function moveToday() {
  calendar.value.move(new Date());
}
const selectedColor = ref('blue');
const date = new Date();
const year = date.getFullYear();
const month = date.getMonth();
const attributes = ref([
  // ... other attributes
  {
    key: 'rangeStart',
    dates: new Date(2019, 3, 15),
    customData: { class: 'start-date' } // Custom class for start date
  },
  {
    key: 'rangeEnd',
    dates: new Date(2019, 3, 19),
    customData: { class: 'end-date' } // Custom class for end date
  },
  {
    key: 'range',
    highlight: true,
    dates: { start: new Date(2019, 3, 15), end: new Date(2019, 3, 19) },
    highlight: {
      color: 'green',
      fillMode: 'solid',
      contentClass: 'italic',
    },
  },
  // ... other attributes
]);


onMounted(async () => {
  await store.dispatch('fetchChartCountData', apiUrl);
  let earningChart = new ApexCharts(earningChartEl.value, {
    series: [30, 70],
        chart: {
            type: 'donut',
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: { show: false },
        comparedResult: [2, 8],
        labels: ['Sales', ''],
        stroke: { width: 0 },
        colors: ['#f8963e', '#10e2b8'],
        grid: {
            padding: {
                right: -20,
                bottom: -8,
                left: -20,
            },
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            offsetY: 15,
                        },
                        value: {
                            offsetY: -20,
                            formatter(val) {
                                return `${parseInt(val)}%`
                            },
                        },
                        total: {
                            show: true,
                            label: 'Sales',
                            formatter() {
                                return '30%'
                            },
                        },
                    },
                },
            },
        },
    })
  earningChart.render();
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

                <!-- Earning card -->
                <BaseCard noHeader class="grid grid-cols-2">
                    <div class="grid grid-cols-1 gap-4">
                        <h4 class="text-2xl font-medium">Employee Status Distribution</h4>
                        <p class="text-lg font-medium text-gray-500">
                            This Month
                        </p>
                        <p class="text-base font-medium text-green-400">
                            +20.5%
                        </p>
                        <p class="text-2xl font-medium text-gray-600">
                            $5070.80
                        </p>
                    </div>

                    <!-- Donut chart -->
                    <div class="w-full h-fullflex items-center justify-center">
                        <div ref="earningChartEl"></div>
                    </div>
                </BaseCard>
            </div>

            <!-- Bar chart -->
            <BaseCard
                title="Calendar of Events"
            >
                <div class="p-6">
                    <VCalendar ref="calendar" :attributes='attributes'  expanded :rows="2" :is-dark="isDark" transparent borderless>
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
