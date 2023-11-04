<script setup>
import { onMounted, onUnmounted } from 'vue'
import { useFullscreen } from '@vueuse/core'
import { Icon } from '@iconify/vue'
import {
    handleScroll,
    isDark,
    scrolling,
    toggleDarkMode,
    sidebarState,
} from '@/composables'
import Button from '@/components/Button.vue'
import Logo from '@/components/Logo.vue'
import Dropdown from '@/components/Dropdown.vue'
import DropdownLink from '@/components/DropdownLink.vue'
import DropdownButton from '@/components/DropdownButton.vue'
import userAvatar from '@/assets/images/avatar.jpg'
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import { computed } from 'vue';

const store = useStore();
const router = useRouter();

store.dispatch('initializeAuth');
const authState = computed(() => ({
  token: store.state.token,
  role: store.state.userRole
}));

const spanClasses = computed(() => ({
  'rounded-md': true,
  'text-xl': true,
  'font-bold': true,
  'bg-white': authState.value.role !== 'HR_ADMIN',
  'dark:bg-dark-eval-2': authState.value.role === 'HR_ADMIN',
  'px-2': true,
  'py-2': true
}));

const roleDisplayName = computed(() => {
  switch (authState.value.role) {
    case 'HR_ADMIN':
      return 'Human Resource';
    case 'LOGISTICS_ADMIN':
      return 'Logistics';
    // You can add more cases as necessary
    default:
      return 'Unauthorized User';
  }
});

const logout = () => {
  // Clear user's auth token from Vuex store and localStorage
  store.commit('clearAuth');
  localStorage.removeItem('authData');
  sessionStorage.removeItem('authData');

  // Redirect to the login page
  router.push({ name: 'Login' });
};

const { isFullscreen, toggle: toggleFullScreen } = useFullscreen()

onMounted(() => {
    document.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    document.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <nav
        aria-label="secondary"
        :class="[
            ' sticky top-0 z-10 px-6 py-4 flex items-center justify-between transition-transform duration-500',
            {
                '-translate-y-full': scrolling.down,
                'translate-y-0': scrolling.up,
            },
        ]"
    >
    <div class="flex items-center">
            <!-- Dark Mode Toggle for Mobile -->
            <Button
                icon-only
                variant="secondary"
                @click="toggleDarkMode()"
                v-slot="{ iconSizeClasses }"
                class="md:hidden"
                srText="Toggle dark mode"
            >
                <Icon icon="mdi:weather-night" v-show="!isDark" aria-hidden="true" :class="iconSizeClasses" />
                <Icon icon="mdi:white-balance-sunny" v-show="isDark" aria-hidden="true" :class="iconSizeClasses" />
            </Button>

            <!-- Human Resource Label -->
            <span :class="spanClasses">{{ roleDisplayName }}</span>
        </div>

        <div class="flex items-center gap-2">

             <!-- Notif -->
             <Button
                iconOnly
                variant="secondary"
                @click=""
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                srText="Toggle dark mode"
            >
                <Icon
                    icon="mingcute:notification-fill"
                    v-show="!isFullscreen"
                    aria-hidden="true"
                    :class="iconSizeClasses"
                />
                <Icon icon="mdi:arrow-collapse-all" v-show="isFullscreen" aria-hidden="true" :class="iconSizeClasses" />
            </Button>
            <Button
                iconOnly
                variant="secondary"
                @click="toggleDarkMode()"
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                srText="Toggle dark mode"
            >
                <Icon icon="mdi:weather-night" v-show="!isDark" aria-hidden="true" :class="iconSizeClasses" />
                <Icon icon="mdi:white-balance-sunny" v-show="isDark" aria-hidden="true" :class="iconSizeClasses" />
            </Button>

            <Button
                iconOnly
                variant="secondary"
                @click="toggleFullScreen"
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                srText="Toggle dark mode"
            >
                <Icon
                    icon="mdi:arrow-expand-all"
                    v-show="!isFullscreen"
                    aria-hidden="true"
                    :class="iconSizeClasses"
                />
                <Icon icon="mdi:arrow-collapse-all" v-show="isFullscreen" aria-hidden="true" :class="iconSizeClasses" />
            </Button>
            

            <!-- Dropdwon -->
            <Dropdown align="right" width="48">
                <template #trigger>
                    <button
                        class="flex text-sm transition border-2 border-transparent rounded-md focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1"
                    >
                        <img
                            class="object-cover w-8 h-8 rounded-md"
                            :src="userAvatar"
                            alt="User Name"
                        />
                    </button>
                </template>
                <template #content>
                    <DropdownButton @click="logout">Log Out</DropdownButton>
                    <DropdownLink to="#">Settings</DropdownLink>
                </template>
            </Dropdown>
        </div>
    </nav>
    

    <!-- Mobile bottom bar -->
    <div
        :class="[
            'fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1',
            {
                'translate-y-full': scrolling.down,
                'translate-y-0': scrolling.up,
            },
        ]"
    >
        <Button icon="mdi:magnify" iconOnly variant="secondary" srText="Search" />

        <router-link :to="{ name: 'Dashboard' }">
            <Logo class="w-10 h-10" />
            <span class="sr-only"></span>
        </router-link>

        <Button
            iconOnly
            variant="secondary"
            @click="sidebarState.isOpen = !sidebarState.isOpen"
            v-slot="{ iconSizeClasses }"
            class="md:hidden"
            srText="toggle menu"
        >
            <Icon icon="mdi:menu" v-show="!sidebarState.isOpen" aria-hidden="true" :class="iconSizeClasses" />
            <Icon icon="mdi:window-close" v-show="sidebarState.isOpen" aria-hidden="true" :class="iconSizeClasses" />
        </Button>
    </div>
</template>
