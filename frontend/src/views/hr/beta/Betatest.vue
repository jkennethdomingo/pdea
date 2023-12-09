<template>
     <!-- TabGroup Component -->
     <div class="max-w-xs px-2 py-0 sm:px-0">
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
                      'ring-white/60 ring-offset-2 ring-offset-black focus:outline-none focus:ring-2',
                      selected
                          ? 'bg-green-600 dark:bg-green-600 text-white dark:text-white shadow'
                          : 'text-gray-600 dark:text-gray-200 hover:bg-white/[0.12] hover:text-green-500',
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
    class="rounded-xl bg-white dark:bg-dark-bg p-2 border-2 border-gray-200 dark:border-gray-700"
  >
    <div v-if="isLoading && category === 'Pending'">
      Loading...
    </div>
    <ul v-else class="max-h-40 overflow-y-auto">
      <li
        v-for="post in posts"
        :key="post.id"
        class="rounded-md p-2 hover:bg-gray-300 dark:hover:bg-green-500"
      >
        <h3 class="text-sm font-medium leading-5">
          {{ post.title }}
        </h3>
        <ul class="mt-1 flex space-x-1 text-xs font-normal leading-4 text:gray-700 dark:text-gray-300">
          <li>{{ post.date }}</li>
        </ul>
        <!-- Conditionally render Approval and Denial Buttons -->
        <div 
          class="flex justify-end space-x-2 mt-2" 
          v-if="category === 'Pending'"
        >

      <button
        type="button"
        @click="approveRequest(post.id)"
        class="text-white bg-green-600 hover:bg-green-800 rounded-lg text-xs px-4 py-1"
      >
        View
      </button>

      <TransitionRoot appear :show="isOpen" as="template">
  <Dialog as="div" @close="closeModal" class="relative z-10">
    <TransitionChild
      as="template"
      enter="duration-300 ease-out"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <div class="fixed inset-0 bg-black/25" />
    </TransitionChild>

    <div class="fixed inset-0 overflow-y-auto">
      <div class="flex min-h-full items-center justify-center p-4 text-center">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-[#DDE6ED] dark:bg-gray-600 p-6 text-left align-middle shadow-xl transition-all">
            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-green-800 dark:text-green-200">
              {{ selectedLeaveRequest.EmployeeName }} requesting a leave
            </DialogTitle>
            <div class="mt-2">
              <p class="text-sm text-gray-800 dark:text-gray-200">
                Reason for leave: {{ selectedLeaveRequest.Reason }}
                <!-- Include other relevant details here -->
              </p>
            </div>

            <div class="mt-4">
              <button
                type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-green-600 hover:bg-green-800 px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                @click="approveAndCloseModal(selectedLeaveRequest.id)"
              >
                Approve
              </button>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </div>
  </Dialog>
</TransitionRoot>



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
    </div>
  </template>
 <script setup>
 import { ref, computed, onMounted, watch } from 'vue';
 import { initFlowbite } from 'flowbite';
 import { useStore } from 'vuex';
 import Button from '@/components/base/Button';
 import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
 
 
   import {
     TransitionRoot,
     TransitionChild,
     Dialog,
     DialogPanel,
     DialogTitle,
   } from '@headlessui/vue'
   
   const isOpen = ref(false)
   
   function closeModal() {
     isOpen.value = false
   }
 
 
 const store = useStore();
 const isLoading = ref(true); 
 const selectedLeaveRequest = ref({});
 
 
 onMounted(async () => {
   initFlowbite();
   isLoading.value = true; // Start loading
   await store.dispatch('fetchLeaveRequests');
   setTimeout(() => {
     isLoading.value = false; // Stop loading after a delay
   }, 2000);
 });
 
 
 const categories = computed(() => ({
   Pending: isLoading.value ? [] : store.state.leaveRequests.pending.map(request => ({
     id: request.LeaveID,
     title: `${request.EmployeeName} requesting a leave`,
     date: request.TimeRequested // Format this date as needed
   })),
   Approved: store.state.leaveRequests.approved.map(request => ({
     id: request.LeaveID,
     title: `${request.EmployeeName}'s leave request approved`,
     date: request.TimeRequested // Format this date as needed
   })),
   Rejected: store.state.leaveRequests.rejected.map(request => ({
     id: request.LeaveID,
     title: `${request.EmployeeName}'s leave request rejected`,
     date: request.TimeRequested // Format this date as needed
   })),
 }));
 
 // Method to approve a leave request
 const approveRequest = async (id) => {
  try {
    const leaveRequest = store.state.leaveRequests.pending.find(request => request.LeaveID === id);
    if (leaveRequest) {
      selectedLeaveRequest.value = leaveRequest;
      // Then dispatch your Vuex action
      await store.dispatch('approveLeaveRequest', id);
      isOpen.value = true;
    }
  } catch (error) {
    console.error('Error approving leave request:', error);
  }
};

 
 // Method to deny a leave request
 const denyRequest = async (id) => {
   // Implement the denial logic, possibly dispatching a Vuex action
   console.log('Deny Request ID:', id);
 };
 
 
 </script>