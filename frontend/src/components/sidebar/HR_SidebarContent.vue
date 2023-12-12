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
        <SidebarCollapsible icon="mdi:calendar" title="Calendar" :active="isCurrentPath('/human-resources/calendar')">
            <SidebarCollapsibleItem
            :to="{ name: 'Assign Training' }"
            title="Assign Training"
            :active="isCurrentRoute('Assign Training')"
            />
            <SidebarCollapsibleItem
            :to="{ name: 'Manage Leave' }"
            title="Manage Leave"
            :active="isCurrentRoute('Manage Leave')"
            />
        </SidebarCollapsible>

        <!-- <SidebarLink
            icon="ic:round-people"
            :to="{ name: 'Beta' }"
            title="Beta"
            :active="isCurrentRoute('Beta')"
        >
        </SidebarLink> -->
        <SidebarLink
            icon="ph:certificate"
            :to="{ name: 'Certificate' }"
            title="Certificate"
            :active="isCurrentRoute('Certificate')"
        >

        </SidebarLink>
        <SidebarLink
            icon="ic:round-people"
            :to="{ name: 'Backup and Restore' }"
            title="Backup and Restore"
            :active="isCurrentRoute('Backup and Restore')"
        >
        </SidebarLink>
        <!-- <SidebarLink
            icon="ic:round-people"
            :to="{ name: 'Betatest' }"
            title="Testingan"
            :active="isCurrentRoute('Betatest')"
        >
        </SidebarLink> -->
    </PerfrectScrollbar>
</template>
