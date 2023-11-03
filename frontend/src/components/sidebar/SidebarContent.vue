<script setup>
import { useRouter } from 'vue-router'
import PerfrectScrollbar from '@/components/PerfectScrollbar.vue'
import SidebarLink from '@/components/sidebar/SidebarLink.vue'

const isCurrentRoute = (routeName) => {
    return useRouter().currentRoute.value.name == routeName
}

const isCurrentPath = (path) => {
    return useRouter().currentRoute.value.path.startsWith(path)
}
</script>

<template>
    <PerfrectScrollbar
        tagname="nav"
        aria-label="main"
        class="relative flex flex-col flex-1 max-h-full gap-4 px-3"
    >
        <SidebarLink
            title="Dashboard"
            :to="{ name: 'Dashboard' }"
            :active="isCurrentRoute('Dashboard')"
            icon="mdi:view-dashboard"
        />

        <SidebarLink
            icon="ic:round-people"
            :to="{ name: 'Company' }"
            title="Company"
            :active="isCurrentRoute('Company')"
        >
        </SidebarLink>

        <SidebarLink
            icon="clarity:assign-user-solid"
            :to="{ name: 'Blank' }"
            title="Assign"
            :active="isCurrentRoute('Blank')"
        >
        </SidebarLink>
    </PerfrectScrollbar>
</template>
