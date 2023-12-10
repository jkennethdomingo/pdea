<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { usePhotoUrl } from '@/composables/usePhotoUrl'; // Adjust the path based on your file structure
import { ref } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

const isOpen = ref(false) // Start with the modal closed

function closeModal() {
  isOpen.value = false
}
function openModal() {
  isOpen.value = true
}

const isViewModalOpen = ref(false)

function closeViewModal() {
  isViewModalOpen.value = false
}

function openViewModal() {
  isViewModalOpen.value = true
}

const store = useStore();
const { getPhotoUrl } = usePhotoUrl(); // Using the composable

const agentData = computed(() => store.state.agentData);

onMounted(() => {
  store.dispatch('fetchagentData');
});
</script>

<template>
<section class="flex flex-col min-h-3/6 w-full p-1 rounded-lg bg-white dark:bg-gray-900">
    <!-- component -->
        <div class="container m-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 gap-y-6">
                <!-- profile cards -->
                <div class="flex flex-col" v-for="agent in agentData" :key="agent.EmployeeID">
                    <div class="bg-gray-300 dark:bg-gray-800 border border-gray-800 shadow-lg rounded-2xl max-w-sm p-4">
                        <div class="flex-none sm:flex">
                            <div class="relative h-32 w-36 sm:mb-0 mb-3">
                                <!-- Conditional rendering based on agent.Photo -->
                                <template v-if="agent.photo">
                                    <!-- Render image if agent.photo is not null -->
                                    <img :src="getPhotoUrl(agent.photo)" alt="Profile Picture not found" class="w-32 h-32 object-cover rounded-2xl">
                                </template>
                                <template v-else>
                                    <!-- Render default icon if agent.Photo is null -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.96 11.947A4.99 4.99 0 0 1 9 14h6a4.99 4.99 0 0 1 3.96 1.947A8 8 0 0 0 12 4Zm7.943 14.076A9.959 9.959 0 0 0 22 12c0-5.523-4.477-10-10-10S2 6.477 2 12a9.958 9.958 0 0 0 2.057 6.076l-.005.018l.355.413A9.98 9.98 0 0 0 12 22a9.947 9.947 0 0 0 5.675-1.765a10.055 10.055 0 0 0 1.918-1.728l.355-.413l-.005-.018ZM12 6a3 3 0 1 0 0 6a3 3 0 0 0 0-6Z" clip-rule="evenodd"/></svg>
                                </template>
                            </div>
                            <div class="flex-auto sm:ml-5 mt-8 justify-evenly">
                                <div class="flex items-center justify-between sm:mt-2">
                                    <div class="flex items-center">
                                        <div class="flex flex-col">
                                            <!-- Display name and position -->
                                            <div class="text-xl text-gray-200 font-bold leading-none">{{ agent.first_name }} {{ agent.surname }}</div>
                                            <div class="text-gray-400 my-1">
                                                <!-- Display Employee ID -->
                                                <span class="mr-1">{{ agent.PositionName }} {{ agent.EmployeeID }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex pt-2 text-sm text-gray-400">
                                    <!-- Buttons can be updated or used as is -->
                                   <!-- View button -->
                                    <button
                                        @click="openViewModal"
                                        class="bg-green-400 hover:bg-green-500 mr-1 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300"
                                    >
                                        View
                                    </button>

                                    <!-- View Modal -->
                                    <TransitionRoot as="template" :show="isViewModalOpen">
                                        <Dialog as="div" class="relative z-10" @close="closeViewModal">
                                            <TransitionChild
                                            as="template"
                                            enter="ease-out duration-300"
                                            enter-from="opacity-0"
                                            enter-to="opacity-100"
                                            leave="ease-in duration-200"
                                            leave-from="opacity-100"
                                            leave-to="opacity-0"
                                            >
                                <div class="fixed inset-0 bg-black/5" aria-hidden="true"></div>
                                </TransitionChild>
                                        <div class="fixed inset-0 overflow-y-auto">
                                            <div class="flex min-h-full items-center justify-center p-4 text-center">
                                            <TransitionChild
                                                as="template"
                                                enter="ease-out duration-300"
                                                enter-from="opacity-0 scale-95"
                                                enter-to="opacity-100 scale-100"
                                                leave="ease-in duration-200"
                                                leave-from="opacity-100 scale-100"
                                                leave-to="opacity-0 scale-95"
                                            >
                                                <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-[#DDE6ED] dark:bg-gray-600 p-6 text-left align-middle shadow-xl transition-all">
                                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-green-800 dark:text-green-200">
                                                    View Details
                                                </DialogTitle>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-800 dark:text-gray-200">
                                                    Details about the item...
                                                    </p>
                                                </div>
                                                <div class="mt-4">
                                                    <button
                                                    type="button"
                                                    class="inline-flex justify-center rounded-md border border-transparent bg-green-600 hover:bg-green-800 px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                                    @click="closeViewModal"
                                                    >
                                                    Close
                                                    </button>
                                                </div>
                                                </DialogPanel>
                                            </TransitionChild>
                                            </div>
                                        </div>
                                        </Dialog>
                                    </TransitionRoot>

                                    <!-- Assign button -->
                                <button
                                    @click="openModal"
                                    class="bg-green-400 hover:bg-green-500 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300"
                                >
                                    Assign
                                </button>

                                <!-- Modal -->
                                <TransitionRoot as="template" :show="isOpen">
                                    <Dialog as="div" class="relative z-10" @close="closeModal">
                                        <TransitionChild
                                            as="template"
                                            enter="ease-out duration-300"
                                            enter-from="opacity-0"
                                            enter-to="opacity-100"
                                            leave="ease-in duration-200"
                                            leave-from="opacity-100"
                                            leave-to="opacity-0"
                                            >
                                <div class="fixed inset-0 bg-black/5" aria-hidden="true"></div>
                                </TransitionChild>
                                    <div class="fixed inset-0 overflow-y-auto">
                                        <div class="flex min-h-full items-center justify-center p-4 text-center">
                                        <TransitionChild
                                            as="template"
                                            enter="ease-out duration-300"
                                            enter-from="opacity-0 scale-95"
                                            enter-to="opacity-100 scale-100"
                                            leave="ease-in duration-200"
                                            leave-from="opacity-100 scale-100"
                                            leave-to="opacity-0 scale-95"
                                        >
                                            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-[#DDE6ED] dark:bg-gray-600 p-6 text-left align-middle shadow-xl transition-all">
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                Payment successful
                                            </DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                                Your payment has been successfully submitted. We’ve sent you an email with all of the details of your order.
                                                </p>
                                            </div>
                                            <div class="mt-4">
                                                <button
                                                type="button"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-green-600 hover:bg-green-800 px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                                @click="closeModal"
                                                >
                                                Assign
                                                </button>
                                            </div>
                                            </DialogPanel>
                                        </TransitionChild>
                                        </div>
                                    </div>
                                    </Dialog>
                                </TransitionRoot>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
</template>
