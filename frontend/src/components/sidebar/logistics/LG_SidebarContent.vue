<script setup>
import { useRouter } from 'vue-router'
import PerfrectScrollbar from '@/components/PerfectScrollbar.vue'
import SidebarLink from '@/components/sidebar/SidebarLink.vue'
import SidebarCollapsible from '@/components/sidebar/SidebarCollapsible.vue'
import SidebarCollapsibleItem from '@/components/sidebar/SidebarCollapsibleItem.vue'

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
        <SidebarCollapsible icon="material-symbols:inventory" title="Manage Inventory" :active="isCurrentPath('/logistics/lg/inventory_management')">
            <SidebarCollapsibleItem
            :to="{ name: 'LG_Inventory' }"
            title="Inventory"
            :active="isCurrentRoute('LG_Inventory')"
            />
            <SidebarCollapsibleItem
            :to="{ name: 'LG_Inventory_Add' }"
            title="Add Inventory"
            :active="isCurrentRoute('LG_Inventory_Add')"
            />
        </SidebarCollapsible>

        <SidebarLink
            icon="carbon:report"
            :to="{ name: 'LG_Reports' }"
            title="Reports"
            :active="isCurrentRoute('LG_Reports')"
        >
        </SidebarLink>

        <SidebarCollapsible icon="mdi:shield-star-outline" title="Material Requisition" :active="isCurrentPath('/logistics/lg/material_requisition')">
            <SidebarCollapsibleItem
                :to="{ name: 'LG_Agent' }"
                title="Agent"
                :active="isCurrentRoute('LG_Agent')"
            />
            <SidebarCollapsibleItem
                :to="{ name: 'LG_Department' }"
                title="Department"
                :active="isCurrentRoute('LG_Department')"
            />
            <SidebarCollapsibleItem
                :to="{ name: 'LG_Provincial_Office' }"
                title="Provincial Office "
                :active="isCurrentRoute('LG_Provincial_Office')"
            />
            <SidebarCollapsibleItem
                :to="{ name: 'LG_Regional_Office' }"
                title="Regional Office "
                :active="isCurrentRoute('LG_Regional_Office')"
            />
        </SidebarCollapsible>

        
    </PerfrectScrollbar>
</template>
