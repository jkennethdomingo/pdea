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
            :to="{ name: 'LG_Dashboard' }"
            :active="isCurrentRoute('LG_Dashboard')"
            icon="mdi:view-dashboard"
        />
        <SidebarLink
            icon="material-symbols:inventory"
            :to="{ name: 'LG_Inventory' }"
            title="Inventory"
            :active="isCurrentRoute('LG_Inventory')"
        >
        </SidebarLink>

        <SidebarLink
            icon="carbon:report"
            :to="{ name: 'LG_Reports' }"
            title="Reports"
            :active="isCurrentRoute('LG_Reports')"
        >
        </SidebarLink>
        
    </PerfrectScrollbar>
</template>
