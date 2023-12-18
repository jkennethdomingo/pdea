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
import { checkToken } from '@/utils/auth';

const app = createApp(App);

// Set apiService globally
app.config.globalProperties.$api = apiService;

app.use(VCalendar, {});
app.use(router);
app.use(store);
app.use(Toast, {
  hideProgressBar: true,
  closeOnClick: false,
  closeButton: false,
  icon: false,
  timeout: 3000,
  transition: 'Vue-Toastification__fade'
});


// Set up polling to check token expiration and blacklist status
setInterval(() => {
  checkToken(store);
}, 3000);

app.mount('#app');
