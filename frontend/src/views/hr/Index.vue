<script setup>
import PageWrapper from '@/components/layout/PageWrapper.vue'
import HRStatisticsSection from '@/components/dashboard/HRStatisticsSection.vue'
import HRSalesSection from '@/components/dashboard/HRChartSection.vue'
import HRLatestSection from '@/components/dashboard/HRUpcomingSection.vue'
</script>

<template>
    <PageWrapper>
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">Dashboard</h2>

                
            </div>
        </template>

        <!-- Statistics section -->
        <HRStatisticsSection />

        <!-- Sales section -->
        <HRSalesSection />

        <!-- Latest users & transaction section -->
        <HRLatestSection />
    </PageWrapper>
</template>
