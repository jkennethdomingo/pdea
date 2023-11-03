import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import axios from 'axios'
import Toast from 'vue-toastification'
import '@/assets/css/main.css'

axios.defaults.baseURL = "http://backend.test/api/"

const app = createApp(App)
app.use(router)
app.use(Toast, {
  hideProgressBar: true,
  closeOnClick: false,
  closeButton: false,
  icon: false,
  timeout: false,
  transition: 'Vue-Toastification__fade',
})
app.mount('#app')
