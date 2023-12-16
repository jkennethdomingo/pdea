<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import ApexCharts from 'apexcharts'
import BaseCard from '@/components/ui/BaseCard.vue'
import { isDark } from '@/composables';
import { Icon } from '@iconify/vue'
import { useStore } from 'vuex';
import apiService from '@/composables/axios-setup';

const store = useStore();
const calendar = ref(null);

// Vuex state
const activeEmployees = computed(() => store.state.activeEmployees);
const todayTrainingCount = computed(() => store.state.todayTrainingCount);

const attributes = ref([]);
const apiUrl = 'hrDashboard';
const selectedColor = ref('blue');
const date = new Date();
const year = date.getFullYear();
const month = date.getMonth();

const employeeStatusChartEl = ref(null);
let employeeStatusChart = null;

const employeeStatusData = ref({
  activePercentage: 0,
  onTrainingPercentage: 0,
  onLeavePercentage: 0,
}); 

const upcomingEmployeeBirthdays = ref([]);
const upcomingTraining = ref([]);
const upcomingEmployeeOnLeave = ref([]);

const fetchUpcomingCombinedEvents = async () => {
  try {
    const response = await apiService.post('/hrDashboard/getUpcomingEvents');
    // Assuming response.data contains the correct structure
    upcomingEmployeeBirthdays.value = response.data.upcomingEmployeeBirthdays;
    upcomingTraining.value = response.data.upcomingTraining;
    upcomingEmployeeOnLeave.value = response.data.upcomingEmployeeOnLeave;

    // Use Vue.nextTick to ensure the DOM updates with the new data

    // Now the reactive variables should have the data
    console.log("Assigned Data:", upcomingEmployeeOnLeave.value); // Should log the updated data
  } catch (error) {
    console.error('Error fetching combined events:', error);
  }
};

function moveToday() {
  calendar.value.move(new Date());
}

const generateAttributes = () => {
  const birthdayAttributes = upcomingEmployeeBirthdays.value.map(event => ({
    key: `birthday-${event.EmployeeID}`,
    highlight: {
      color: 'red', //TODO: adjust the color as needed
      fillMode: 'light',
    },
    dates: new Date(event.date_of_birth),
    popover: { visibility: 'hover', content: () => `${event.first_name} ${event.surname}` },
  }));
  
  // Log birthdayAttributes directly, not birthdayAttributes.value
  console.log('Birthday Attributes:', birthdayAttributes);

  const trainingAttributes = upcomingTraining.value.map(event => ({
    key: `training-${event.training_id}`,
    highlight: {
      color: 'green', //TODO: adjust the color as needed
      fillMode: 'solid',
    },
    dates: { start: new Date(event.period_from), end: new Date(event.period_to) },
    popover: { content: () => `${event.title}` },
  }));

  const leaveAttributes = upcomingEmployeeOnLeave.value.map(event => ({
    key: `leave-${event.id}`,
    highlight: {
      color: 'orange', //TODO: adjust the color as needed
      fillMode: 'outline',
    },
    dates: { start: new Date(event.start_date), end: new Date(event.end_date) },
    popover: { content: () => `${event.LeaveTypeName}` },
  }));

  // Combine all attributes into a single array
  const combinedAttributes = [...birthdayAttributes, ...trainingAttributes, ...leaveAttributes];

  // Log the combinedAttributes for debugging
  console.log('Combined Attributes:', combinedAttributes);

  return combinedAttributes;
};

// Watch for changes in the data sources and regenerate attributes accordingly
watch([upcomingEmployeeBirthdays, upcomingTraining, upcomingEmployeeOnLeave], generateAttributes, { immediate: true });



const fetchEmployeeStatusData = async () => {
  try {
    const response = await apiService.post(`${apiUrl}/getEmployeeStatusPercentages`);
    const { activePercentage, onTrainingPercentage, onLeavePercentage } = response.data;
    employeeStatusData.value = { activePercentage, onTrainingPercentage, onLeavePercentage };
    updateChart();
  } catch (error) {
    console.error("Error fetching employee status data:", error);
  }
};

const updateChart = () => {
  if (employeeStatusChart) {
    employeeStatusChart.destroy();
  }

  employeeStatusChart = new ApexCharts(employeeStatusChartEl.value, {
    series: [
      employeeStatusData.value.activePercentage, // Percentage of active employees
      employeeStatusData.value.onTrainingPercentage, // Percentage of employees on training
      employeeStatusData.value.onLeavePercentage // Percentage of employees on leave
    ],
    chart: {
        type: 'donut',
        toolbar: {
        show: true,
        tools: {
            download: true,
            selection: true,
            zoom: true,
            zoomin: true,
            zoomout: true,
            pan: true,
            reset: '<img src="/static/icons/reset.png" width="20">', // Use the actual path to your reset icon
            customIcons: [] // Include any custom icons here
        },
        autoSelected: 'zoom' 
    },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        },
        dropShadow: {
            enabled: false,
            top: 3,
            left: 0,
            blur: 5,
            opacity: 0.5
        },
        // other chart configurations...
    },
    plotOptions: {
        pie: {
            donut: {
                size: '65%',
                background: 'transparent',
                labels: {
                    show: true,
                    name: {
                        show: true,
                        fontSize: '22px',
                        fontWeight: 600,
                        color: undefined,
                        offsetY: -10
                    },
                    value: {
                        show: true,
                        fontSize: '16px',
                        fontWeight: 400,
                        color: undefined,
                        offsetY: 16,
                        formatter: function (val) {
                            return val
                        }
                    },
                    total: {
                        show: true,
                        showAlways: false,
                        label: 'Total',
                        fontSize: '22px',
                        fontWeight: 600,
                        color: '#373d3f',
                        formatter: function (w) {
                            return w.globals.seriesTotals.reduce((a, b) => {
                                return a + b
                            }, 0)
                        }
                    }
                }
            },
            expandOnClick: true,
            customScale: 1,
            offsetX: 0,
            offsetY: 0,
            dataLabels: {
                offset: 0,
                minAngleToShowLabel: 10
            }
        }
    },
    colors: ['#10e2b8', '#1e90ff', '#ffa700'],
    dataLabels: {
        enabled: false,
        formatter: function (val, opts) {
            return val + '%'
        },
        textAnchor: 'middle',
        distributed: false,
        offsetX: 0,
        offsetY: 0,
        style: {
            fontSize: '14px',
            fontWeight: 'bold',
            colors: undefined
        },
        background: {
            enabled: false,
            foreColor: '#fff',
            padding: 4,
            borderRadius: 2,
            borderWidth: 1,
            borderColor: '#fff',
            opacity: 0.9,
            dropShadow: {
                enabled: false,
                top: 1,
                left: 1,
                blur: 1,
                color: '#000',
                opacity: 0.45
            }
        },
        dropShadow: {
            enabled: false,
            top: 1,
            left: 1,
            blur: 1,
            color: '#000',
            opacity: 0.45
        }
    },
    labels: ['Active', 'On Training', 'On Leave'],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center', 
        floating: false,
        fontSize: '14px',
        fontWeight: 400,
        formatter: undefined,
        inverseOrder: false,
        width: undefined,
        height: undefined,
        tooltipHoverFormatter: undefined,
        customLegendItems: [],
        offsetX: 0,
        offsetY: 0,
        labels: {
            colors: undefined,
            useSeriesColors: false
        },
        markers: {
            width: 12,
            height: 12,
            strokeWidth: 0,
            strokeColor: '#fff',
            fillColors: undefined,
            radius: 12,
            customHTML: undefined,
            onClick: undefined,
            offsetX: 0,
            offsetY: 0
        },
        itemMargin: {
            horizontal: 5,
            vertical: 0
        },
        onItemClick: {
            toggleDataSeries: true
        },
        onItemHover: {
            highlightDataSeries: true
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 300
            },
            legend: {
                position: 'bottom'
            }
        }
    }],
    title: {
        text: 'Employee Status Distribution',
        align: 'center',
        margin: 10,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#263238'
        }
    },
    subtitle: {
        text: 'As of Current Date',
        align: 'center',
        margin: 10,
        offsetX: 0,
        offsetY: 30,
        floating: false,
        style: {
            fontSize: '14px',
            fontWeight: 'normal',
            color: '#90a4ae'
        }
    },
    tooltip: {
        enabled: true,
        offsetY: 0,
        style: {
            fontSize: '12px',
        },
        y: {
            formatter: function (val) {
                return val + '%'
            }
        }
    }
});


  employeeStatusChart.render();
};


const activeTab = ref('today');

watch(activeTab, (newTab) => {
  switch (newTab) {
    case 'today':
      // Fetch data relevant to 'today' tab
      fetchEmployeeStatusData();
      break;
    case 'monthly':
      // Fetch data relevant to 'monthly' tab
      // fetchMonthlyData(); // Implement this function
      break;
    case 'annually':
      // Fetch data relevant to 'annually' tab
      // fetchAnnuallyData(); // Implement this function
      break;
  }
});

const setActiveTab = (tab) => {
  activeTab.value = tab;
};


onMounted(async () => {
await store.dispatch('fetchChartCountData', apiUrl);
await fetchEmployeeStatusData();
await fetchUpcomingCombinedEvents();
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
            <BaseCard noHeader class="items-center"> <!-- Added items-center for vertical alignment -->
                <div role="tablist" class="tabs tabs-bordered">
                    <a role="tab" class="tab" :class="{ 'tab-active': activeTab === 'today' }" @click="setActiveTab('today')">Today</a>
                    <a role="tab" class="tab" :class="{ 'tab-active': activeTab === 'monthly' }" @click="setActiveTab('monthly')">Monthly</a>
                    <a role="tab" class="tab" :class="{ 'tab-active': activeTab === 'annually' }" @click="setActiveTab('annually')">Annually</a>
                </div>
                <div v-show="activeTab === 'today'"> <!-- Reduced gap and switched to flex for a tighter layout -->
                        <div font-sans ref="employeeStatusChartEl"></div>
                </div>
                <div v-show="activeTab === 'monthly'"> <!-- Reduced gap and switched to flex for a tighter layout -->
                    <h4 class="flex justify-center text-2xl font-medium text-green-800 dark:text-green-300">Employee Status Distribution</h4>
                    <p class="text-lg font-medium text-gray-800 dark:text-gray-200">
                        Monthly
                    </p>
                    <p class="text-base font-medium text-green-400">
                        +20.5%
                    </p>
                    <p class="text-2xl font-medium text-gray-800 dark:text-gray-200">
                        $5070.80
                    </p>
                    <div class="flex w-full h-full items-center justify-center"> 
                    </div>
                </div>
                <div v-show="activeTab === 'annually'"> <!-- Reduced gap and switched to flex for a tighter layout -->
                    <h4 class="flex justify-center text-2xl font-medium text-green-800 dark:text-green-300">Employee Status Distribution</h4>
                    <p class="text-lg font-medium text-gray-800 dark:text-gray-200">
                        Annually
                    </p>
                    <p class="text-base font-medium text-green-400">
                        +20.5%
                    </p>
                    <p class="text-2xl font-medium text-gray-800 dark:text-gray-200">
                        $5070.80
                    </p>
                    <div class="flex w-full h-full items-center justify-center"> 
                    </div>
                </div>
                
            </BaseCard>
            </div>

            <!-- Calendar -->
            <BaseCard title="Calendar of Events">
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

                        <!-- footer slot for additional actions -->
                        <template #footer>
                            <div class="w-full px-4 pb-3">
                                <button
                                    class="bg-[#10e2b8] hover:bg-[#57ae9d] text-white font-bold w-full px-3 py-1 rounded-md"
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
