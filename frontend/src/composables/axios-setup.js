// Add this in your main.js or in an axios-setup.js that you import into main.js

import axios from 'axios';

// Set up a service instance for your API
const apiService = axios.create({
  baseURL: "http://backend.test/api/" // Adjust this to your actual backend URL
});


export default apiService;
