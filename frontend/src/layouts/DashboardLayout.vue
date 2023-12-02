<script setup>
import { sidebarState } from '@/composables'
import Sidebar from '@/components/layout/Sidebar.vue'
import Navbar from '@/components/layout/Navbar.vue'
import PageFooter from '@/components/layout/PageFooter.vue'
</script>

<template>
    <div class="min-h-screen text-green-900 bg-[#e3ecf4] dark:bg-gray-900 dark:text-green-100">
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
