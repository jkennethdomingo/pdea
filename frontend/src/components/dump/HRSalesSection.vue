<script setup>
import { onMounted, ref, computed, watch } from 'vue';
import { useStore } from 'vuex';
import ApexCharts from 'apexcharts';
import BaseCard from '@/components/ui/BaseCard.vue';
import { usePhotoUrl } from '@/composables/usePhotoUrl';

const store = useStore();
const employeeStatusChartEl = ref(null); // Updated reference name
const employeeStatusPercentages = computed(() => store.state.employeeStatusPercentages);
let employeeStatusChart; // Updated variable name for the chart
const { getPhotoUrl } = usePhotoUrl();
const approvedLeaves = computed(() => store.state.approvedLeaves);
const unassignedUpcomingTrainings = computed(() => store.state.unassignedUpcomingTrainings);

onMounted(async () => {
  try {
    await Promise.all([
      store.dispatch('fetchEmployeeStatusPercentages'),
      store.dispatch('fetchApprovedLeaves'),
      store.dispatch('fetchUnassignedUpcomingTrainings'),
    ]);
    initializeChart();
  } catch (error) {
    console.error('Error in fetching data:', error);
  }
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
        return `${parseFloat(val).toFixed(2)}%`;
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
                return `${parseFloat(val).toFixed(2)}%`;
              },
            },
            total: {
              show: true,
              label: 'Employees',
              formatter: function (w) {
                const totalPercentage = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
              return `${totalPercentage.toFixed(2)}%`;
              }
            },
          },
        },
      },
    },
    legend: {
      position: 'bottom',
    },
    colors: ['#00FFCA', '#FCE22A', '#F6BA6F'],
  });

  employeeStatusChart.render();
}, { immediate: true });
const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};
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
            <BaseCard title="Recently Approved Leaves" :actions="[{ title: 'View', to: '#' }]">
                <div v-if="approvedLeaves && approvedLeaves.length" class="mt-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <tbody>
                        <tr class="border-b dark:border-gray-700" v-for="leave in approvedLeaves" :key="leave.id">
                        <!-- Employee Details -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                            <template v-if="leave.photo">
                                <img class="w-10 h-10 rounded-md object-cover" :src="getPhotoUrl(leave.photo)" alt="Employee Photo" />
                            </template>
                            <template v-else>
                                <svg class="w-10 h-10 text-gray-400 rounded-md" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </template>
                            <div>
                                <h5 class="text-md text-green-600 dark:text-green-300">
                                {{ leave.first_name }} {{ leave.middle_name }} {{ leave.surname }}
                                </h5>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                {{ leave.Email }}
                                </p>
                            </div>
                            </div>
                        </td>
                        
                        <!-- Leave Details -->
                        <td class="px-6 py-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ leave.LeaveTypeName }}: {{ leave.start_date }} - {{ leave.end_date }}
                            </p>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                </div>
                <div v-else class="text-center">
                <p>No approved leaves available.</p>
                </div>
            </BaseCard>

            <!-- Recent transactions -->
            <BaseCard title="Unassigned Trainings" :actions="[{ title: 'View', to: '#' }]">
            <div v-if="unassignedUpcomingTrainings.length > 0">
            <div v-for="training in unassignedUpcomingTrainings" :key="training.training_id" class="mt-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                <!-- Your icon component might be different -->
                <Icon icon="mdi:checkbox-blank-circle-outline" aria-hidden="true" class="w-6 h-6 text-gray-500" />
                <div>
                    <h5 class="text-xs text-gray-600 dark:text-gray-300">
                    {{ training.title }}
                    </h5>
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                    {{ formatDate(training.period_from) }}
                    </p>
                </div>
                </div>
                <!-- This could be a placeholder for future functionality like status or actions -->
                <span class="text-base font-medium text-gray-500">
                Pending
                </span>
            </div>
            </div>
            <div v-else class="text-center">
            <p>No unassigned trainings available.</p>
            </div>
        </BaseCard>
        </div>
            
        </div>
</section>
</template>
