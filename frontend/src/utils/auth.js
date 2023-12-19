// auth.js
import apiService from '@/composables/axios-setup';
import { jwtDecode } from 'jwt-decode';
import router from '@/router'; 


export function getTokenFromStorage() {
  return sessionStorage.getItem('authToken') || localStorage.getItem('authToken');
}

export function logoutUser(store) {
  const token = getTokenFromStorage();
  if (token) {
    apiService.post('/auth/logout', { token })
        .then(response => {
            console.log('Logout successful:', response.data.message);
            store.commit('clearAuth');
            sessionStorage.removeItem('authToken');
            localStorage.removeItem('authToken');
            localStorage.removeItem('authExpiration');
            sessionStorage.removeItem('authExpiration');
            localStorage.removeItem('authIssuedAt');
            sessionStorage.removeItem('authIssuedAt');
            router.push({ name: 'Login' });
        })
        .catch(error => {
            console.error('Logout error:', error);
            store.commit('clearAuth');
            sessionStorage.removeItem('authToken');
            localStorage.removeItem('authToken');
            localStorage.removeItem('authExpiration');
            sessionStorage.removeItem('authExpiration');
            localStorage.removeItem('authIssuedAt');
            sessionStorage.removeItem('authIssuedAt');
            router.push({ name: 'Login' });
        });
  }
}

export function isLoggedIn() {
  const token = getTokenFromStorage();
  if (!token) return false;

  try {
    const decodedToken = jwtDecode(token);
    const currentTime = Date.now() / 1000;
    return decodedToken.exp > currentTime;
  } catch (error) {
    console.error('Error decoding token:', error);
    return false;
  }
}

export function checkToken(store) {
  const token = getTokenFromStorage();
  if (!token) return;

  try {
    const decodedToken = jwtDecode(token);
    const currentTime = Date.now() / 1000;
    if (decodedToken.exp <= currentTime) {
      logoutUser(store);
      return;
    }

    apiService.post('/auth/checkTokenBlacklist', { token })
      .then(response => {
        if (response.data.message === 'Token is blacklisted') {
          logoutUser(store);
        }
      })
      .catch(error => {
        console.error('Token blacklist check error:', error);
        logoutUser(store);
      });
  } catch (error) {
    console.error('Token decoding error:', error);
    logoutUser(store);
  }
}
