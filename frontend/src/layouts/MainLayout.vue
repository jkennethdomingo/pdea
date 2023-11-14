<script setup>
import { sidebarState } from '@/composables'
import Sidebar from '@/components/sidebar/Sidebar.vue'
import Navbar from '@/components/Navbar.vue'
import PageFooter from '@/components/PageFooter.vue'
</script>

<template>
    <div class="min-h-screen overflow-y-hidden text-green-900 bg-gray-50 dark:bg-gray-900 dark:text-green-100">
        <Sidebar />

        <div
            style="transition-property: margin; transition-duration: 150ms"
            :class="[
                'min-h-screen flex flex-col',
                {
                    'lg:ml-64': sidebarState.isOpen,
                    'md:ml-16': !sidebarState.isOpen,
                },
            ]"
        >
            <Navbar />

            <router-view></router-view>

            <PageFooter />
        </div>
    </div>
</template>
