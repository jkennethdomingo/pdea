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
  timeout: false,
  transition: 'Vue-Toastification__fade',
});

// Dispatch the initializeAuth action to set auth state on app load
store.dispatch('initializeAuth');

app.mount('#app');
