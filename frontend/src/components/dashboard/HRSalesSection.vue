<script setup>
import { onMounted, ref, computed, watch } from 'vue';
import { useStore } from 'vuex';
import ApexCharts from 'apexcharts';
import BaseCard from '@/components/ui/BaseCard.vue';

const store = useStore();
const employeeStatusChartEl = ref(null); // Updated reference name
const employeeStatusPercentages = computed(() => store.state.employeeStatusPercentages);
let employeeStatusChart; // Updated variable name for the chart

onMounted(() => {
  store.dispatch('fetchEmployeeStatusPercentages');
});

watch(employeeStatusPercentages, (newVal) => {
  if (!employeeStatusChartEl.value) {
    return;
  }

  if (employeeStatusChart) {
    employeeStatusChart.destroy();
  }

  employeeStatusChart = new ApexCharts(employeeStatusChartEl.value, {
    series: [newVal.activePercentage, newVal.onTrainingPercentage, newVal.onLeavePercentage],
    chart: {
      type: 'donut',
      height: '100%',
      toolbar: {
        show: false,
      },
    },
    labels: ['Active', 'On Training', 'On Leave'],
    dataLabels: {
      enabled: true,
      formatter: function(val) {
        return `${val}%`;
      },
    },
    plotOptions: {
      pie: {
        donut: {
          size: '65%',
          labels: {
            show: true,
            name: {
              offsetY: -10,
            },
            value: {
              formatter: function(val) {
                return `${parseInt(val)}%`;
              },
            },
            total: {
              show: true,
              label: 'Employees',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce((a, b) => {
                  return a + b;
                }, 0) + '%'
              }
            },
          },
        },
      },
    },
    legend: {
      position: 'bottom',
    },
    colors: ['#f59e0b', '#10b981', '#3b82f6'],
  });

  employeeStatusChart.render();
}, { immediate: true });
</script>




<template>
    <section class="grid grid-cols-1">
        <h2 class="sr-only">Sales charts</h2>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            
            <BaseCard title="Employee Status Distribution" :actions="[{ title: 'View', to: '#' }]">
                <div ref="employeeStatusChartEl"></div>
            </BaseCard>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            <!-- Recent contacts -->
            <BaseCard
                title="Recent Contacts"
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
                title="Recent Transactions"
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
            
        </div>
</section>
</template>
