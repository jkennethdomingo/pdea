<script setup>
import { onMounted, onUnmounted, ref } from 'vue'
import { useFullscreen } from '@vueuse/core'
import { Icon } from '@iconify/vue'
import {
    handleScroll,
    isDark,
    scrolling,
    toggleDarkMode,
    sidebarState,
} from '@/composables'
import Button from '@/components/base/Button.vue'
import Logo from '@/components/base/Logo.vue'
import Dropdown from '@/components/base/Dropdown.vue'
import DropdownLink from '@/components/base/DropdownLink.vue'
import DropdownButton from '@/components/base/DropdownButton.vue'
import userAvatar from '@/assets/images/avatar.jpg'
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import { computed } from 'vue';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

const categories = ref({
  all: [
    {
      id: 1,
      title: 'John Smith requesting a leave',
      date: '5h ago',

    },
    {
      id: 2,
      title: "Samantha Doe requesting a leave",
      date: '2h ago',
    },
    {
      id: 3,
      title: "Samantha Doe requesting a leave",
      date: '2h ago',
    },
    {
      id: 4,
      title: "Samantha Doe requesting a leave",
      date: '2h ago',
    },
    {
      id: 5,
      title: "Samantha Doe requesting a leave",
      date: '2h ago',
    },
  ],
  unread: [
    {
      id: 1,
      title: '',
      date: '',
    },
    {
      id: 2,
      title: '',
      date: '',
    },
  ],
})

const store = useStore();
const router = useRouter();

store.dispatch('initializeAuth');
const authState = computed(() => ({
  token: store.state.token,
  role: store.state.userRole
}));

const roleDisplayName = computed(() => {
  switch (authState.value.role) {
    case 'HR_ADMIN':
      return 'Human Resource';
    case 'LOGISTICS_ADMIN':
      return 'Logistics';
    case 'NON_ADMIN':
        return 'Employee';
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
            'top-0 z-10 px-6 py-4 flex items-center justify-between transition-transform duration-500',
        ]"
    >
            <!-- Dark Mode Toggle for Mobile -->
            <Button
                icon-only
                variant="secondary"
                @click="toggleDarkMode()"
                v-slot="{ iconSizeClasses }"
                class="flex md:hidden"
                srText="Toggle dark mode"
            >
                <Icon icon="mdi:weather-night" v-show="!isDark" aria-hidden="true" :class="iconSizeClasses" />
                <Icon icon="mdi:white-balance-sunny" v-show="isDark" aria-hidden="true" :class="iconSizeClasses" />
            </Button>

            <!-- Human Resource Label -->
            <span class="rounded-md text-xl font-bold bg-white dark:bg-dark-eval-2 px-2 py-2">{{ roleDisplayName }}</span>


        <div class="flex items-center gap-2">

             <!-- Notif -->
             <Dropdown align="right" width="48">
                <template #trigger>
                    <div
                        class="absolute bottom-auto left-auto right-0 top-0 z-10 inline-block -translate-y-1/2 translate-x-2/4 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 whitespace-nowrap rounded-full bg-green-700 px-2.5 py-1 text-center align-baseline text-xs font-bold leading-none text-white">
                        99+
                    </div>
                    <Button
                        iconOnly
                        variant="secondary"
                        @click="toggleDropdown"
                        v-slot="{ iconSizeClasses }"
                        class="hidden md:inline-flex"
                        srText="Notifications"
                    >
                        <Icon
                            icon="mingcute:notification-fill"
                            v-show="!isFullscreen"
                            aria-hidden="true"
                            :class="iconSizeClasses"
                        />
                        <Icon icon="mdi:arrow-collapse-all" v-show="isFullscreen" aria-hidden="true" :class="iconSizeClasses" />
                    </Button>
                </template>

                <template #content>
                    <TabGroup>
                            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
                            <Tab
                                v-for="category in Object.keys(categories)"
                                as="template"
                                :key="category"
                                v-slot="{ selected }"
                            >
                                <button
                                    :class="[
                                        'w-full rounded-lg py-1 text-sm font-medium leading-5', 
                                        'ring-gray-800 ring-offset-black focus:outline-none focus:ring-2',
                                        selected
                                            ? 'bg-green-600 dark:bg-green-600 text-white dark:text-white shadow'
                                            : 'text-gray-800 dark:text-gray-100 hover:bg-green-400 hover:text-white',
                                    ]"
                                >
                                    {{ category }}
                                </button>
                            </Tab>
                            </TabList>
                            <TabPanels class="mt-2">
                    <TabPanel
                        v-for="(posts, category) in categories"
                        :key="category"
                        :class="posts.length > 2 ? 'max-h-56 overflow-y-auto' : ''"
                        class="rounded-b-lg  bg-white dark:bg-dark-bg p-2 border-2 border-gray-400 dark:border-gray-700"
                    >
                        <ul>
                            <li
                                v-for="post in posts"
                                :key="post.id"
                                class="rounded-md p-2 hover:bg-gray-100 dark:hover:bg-green-500"
                            >
                                <h3 class="text-sm font-medium leading-5">
                                    {{ post.title }}
                                </h3>
                                <ul class="mt-1 flex space-x-1 text-xs font-normal leading-4 text-gray-500">
                                    <li>{{ post.date }}</li>
                                </ul>
                                <!-- Conditionally render Approval and Denial Buttons -->
                                <div 
                                    class="flex justify-end space-x-2 mt-2" 
                                    v-if="category === 'all'"
                                >
                                    <button
                                        @click="approveRequest(post.id)"
                                        class="text-white bg-green-600 hover:bg-green-700 rounded-lg text-xs px-4 py-1"
                                    >
                                        Approve
                                    </button>
                                    <button
                                        @click="denyRequest(post.id)"
                                        class="text-white bg-red-600 hover:bg-red-700 rounded-lg text-xs px-4 py-1"
                                    >
                                        Deny
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </TabPanel>
                    </TabPanels>
                        </TabGroup>
                </template>

            </Dropdown>
            
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
                        class="flex text-sm transition border-2 border-transparent rounded-md focus:outline-none focus:ring focus:ring-gray-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1"
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
            'fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-[#EEF5FF] md:hidden dark:bg-dark-eval-1',
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
