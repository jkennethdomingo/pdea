import { createRouter, createWebHashHistory } from 'vue-router';
import NProgress from 'nprogress';
import routes from '@/router/routes';
import { sidebarState } from '@/composables';
import store from '@/store';
import { jwtDecode } from 'jwt-decode';

const router = createRouter({
  history: createWebHashHistory('pdea'),
  routes,
});

router.beforeEach(async (to, from, next) => {
  NProgress.start();

  // Attempt to retrieve the token from Vuex state or initialize auth state if the token is not present
  let token = store.state.token;
  if (!token) {
    await store.dispatch('initializeAuth');
    token = store.state.token; // Update the token from the state after initialization
  }

  // Check if the token exists and if the route requires a specific role
  const routeRoleRecord = to.matched.find(record => record.meta.requiresRole);

  if (routeRoleRecord && token) {
    // Decode the token to check the user's role
    const decodedToken = jwtDecode(token);
    const userRole = decodedToken.role;

    const routeRole = routeRoleRecord.meta.requiresRole;
    // Check if user role matches the required role for the route
    if (userRole !== routeRole) {
      NProgress.done(); // Stop the progress bar if redirecting
      return next({ name: 'Login' }); // Redirect to login if user role doesn't match
    }
  } else if (routeRoleRecord && !token) {
    // If there's no token, redirect to login
    NProgress.done(); // Stop the progress bar if redirecting
    return next({ name: 'Login' });
  }

  next(); // Proceed if no role is required or if the token's role matches
});


router.afterEach(() => {
  // Move the window width check to a more appropriate place if possible
  if (window.innerWidth <= 1024) {
    sidebarState.isOpen = false;
  }
  NProgress.done();
});

export default router;
