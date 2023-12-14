<script setup>
import PageWrapper from '@/components/layout/PageWrapper.vue'
import HRStatisticsSection from '@/components/dashboard/HRStatisticsSection.vue'
import HRChartSection from '@/components/dashboard/HRChartSection.vue'
import HRUpcomingSection from '@/components/dashboard/HRUpcomingSection.vue'
</script>

<template>
    <PageWrapper>
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">Dashboard</h2>

                
            </div>
        </template>

        <HRStatisticsSection />
        <HRChartSection />
        <!-- Statistics section -->

        <!-- Sales section -->

        <!-- Latest users & transaction section -->
        <HRUpcomingSection />
    </PageWrapper>
</template>
