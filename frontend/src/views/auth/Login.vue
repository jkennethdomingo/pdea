<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { jwtDecode } from 'jwt-decode';
import { useToast } from 'vue-toastification'; // Import the hook
import Login from '@/components/pages/auth/Login.vue';

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

const redirectToDashboard = (role) => {
  // Define the routes for each role
  const roleToRoute = {
    'HR_ADMIN': { name: 'Dashboard' }, // assuming this is the route name for the HR dashboard
    'LOGISTICS_ADMIN': { name: 'LG_Dashboard' }, // route name for the Logistics dashboard
  };

  // Find the route for the current role
  const route = roleToRoute[role];

  // Redirect to the found route, or default to a general dashboard if role not found
  if (route) {
    router.push(route);
  } else {
    router.push({ name: 'Login' });
  }
};

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
            const authData = {
                token: response.data.token,
                role: decodedToken.role
            };

            // Convert the object to a string to store in localStorage or sessionStorage
            const authDataString = JSON.stringify(authData);

            // Check if the remember me is checked and store the token and role in localStorage
            if (loginForm.remember) {
                localStorage.setItem('authData', authDataString);
            } else {
                sessionStorage.setItem('authData', authDataString);
            }
            redirectToDashboard(decodedToken.role);
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
    <Login :loginForm="loginForm" @submit="login" />
</template>
