// Add this in your main.js or in an axios-setup.js that you import into main.js

import axios from 'axios';

// Set up a service instance for your API
const apiService = axios.create({
  baseURL: "http://backend.test/api/" // Adjust this to your actual backend URL
});

/*
// Request interceptor to add the auth token to every request
apiService.interceptors.request.use(config => {
  // Retrieve the auth data from storage
  const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
  const authData = authDataString ? JSON.parse(authDataString) : null;

  // If the auth data exists and has a token, add it to the request's Authorization header
  if (authData && authData.token) {
    config.headers['Authorization'] = `${authData.token}`;
  } else {
    // If the token is not available, you may want to throw an error or handle it appropriately
    console.error('No auth token found.');
  }

  return config;
}, error => {
  // Do something with request error
  return Promise.reject(error);
});*/

export default apiService;
