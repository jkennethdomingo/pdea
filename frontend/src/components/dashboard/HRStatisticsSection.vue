<script setup>
import QuiclStatisticsCard from '@/components/ui/QuiclStatisticsCard.vue'

const customersData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const visitsData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13].reverse()
const ordersData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
const growthData = [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13]
</script>

<template>
    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <h2 class="sr-only">Quick statistics</h2>

        <!-- Customers card -->
        <QuiclStatisticsCard
            title="In Work"
            :chartData="customersData"
            result="12.4k"
            percentage="32.40%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="clarity:employee-group-solid"
        />

        <!-- Visits card -->
        <QuiclStatisticsCard
            title="In Training"
            :chartData="visitsData"
            result="-2.6k"
            status="danger"
            percentage="-2.10%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="healthicons:i-training-class"
        />

        <!-- Orders card -->
        <QuiclStatisticsCard
            title="On Leave Today"
            :chartData="ordersData"
            result="34.4k"
            status="warning"
            percentage="0.60%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="fluent-mdl2:leave-user"
        />

        <!-- Growth card -->
        <QuiclStatisticsCard
            title="Absent"
            :chartData="growthData"
            result="15.6%"
            percentage="7.20%"
            :actions="[{ title: 'View', to: '#' }]"
            icon="fa-solid:users"
        />
    </section>
</template>
