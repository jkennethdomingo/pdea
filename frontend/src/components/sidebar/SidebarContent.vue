<script setup>
import { useRouter } from 'vue-router'
import PerfrectScrollbar from '@/components/PerfectScrollbar.vue'
import SidebarLink from '@/components/sidebar/SidebarLink.vue'

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
            :to="{ name: 'Personal Information' }"
            title="Registration"
            :active="isCurrentPath('/human-resources/register')"
        >
        </SidebarLink>
        <SidebarLink
            icon="mdi:calendar"
            :to="{ name: 'Calendar' }"
            title="Calendar"
            :active="isCurrentRoute('Calendar')"
        >
        </SidebarLink>
    </PerfrectScrollbar>
</template>
