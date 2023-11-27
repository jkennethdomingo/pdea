<script setup>
import { onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import QuiclStatisticsCard from '@/components/ui/QuiclStatisticsCard.vue'

const store = useStore();

onMounted(() => {
    store.dispatch('fetchTodaysLeavesCount');
    store.dispatch('fetchTodaysTrainingCount');
    store.dispatch('fetchTodaysOnTrainingCount');
    store.dispatch('fetchTodaysActiveEmployeeCount');
});

const todaysLeavesCount = computed(() => store.state.todaysLeavesCount);
const todaysTrainingCount = computed(() => store.state.todaysTrainingCount);
const todaysOnTrainingCount = computed(() => store.state.todaysOnTrainingCount);
const todaysActiveEmployeeCount = computed(() => store.state.ActiveEmployeesCount);

const inWorkData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const inTrainingData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13].reverse()
const onLeaveData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const trainingData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
</script>

<template>
    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <h2 class="sr-only">Quick statistics</h2>

        <!-- Customers card -->
        <QuiclStatisticsCard
            title="Active Employees"
            :chartData="inWorkData"
            :result="todaysActiveEmployeeCount"
            percentage="32.40%"
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
            title="Today's Training Schedule"
            :chartData="trainingData"
            :result="todaysTrainingCount"
            percentage="7.20%" 
            :actions="[{ title: 'View', to: '#' }]"
            icon="fa-solid:users"
        />
    </section>
</template>
