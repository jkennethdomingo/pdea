<script setup>
import { useRouter } from 'vue-router'
import PerfrectScrollbar from '@/components/base/PerfectScrollbar.vue'
import SidebarLink from '@/components/sidebar/SidebarLink.vue'
import SidebarCollapsible from '@/components/sidebar/SidebarCollapsible.vue'
import SidebarCollapsibleItem from '@/components/sidebar/SidebarCollapsibleItem.vue'

const router = useRouter();

const isCurrentRoute = (routeName) => {
    return router.currentRoute.value.name === routeName;
}

const isCurrentPath = (path) => {
    return router.currentRoute.value.path.startsWith(path);
}

const isAssignRouteActive = () => {
    // Checks if the current route is "Assign Training Overview" or one of its children
    return router.currentRoute.value.matched.some(route => {
        // Ensure route.name is defined before calling startsWith
        return route.name && (route.name === 'Assign Training' || route.name.startsWith('Assign Training '));
    });
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
            :to="{ name: 'User Dashboard' }"
            :active="isCurrentRoute('User Dashboard')"
            icon="mdi:view-dashboard"
        />

        <SidebarLink
            title="Request Leave"
            :to="{ name: 'Leave Request' }"
            :active="isCurrentRoute('Leave Request')"
            icon="mdi:calendar"
        />

        
    </PerfrectScrollbar>
</template>
