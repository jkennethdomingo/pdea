<script setup>
import PageWrapper from '@/components/layout/PageWrapper.vue'
import HRStatisticsSection from '@/components/dump/HRSalesSection.vue'
import HRSalesSection from '@/components/dump/HRStatisticsSection.vue'
import HRLatestSection from '@/components/dump/HRLatestSection.vue'
</script>

<template>
    <PageWrapper>
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">Dashboard</h2>

                
            </div>
        </template>

        <HRSalesSection />
        <!-- Statistics section -->
        <HRStatisticsSection />

        <!-- Sales section -->

        <!-- Latest users & transaction section -->
        <HRLatestSection />
    </PageWrapper>
</template>
