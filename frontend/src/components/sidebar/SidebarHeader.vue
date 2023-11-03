<script setup>
import Logo from '@/components/Logo.vue'
import Button from '@/components/Button.vue'
import { Icon } from '@iconify/vue'
import { sidebarState } from '@/composables'
</script>

<template>
    <div class="flex items-center justify-between flex-shrink-0 px-3">
        <router-link
            :to="{ name: 'Dashboard' }"
            class="inline-flex items-center gap-2"
        >
            <span class="sr-only">PDEA</span>
            <Logo aria-hidden="true" class="w-10 h-auto" />
        </router-link>

        <Button
            icon-only
            variant="secondary"
            v-slot="{ iconSizeClasses }"
            v-show="sidebarState.isOpen || sidebarState.isHovered"
            @click="sidebarState.isOpen = !sidebarState.isOpen"
            :sr-text="sidebarState.isOpen ? 'Close sidebar' : 'Open sidebar'"
        >
            <Icon
                icon="material-symbols:left-panel-open"
                aria-hidden="true"
                v-show="sidebarState.isOpen"
                :class="['hidden lg:block', iconSizeClasses]"
            />

            <Icon
                icon="material-symbols:left-panel-close"
                aria-hidden="true"
                v-show="!sidebarState.isOpen"
                :class="['hidden lg:block', iconSizeClasses]"
            />

            <Icon
                icon="material-symbols:left-panel-close"
                aria-hidden="true"
                :class="['lg:hidden', iconSizeClasses]"
            />
        </Button>
    </div>
</template>
