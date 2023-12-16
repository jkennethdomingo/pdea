<script setup>
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { usePhotoUrl } from '@/composables/usePhotoUrl'; // Adjust the path based on your file structure
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

const provinceData = computed(() => store.state.provinceData);

onMounted(() => {
  store.dispatch('fetchprovinceData');
});
</script>

<template>
<section class="flex flex-col min-h-full w-full p-1 rounded-lg bg-white dark:bg-gray-900">
    <!-- component -->
        <div class="container m-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 gap-y-6">
                <!-- profile cards -->
                <div class="flex flex-col" v-for="province in provinceData">
                    <div class="bg-gray-300 dark:bg-gray-800 border border-gray-800 shadow-lg rounded-2xl max-w-sm p-4">
                        <div class="flex-none sm:flex">
                            <div class="relative h-32 w-36 sm:mb-0 mb-3">
                                <template v-if="province.province_name === null">
                                    <!-- Render image if agent.photo is not null -->
                                    <img alt="Profile Picture not found" class="w-32 h-32 object-cover rounded-2xl">
                                </template>
                                <template v-else>
                                    <!-- Render default icon if agent.Photo is null -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 16 16"><path fill="currentColor" d="M0 16h8V0H0zM5 2h2v2H5zm0 4h2v2H5zm0 4h2v2H5zM1 2h2v2H1zm0 4h2v2H1zm0 4h2v2H1zm8-5h7v1H9zm0 11h2v-4h3v4h2V7H9z"/></svg>
                                </template>
                            </div>
                            <div class="flex-auto sm:ml-5 mt-8 justify-evenly">
                                <div class="flex items-center justify-between sm:mt-2">
                                    <div class="flex items-center">
                                        <div class="flex flex-col">
                                            <!-- Display name and position -->
                                                <div class="text-xl dark:text-gray-200 text-gray-800 font-bold leading-none">{{ province.location }}</div>
                                            <div class="text-gray-700 dark:text-gray-400 my-1">
                                                <!-- Display Employee ID -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex pt-2 text-sm text-gray-400">
                                    <!-- Buttons can be updated or used as is -->
                                    <button
                                        @click="openViewModal"
                                        class="bg-green-600 hover:bg-green-700 mr-1 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300"
                                    >
                                        View
                                    </button>

                                    <!--TODO View Modal -->
                                    <TransitionRoot as="template" :show="isViewModalOpen">
                                        <Dialog as="div" class="relative z-10" @close="closeViewModal">
                                            <TransitionChild
                                            as="template"
                                            enter="duration-50 ease-out"
                                            enter-from="opacity-0"
                                            enter-to="opacity-100"
                                            leave="duration-100 ease-in"
                                            leave-from="opacity-100"
                                            leave-to="opacity-0"
                                            >
                                <div class="fixed inset-0 bg-black/5" aria-hidden="true"></div>
                                </TransitionChild>
                                        <div class="fixed inset-0 overflow-y-auto">
                                            <div class="flex min-h-full items-center justify-center p-4 text-center">
                                            <TransitionChild
                                            as="template"
                                            enter="duration-50 ease-out"
                                            enter-from="opacity-0 scale-95"
                                            enter-to="opacity-100 scale-100"
                                            leave="duration-100 ease-in"
                                            leave-from="opacity-100 scale-100"
                                            leave-to="opacity-0 scale-95"
                                            >
                                                <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-[#DDE6ED] dark:bg-gray-600 p-6 text-left align-middle transition-all">
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
                                    class="bg-green-600 hover:bg-green-700 px-3 py-1 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300"
                                >
                                    Assign
                                </button>

                                <!-- TODO Assign Modal -->
                                <TransitionRoot as="template" :show="isOpen">
                                    <Dialog as="div" class="relative z-10" @close="closeModal">
                                        <TransitionChild
                                            as="template"
                                            enter="duration-50 ease-out"
                                            enter-from="opacity-0"
                                            enter-to="opacity-100"
                                            leave="duration-100 ease-in"
                                            leave-from="opacity-100"
                                            leave-to="opacity-0"
                                            >
                                <div class="fixed inset-0 bg-black/5" aria-hidden="true"></div>
                                </TransitionChild>
                                    <div class="fixed inset-0 overflow-y-auto">
                                        <div class="flex min-h-full items-center justify-center p-4 text-center">
                                        <TransitionChild
                                            as="template"
                                            enter="duration-50 ease-out"
                                            enter-from="opacity-0 scale-95"
                                            enter-to="opacity-100 scale-100"
                                            leave="duration-100 ease-in"
                                            leave-from="opacity-100 scale-100"
                                            leave-to="opacity-0 scale-95"
                                        >
                                            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-[#DDE6ED] dark:bg-gray-600 p-6 text-left align-middle transition-all">
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-green-800 dark:text-green-200">
                                                Payment successful
                                            </DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                                Assigning
                                                </p>
                                            </div>
                                            <div class="mt-4 flex justify-between">
                                            <div>
                                                <button
                                                    type="button"
                                                    class="inline-flex justify-center rounded-md border border-transparent bg-green-600 hover:bg-green-800 px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                                    @click="closeModal"
                                                >
                                                    Assign
                                                </button>
                                            </div>
                                            <div>
                                                <button
                                                    type="button"
                                                    class="inline-flex justify-center rounded-md border border-transparent bg-green-600 hover:bg-green-800 px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                                    @click="closeViewModal"
                                                >
                                                    Close
                                                </button>
                                            </div>
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
