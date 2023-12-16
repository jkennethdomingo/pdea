import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import '@/assets/css/main.css';
import 'flowbite';
import VCalendar from 'v-calendar';
import 'v-calendar/style.css';
import apiService from '@/composables/axios-setup';
import { jwtDecode } from 'jwt-decode';

const app = createApp(App);

// Optionally, if you want to use apiService globally
app.config.globalProperties.$api = apiService;

app.use(VCalendar, {});
app.use(router);
app.use(store);

// Use Toast with options
app.use(Toast, {
  hideProgressBar: true,
  closeOnClick: false,
  closeButton: false,
  icon: false,
  timeout: 3000, 
  transition: 'Vue-Toastification__fade'
});


// Dispatch the initializeAuth action to set auth state on app load
function getTokenFromStorage() {
  // Try to get the token from sessionStorage first, then localStorage
  return sessionStorage.getItem('authToken') || localStorage.getItem('authToken');
}

function checkTokenExpiration() {
  const token = getTokenFromStorage();
  if (token) {
      try {
          const decodedToken = jwtDecode(token);
          const currentTime = Date.now() / 1000;
          if (decodedToken.exp <= currentTime) {
              // Token has expired, take action
              // Clear the token from both storages
              sessionStorage.removeItem('authToken');
              localStorage.removeItem('authToken');
              // Redirect to login
              router.push({ name: 'Login' });
          }
      } catch (error) {
          // Handle decoding errors (e.g., token is tampered or malformed)
          console.error('Token decoding error:', error);
          sessionStorage.removeItem('authToken');
          localStorage.removeItem('authToken');
          router.push({ name: 'Login' });
      }
  }
}

// Set up polling to check token expiration every 5 minutes
setInterval(checkTokenExpiration, 5 * 60 * 1000);

app.mount('#app');


