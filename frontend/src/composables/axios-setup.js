import axios from 'axios';

// Retrieve token from storage
function getTokenFromStorage() {
    return sessionStorage.getItem('authToken') || localStorage.getItem('authToken');
}

// Set up a service instance for your API
const apiService = axios.create({
    baseURL: "https://pdea-mimaropa.online/pdeamimaropa/api/" // Adjust this to your actual backend URL
});

// Add a request interceptor
// apiService.interceptors.request.use(config => {
//     const token = getTokenFromStorage();
//     if (token) {
//         config.headers.Authorization = `Bearer ${token}`;
//     }
//     return config;
// }, error => {
//     // Do something with request error
//     return Promise.reject(error);
// });

export default apiService;
