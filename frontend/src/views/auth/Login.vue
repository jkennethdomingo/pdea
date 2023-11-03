<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';
import InputIconWrapper from '@/components/InputIconWrapper.vue';
import Label from '@/components/Label.vue';
import Input from '@/components/Input.vue';
import Checkbox from '@/components/Checkbox.vue';
import Button from '@/components/Button.vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { jwtDecode } from 'jwt-decode';
import { useToast } from 'vue-toastification'; // Import the hook

const router = useRouter();
const store = useStore();
const toast = useToast(); // Use the hook

const loginForm = reactive({
    email: '',
    password: '',
    remember: false,
    processing: false,
    // Removed errorMessage since we're using toasts now
});

const login = async () => {
    loginForm.processing = true;

    try {
        const response = await axios.post('/login', {
            email: loginForm.email,
            password: loginForm.password
        });

        if (response.data.token) {
            const decodedToken = jwtDecode(response.data.token);
            store.commit('setAuth', { token: response.data.token, role: decodedToken.role });
            router.push({ name: 'Dashboard' });
        }
    } catch (error) {
        // Handle errors using toast
        const message = error.response?.data?.message || 'An error occurred during login.';
        toast.error(message);
    } finally {
        loginForm.processing = false;
    }
};
</script>



<template>
    <form @submit.prevent="login">
        <div class="grid gap-6">
            <!-- Email input -->
            <div class="space-y-2">
                <Label for="email" value="Email" />

                <InputIconWrapper icon="mdi:email-outline">
                    <Input
                        withIcon
                        id="email"
                        type="email"
                        class="block w-full"
                        placeholder="Email"
                        v-model="loginForm.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </InputIconWrapper>
            </div>

            <!-- Password input -->
            <div class="space-y-2">
                <Label for="password" value="Password" />

                <InputIconWrapper icon="mdi:lock-outline">
                    <Input
                        withIcon
                        id="password"
                        type="password"
                        class="block w-full"
                        placeholder="Password"
                        v-model="loginForm.password"
                        required
                        autocomplete="current-password"
                    />
                </InputIconWrapper>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox
                        name="remember"
                        v-model:checked="loginForm.remember"
                    />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                <router-link
                    :to="{ name: 'ForgotPassword' }"
                    class="text-sm text-blue-500 hover:underline"
                >
                    Forgot your password?
                </router-link>
            </div>

            <!-- Login button -->
            <div>
                <Button
                    type="submit"
                    class="justify-center w-full gap-2"
                    :disabled="loginForm.processing"
                    left-icon="mdi:login"
                >
                    <span>Log in</span>
                </Button>
            </div>
        </div>
    </form>
</template>
