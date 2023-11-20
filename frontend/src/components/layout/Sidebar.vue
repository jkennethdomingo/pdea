<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useStore } from 'vuex'
import { sidebarState } from '@/composables'
import SidebarHeader from '@/components/sidebar/SidebarHeader.vue'
import HR_SidebarContent from '@/components/sidebar/HR_SidebarContent.vue'
import LG_SidebarContent from '@/components/sidebar/LG_SidebarContent.vue'
import SidebarFooter from '@/components/sidebar/SidebarFooter.vue'

const store = useStore()

// Reactive reference for userRole
const userRole = ref(null)

const sidebarComponent = computed(() => {
  switch (userRole.value) {
    case 'HR_ADMIN':
      return HR_SidebarContent;
    case 'LOGISTICS_ADMIN':
      return LG_SidebarContent;
    default:
      return null;
  }
});


// Lifecycle hook for onMounted
onMounted(() => {
  window.addEventListener('resize', sidebarState.handleWindowResize)

  // Load the user's role from the Vuex store
  userRole.value = store.state.userRole
})

// Lifecycle hook for onUnmounted
onUnmounted(() => {
  window.removeEventListener('resize', sidebarState.handleWindowResize)
})
</script>


<template>
    <transition
        enter-active-class="transition"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-show="sidebarState.isOpen"
            @click="sidebarState.isOpen = false"
            class="fixed inset-0 z-20 bg-black/50 lg:hidden"
        ></div>
    </transition>

    <aside
        style="
            transition-property: width, transform;
            transition-duration: 150ms;
        "
        :class="[
            'fixed inset-y-0 z-20 py-4 flex flex-col space-y-6 bg-[#DDE6ED] shadow-2xl dark:bg-dark-eval-1',
            {
                'translate-x-0 w-64':
                    sidebarState.isOpen || sidebarState.isHovered,
                '-translate-x-full w-64 md:w-16 md:translate-x-0':
                    !sidebarState.isOpen && !sidebarState.isHovered,
            },
        ]"
        @mouseenter="sidebarState.handleHover(true)"
        @mouseleave="sidebarState.handleHover(false)"
    >
        <SidebarHeader />
        <component :is="sidebarComponent" sidebar-type="sidebarType" />
        <SidebarFooter />
    </aside>
</template>
