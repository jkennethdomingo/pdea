<script setup>
import { onMounted, computed, watch } from 'vue';
import { useStore } from 'vuex';
import QuiclStatisticsCard from '@/components/ui/QuiclStatisticsCard.vue'

const store = useStore();

onMounted(() => {
    store.dispatch('fetchTodaysLeavesCount');
    store.dispatch('fetchTodaysTrainingCount');
    store.dispatch('fetchTodaysOnTrainingCount');
    store.dispatch('fetchTodaysActiveEmployeeCount');
    store.dispatch('fetchActiveEmployeesLast13Days');
    store.dispatch('fetchCountOfUpcomingTrainingsWithNoAssignedEmployees');
});

const todaysLeavesCount = computed(() => store.state.todaysLeavesCount);
const todaysTrainingCount = computed(() => store.state.todaysTrainingCount);
const todaysOnTrainingCount = computed(() => store.state.todaysOnTrainingCount);
const todaysActiveEmployeeCount = computed(() => store.state.ActiveEmployeesCount);
const activeEmployeesLast13Days = computed(() => store.state.activeEmployeesLast13Days);
const activeEmployeesPercentagesLast13Days = computed(() => store.state.activeEmployeesPercentagesLast13Days);
const countOfUnassignedUpcomingTrainings = computed(() => store.state.countOfUnassignedUpcomingTrainings);

const transformedActiveEmployeeData = computed(() => {
  return activeEmployeesLast13Days.value.map(data => data.activeCount);
});
const transformedActiveEmployeePercentages = computed(() => {
  return activeEmployeesPercentagesLast13Days.value.map(data => data.activePercentage);
});

const percentageChangeFromLastDay = computed(() => {
  if (activeEmployeesLast13Days.value.length > 1) {
    const lastDayIndex = activeEmployeesLast13Days.value.length - 1;
    const lastDayCount = activeEmployeesLast13Days.value[lastDayIndex].activeCount;
    const secondLastDayCount = activeEmployeesLast13Days.value[lastDayIndex - 1].activeCount;

    if (secondLastDayCount === 0) {
      return lastDayCount > 0 ? '100%' : '0%'; // If the second last day had 0, it's either an increase from 0 to a positive number or no change (0 to 0)
    } else {
      const change = lastDayCount - secondLastDayCount;
      const percentageChange = (change / secondLastDayCount) * 100;
      return percentageChange.toFixed(2) + '%'; // Return the change as a formatted percentage string
    }
  }

  return '0%'; // Default to 0% if there's not enough data
});

const activeEmployeeStatus = computed(() => {
  if (activeEmployeesLast13Days.value.length > 1) {
    const lastDayIndex = activeEmployeesLast13Days.value.length - 1;
    const lastDayCount = activeEmployeesLast13Days.value[lastDayIndex].activeCount;
    const secondLastDayCount = activeEmployeesLast13Days.value[lastDayIndex - 1].activeCount;

    if (secondLastDayCount === 0) {
      return lastDayCount > 0 ? 'success' : 'warning'; // If the second last day had 0, it's either an increase from 0 to a positive number or no change (0 to 0)
    } else {
      const change = lastDayCount - secondLastDayCount;
      const percentageChange = (change / secondLastDayCount) * 100;
      
      if (change > 0) {
        return 'success';
      } else if (change < 0) {
        return 'danger';
      }
    }
  }

  return 'warning'; // Default to 'warning' if there's not enough data or no change
});



const onLeaveData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const trainingData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]

</script>

<template>
    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <h2 class="sr-only">Quick statistics</h2>

        <!-- Customers card -->
        <QuiclStatisticsCard
        title="Active Employees"
        :chartData="transformedActiveEmployeeData"
        :result="todaysActiveEmployeeCount"
        :percentage="percentageChangeFromLastDay" 
        :status="activeEmployeeStatus"
        :actions="[{ title: 'View', to: '#' }]"
        icon="clarity:employee-group-solid"
        />

       <!-- Training card -->
       <QuiclStatisticsCard
            title="Training Participation"
            :chartData="trainingData"
            :result="todaysOnTrainingCount"
            status="danger"
            percentage="-2.10%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="healthicons:i-training-class"
        />

        <!-- Orders card -->
        <QuiclStatisticsCard
        title="Leave Status Today"
        :chartData="onLeaveData"
        :result="todaysLeavesCount"
        percentage="0.60%" 
        :actions="[{ title: 'View', to: '#' }]"
        icon="fluent-mdl2:leave-user"
    />

        <!-- Growth card -->
        <QuiclStatisticsCard
            title="Unassigned Training"
            :chartData="trainingData"
            :result="countOfUnassignedUpcomingTrainings"
            percentage="7.20%" 
            :actions="[{ title: 'View', to: '#' }]"
            icon="fa-solid:users"
        />
    </section>
</template>
