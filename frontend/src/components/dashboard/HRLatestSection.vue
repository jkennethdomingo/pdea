<script setup>
import BaseCard from '@/components/ui/BaseCard.vue'
import Button from '@/components/base/Button.vue'
import Calendar from '@/components/dashboard/HRCalendarOfEvents.vue'
import { Icon } from '@iconify/vue'
</script>

<template>
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <h2 class="sr-only">Upcoming Events</h2>

        <!-- Latest users -->
        <BaseCard title="Upcoming Events" :actions="[{ title: 'View', to: '#' }]">
            <!-- Table -->
        </BaseCard>

        <!-- Recent cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            <!-- Recent contacts -->
            <BaseCard
            >
                <Calendar/>
            </BaseCard>
            
        </div>
    </section>
</template>
