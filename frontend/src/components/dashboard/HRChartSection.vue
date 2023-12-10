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

const date = new Date();
const year = date.getFullYear();
const month = date.getMonth();
const attributes = ref([
  {
    key: 'today',
    highlight: {
      color: 'purple',
      fillMode: 'solid',
      contentClass: 'italic',
    },
    dates: new Date(year, month, 12),
  },
  {
    highlight: {
      color: 'purple',
      fillMode: 'light',
    },
    dates: new Date(year, month, 13),
  },
  {
    highlight: {
      color: 'purple',
      fillMode: 'outline',
    },
    dates: new Date(year, month, 14),
  },
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
        colors: ['#a855f7', '#e2e8f0'],
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
                    <BaseCard no-header bg-classes="bg-purple-500">
                        <div class="p-2 grid grid-cols-1 gap-4">
                            <Icon
                                icon="clarity:employee-group-line"
                                aria-hidden="treu"
                                class="w-10 h-10 text-white"
                            />

                            <div class="grid gap-2">
                                <p class="text-base font-medium text-green-300">
                                    +1%
                                </p>
                                <p class="text-3xl font-medium text-white">
                                    {{activeEmployees}}
                                </p>
                            </div>

                            <p class="text-sm font-medium text-white">
                                Today's Active Employees
                            </p>
                        </div>
                    </BaseCard>

                    <!-- Today's sales -->
                    <BaseCard no-header bg-classes="bg-cyan-500">
                        <div class="p-2 grid grid-cols-1 gap-4">
                            <Icon
                                icon="mdi:chart-bar"
                                aria-hidden="true"
                                class="w-10 h-10 text-white"
                            />

                            <div class="grid gap-2">
                                <p class="text-base font-medium text-green-300">
                                    +4%
                                </p>
                                <p class="text-3xl font-medium text-white">
                                    {{ todayTrainingCount }}
                                </p>
                            </div>

                            <p class="text-sm font-medium text-white">
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
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold w-full px-3 py-1 rounded-md"
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
