import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import axios from 'axios';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import '@/assets/css/main.css';
import 'flowbite';
import VCalendar from 'v-calendar';
import 'v-calendar/style.css';

// Set axios defaults
axios.defaults.baseURL = "http://backend.test/api/";

const app = createApp(App);

app.use(VCalendar, {})
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
