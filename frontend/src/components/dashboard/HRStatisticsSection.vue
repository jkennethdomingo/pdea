<script setup>
import { onMounted, ref } from 'vue';
import apiService from '@/composables/axios-setup';
import QuiclStatisticsCard from '@/components/ui/QuiclStatisticsCard.vue'

const apiUrl = 'hrDashboard';

const customersData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const visitsData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13].reverse()
const ordersData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const growthData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]

const trainingParticipants = ref(0);
const employeesOnLeave = ref(0);
const pendingLeave = ref(0);
const unassignedTraining = ref(0);


onMounted(async () => {
  try {
    const trainingResponse = await apiService.post(`${apiUrl}/getTodayOnTrainingCount`);
    trainingParticipants.value = trainingResponse.data.todaysOnTrainingCount;

    const onLeaveResponse = await apiService.post(`${apiUrl}/getTodaysLeavesCount`);
    employeesOnLeave.value = onLeaveResponse.data.todaysLeavesCount;

    const pendingLeaveResponse = await apiService.post(`${apiUrl}/fetchPendingLeaveCount`);
    pendingLeave.value = pendingLeaveResponse.data.pendingLeavesCount;

    const pendingTrainingResponse = await apiService.post(`${apiUrl}/fetchCountOfUpcomingTrainingsWithNoAssignedEmployees`);
    unassignedTraining.value = pendingTrainingResponse.data.data; 
    
  } catch (error) {
    console.error("API fetch error:", error);
  }
});
</script>

<template>
    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <h2 class="sr-only">Quick statistics</h2>

        <!-- Training Participants card -->
        <QuiclStatisticsCard
            title="Training Participants"
            :chartData="customersData"
            :result="trainingParticipants"
            percentage="32.40%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="healthicons:i-training-class"
        />

        <!-- Employees on Leave card -->
        <QuiclStatisticsCard
            title="Employees on Leave"
            :chartData="visitsData"
            :result="employeesOnLeave"
            status="danger"
            percentage="-2.10%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="fluent-mdl2:leave-user"
        />

        <!-- Pending Leave Requests card -->
        <QuiclStatisticsCard
            title="Pending Leave Requests"
            :chartData="ordersData"
            :result="pendingLeave"
            status="warning"
            percentage="0.60%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="material-symbols:pending-actions"
        />

        <!-- Unassigned Trainings card -->
        <QuiclStatisticsCard
            title="Unassigned Trainings"
            :chartData="growthData"
            :result="unassignedTraining"
            percentage="7.20%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="subway:missing"
        />
    </section>
</template>
