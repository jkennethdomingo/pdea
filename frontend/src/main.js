import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store'; // Import the store
import jwtDecode from 'jwt-decode'; // Import if you're using it in the store
import axios from 'axios';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css'; // Make sure to import the CSS for Toast
import '@/assets/css/main.css';

// Set axios defaults
axios.defaults.baseURL = "http://backend.test/api/";

const app = createApp(App);

app.use(router);
app.use(store); // Use the store

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
