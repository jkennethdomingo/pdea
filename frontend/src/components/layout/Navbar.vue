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
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import { computed } from 'vue';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import apiService from '@/composables/axios-setup';
import { defaultAvatar } from '@/assets/images/defaultAvatar.js';
import { usePhotoUrl } from '@/composables/usePhotoUrl';


const store = useStore();
const router = useRouter();
const { getPhotoUrl } = usePhotoUrl(); 

const authState = computed(() => ({
  token: store.state.token,
  role: store.state.userRole,
  employeeID: store.state.employeeID
}));

const userAvatar = ref(null);

function formatTimeRequested(timeRequested) {
  const now = new Date();
  const requestedTime = new Date(timeRequested);

  // Adjust for the 8-hour delay
  requestedTime.setHours(requestedTime.getHours() + 8);

  const diffTime = Math.abs(now - requestedTime);
  const diffSeconds = Math.floor(diffTime / 1000);
  const diffMinutes = Math.floor(diffSeconds / 60);
  const diffHours = Math.floor(diffMinutes / 60);
  const diffDays = Math.floor(diffHours / 24);

  let timeString = "";

  if (diffDays > 0) timeString = diffDays > 1 ? `${diffDays} days ago` : "a day ago";
  else if (diffHours > 0) timeString = diffHours > 1 ? `${diffHours} hours ago` : "an hour ago";
  else if (diffMinutes > 0) timeString = diffMinutes > 1 ? `${diffMinutes} minutes ago` : "a minute ago";
  else timeString = "just now"; // Replaces previous condition for seconds

  return timeString;
}


const categories = computed(() => {
  const leaveRequests = store.state.leaveRequestsNotification;

  // Function to format leave requests
  const formatRequests = (requests) => {
    return requests.map(request => ({
      id: request.LeaveID,
      title: `${request.EmployeeName} requesting a ${request.LeaveTypeName}`,
      date: `Requested: ${formatTimeRequested(request.TimeRequested)}`
    }));
  };

  switch (authState.value.role) {
    case 'HR_ADMIN':
      // Logic for HR_ADMIN notifications
      // Assuming HR_ADMIN should see all leave requests
      return {
        all: formatRequests(leaveRequests),
        // You can add more specific categories for HR_ADMIN here
      };

    case 'NON_ADMIN':
      // Logic for NON_ADMIN notifications - Currently leaving blank
      return {};

    default:
      // Default notifications for other roles - Also currently blank
      return {};
  }
});

const notificationCount = computed(() => {
  switch (authState.value.role) {
    case 'HR_ADMIN':
      // For HR_ADMIN, count all notifications
      return categories.value.all ? categories.value.all.length : 0;

    case 'NON_ADMIN':
      // For NON_ADMIN, count specific notifications if any
      // Example: count 'myRequests' notifications
      return 0;

    default:
      // Default case for other roles
      // Currently, there are no notifications for other roles
      return 0;
  }
});



const fetchEmployeePhoto = async () => {
    const employeeID = authState.value.employeeID; // Get employeeID from authState
    console.log(employeeID);

    try {
        const response = await apiService.get(`/auth/getEmployeePhoto/${employeeID}`);
            
        // Correctly assigning the photo to userAvatar ref
        userAvatar.value = response.data.photo; 
            
    } catch (error) {
        console.error('Error fetching employee photo:', error);
    }
};


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
  localStorage.removeItem('authToken');
sessionStorage.removeItem('authToken');
localStorage.removeItem('authExpiration');
sessionStorage.removeItem('authExpiration');
localStorage.removeItem('authIssuedAt');
sessionStorage.removeItem('authIssuedAt');

  // Redirect to the login page
  router.push({ name: 'Login' });
};

const { isFullscreen, toggle: toggleFullScreen } = useFullscreen()

const pollNotifications = async () => {
  try {
    await store.dispatch('fetchLeaveRequestsNotification');
    // Set a timeout for the next poll, e.g., 30 seconds
    setTimeout(pollNotifications, 30000);
  } catch (error) {
    console.error('Error during notification polling:', error);
  }
};

onMounted(() => {
    document.addEventListener('scroll', handleScroll)
    fetchEmployeePhoto();
    if (authState.value.role === 'HR_ADMIN') {
    pollNotifications();
  }
})


onUnmounted(() => {
    document.removeEventListener('scroll', handleScroll)
})

console.log(notificationCount.value)
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
                    <div v-if="notificationCount > 0"
                        class="absolute bottom-auto left-auto right-0 top-0 z-10 inline-block -translate-y-1/2 translate-x-2/4 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 whitespace-nowrap rounded-full bg-green-700 px-2.5 py-1 text-center align-baseline text-xs font-bold leading-none text-white">
                        {{ notificationCount > 99 ? '99+' : notificationCount }}
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
                        <Icon icon="mingcute:notification-fill" v-show="isFullscreen" aria-hidden="true" :class="iconSizeClasses" />
                    </Button>
                </template>

                <template #content>
                    <TabGroup>
  <div v-if="notificationCount > 0">
    <ul class="mt-2 rounded-b-lg bg-white dark:bg-dark-bg p-2 border-2 border-gray-400 dark:border-gray-700">
      <li
        v-for="post in categories.all"  
        :key="post.id"
        class="rounded-md p-2 hover:bg-gray-100 dark:hover:bg-green-500"
      >
        <h3 class="text-sm font-medium leading-5">
          {{ post.title }}
        </h3>
        <ul class="mt-1 flex space-x-1 text-xs font-normal leading-4 text-gray-500">
          <li>{{ post.date }}</li>
        </ul>
        <div 
          class="flex justify-end space-x-2 mt-2"
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
  </div>
  <div v-else class="text-center text-sm text-gray-500 py-4">
    No unread notifications
  </div>
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
                    <img v-if="userAvatar" class="object-cover w-8 h-8 rounded-md" :src="getPhotoUrl(userAvatar)" alt="User Name" />
                    <div v-else v-html="defaultAvatar"></div>
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
