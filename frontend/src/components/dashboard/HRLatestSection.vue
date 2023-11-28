<script setup>
import BaseCard from '@/components/ui/BaseCard.vue'
import Button from '@/components/base/Button.vue'
import { Icon } from '@iconify/vue'
</script>

<template>
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <h2 class="sr-only">Latest users</h2>

        <!-- Latest users -->
        <BaseCard title="Latest Users" :actions="[{ title: 'View', to: '#' }]">
            <!-- Table -->
        </BaseCard>

        <!-- Recent cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
            
        </div>
    </section>
</template>
