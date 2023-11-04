import { createRouter, createWebHashHistory } from 'vue-router';
import NProgress from 'nprogress';
import routes from '@/router/routes';
import { sidebarState } from '@/composables';
import store from '@/store';

const router = createRouter({
  history: createWebHashHistory('pdea'),
  routes,
});

router.beforeEach((to, from, next) => {
  NProgress.start();
  let userRole = store.state.userRole;

  // Check if the userRole is not set in the store, then try retrieving from localStorage or sessionStorage
  if (!userRole) {
    let storedData = localStorage.getItem('authData') || sessionStorage.getItem('authData');
    if (storedData) {
      const parsedData = JSON.parse(storedData);
      userRole = parsedData.role;
      // Commit the authentication data to the store
      store.commit('setAuth', { token: parsedData.token, role: parsedData.role });
    }
  }

  // Check if the route to be accessed has a role requirement
  const requiresRole = to.matched.some(record => record.meta.requiresRole);

  // If the route requires a specific role and the user does not have this role, redirect to login
  if (requiresRole) {
    const routeRole = to.matched.find(record => record.meta.requiresRole).meta.requiresRole;
    // If user role does not match the route's required role, redirect to the login page
    if (userRole !== routeRole) {
      next({ name: 'Login' });
    } else {
      // User role matches, proceed to the route
      next();
    }
  } else {
    // No specific role required for the route, proceed
    next();
  }
});


router.afterEach(() => {
  if (window.innerWidth <= 1024) {
    sidebarState.isOpen = false;
  }
  NProgress.done();
});

export default router;
