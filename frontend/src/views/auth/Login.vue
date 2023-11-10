<script setup>
import { reactive, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import { useAuth } from '@/composables/useAuth';
import { ROLE_ROUTE_MAP } from '@/constants/roleRoutes';
import { errorToast } from '@/toast/index'; // Import your custom toast utility
import PageFooter from '@/components/PageFooter.vue';
import Button from '@/components/Button.vue';
import { Icon } from '@iconify/vue';
import {
    isDark,
    toggleDarkMode,
} from '@/composables';

const router = useRouter();
const store = useStore();
const { login: performLogin, redirectToDashboard } = useAuth(router, store);

const loginForm = reactive({
    email: '',
    password: '',
    remember: false,
    processing: false,
});

const login = async () => {
    loginForm.processing = true;
    try {
        const { role, shouldRemember } = await performLogin(loginForm.email, loginForm.password, loginForm.remember);
        redirectToDashboard(role, ROLE_ROUTE_MAP);
        // If login is successful, you can use successToast here if needed
    } catch (error) {
        // Here we use the custom errorToast utility function
        errorToast({ title: 'Login Error', text: error.message });
    } finally {
        loginForm.processing = false;
    }
};

onMounted(() => {
    // Any logic that needs to happen right after the component mounts
});
</script>


<template>
<section class="gradient-form h-full bg-[#D8D9DA] dark:bg-neutral-700">
    <div class="container p-6">
        <div class="g-6 flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200">
            <div class="w-full">
                <div class="block rounded-lg bg-white shadow-xl dark:bg-neutral-800">
                    <div class="g-0 lg:flex lg:flex-wrap">
                        <!-- Left column container-->
                        <div class="px-4 py-8 md:px-0 md:py-4 sm:py-8 lg:w-6/12 lg:py-0">
                        <div class="md:mx-6 md:p-8">
                            <!--Logo-->
                            <div class="text-center">
                            <img
                                class="mx-auto w-32"
                                img :src="require('@/assets/logo.png')"
                                alt="logo" />
                            <h4 class="mb-10 mt-1 pb-1 text-lg font-semibold">
                                Welcome Back
                            </h4>
                            </div>
                                <form @submit.prevent="login">
                                <div class="mb-6">
                                    <label for="email" class="block mb-2 text-sm font-medium text-black dark:text-white">Your email</label>
                                    <input v-model="loginForm.email" type="email" id="email" class="shadow-md bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-700 focus:border-green-700 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-700 dark:focus:border-green-700 dark:shadow-md-light" placeholder="name@pdea.gov.ph" required>
                                </div>
                                <div class="mb-6">
                                    <label for="password" class="block mb-2 text-sm font-medium text-black dark:text-white">Your password</label>
                                    <input v-model="loginForm.password" type="password" id="password" class="shadow-md bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-700 focus:border-green-700 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-700 dark:focus:border-green-700 dark:shadow-md-light" required
                                     placeholder="Your password">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5 mb-6">
                                            <input v-model="loginForm.remember" id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="remember" class="text-black dark:text-gray-300">Remember me</label>
                                        </div>
                                    </div>
                                    <a href="#" class="text-blue-500 mb-6 text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                                </div>
                                <!-- Login button container -->
                                <div class="flex justify-center mb-4">
                                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded">
                                    Login
                                </button>
                                </div>

                                <!-- Divider with OR text -->
                                <div class="my-4 flex items-center justify-center">
                                <div class="flex-grow border-t border-gray-300"></div>
                                <span class="mx-4 text-gray-600">OR</span>
                                <div class="flex-grow border-t border-gray-300"></div>
                                </div>

                                <!-- Login with Google button container -->
                                <div class="flex justify-center mt-4">
                                <button class="px-4 py-2 border flex items-center gap-2 border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-200 hover:border-slate-400 dark:hover:border-slate-500 hover:text-slate-900 dark:hover:text-slate-300 hover:shadow transition duration-150">
                                    <img class="w-6 h-6" src="https://www.svgrepo.com/show/475656/google-color.svg" loading="lazy" alt="google logo">
                                    <span class="font-bold">Login with Google</span>
                                </button>
                                </div>
                                </form>
                                </div>
                            </div>
                            <!-- Right column container with background and description-->
                            <div
                            class="flex items-center rounded-b-lg lg:w-6/12 lg:rounded-r-lg lg:rounded-bl-none"
                            style="background: linear-gradient(to top, #001a00, #003300, #004d00, #006600)">
                            <div class="px-4 py-6 text-white md:mx-6 md:p-12">  
                                <figure class="max-w-screen-md mx-auto text-center">
                                    <router-link to="/" class="absolute top-12 left-12 flex items-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-800 font-medium rounded-lg text-sm px-2 py-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="mr-2">
                                        <g transform="rotate(-90 12 12)">
                                            <g fill="none">
                                                <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/>
                                                <path fill="currentColor" d="M13.06 3.283a1.5 1.5 0 0 0-2.12 0L5.281 8.939a1.5 1.5 0 0 0 2.122 2.122L10.5 7.965V19.5a1.5 1.5 0 0 0 3 0V7.965l3.096 3.096a1.5 1.5 0 1 0 2.122-2.122L13.06 3.283Z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </router-link>
                                    <Button
                                    iconOnly
                                    variant="secondary"
                                    @click="toggleDarkMode()"
                                    v-slot="{ iconSizeClasses }"
                                    class="md:inline-flex absolute top-0 right-0 mt-12 mr-12"
                                    srText="Toggle dark mode"
                                >
                                <Icon icon="mdi:white-balance-sunny" v-show="!isDark" aria-hidden="true" :class="iconSizeClasses" />
                                <Icon icon="mdi:weather-night" v-show="isDark" aria-hidden="true" :class="iconSizeClasses" />
                                    </Button>
                                    <svg class="w-7 h-7 mx-auto mb-3 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 14">
                                        <path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z"/>
                                    </svg>
                                    <blockquote>
                                        <p class="text-xl italic font-medium text-white dark:text-white">
                                            "PDEA MIMAROPA Region IV-B is dedicated to ensuring 
                                            a drug-free MIMAROPA through rigorous enforcement 
                                            and prevention efforts in the region"</p>
                                    </blockquote>
                                    <figcaption class="flex items-center justify-center mt-6 space-x-3">
                                    </figcaption>
                                </figure>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <PageFooter />
            </div>
        </div>
</section>
</template>
