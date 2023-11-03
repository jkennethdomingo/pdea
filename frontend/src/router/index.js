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

  // Try to get the user role from the Vuex store
  let userRole = store.state.userRole;

  // If there's nothing in Vuex, check localStorage
  if (!userRole) {
    const storedData = localStorage.getItem('authData');
    if (storedData) {
      const parsedData = JSON.parse(storedData);
      userRole = parsedData.role;

      // Optionally, update the Vuex store with the new auth data
      store.commit('setAuth', { token: parsedData.token, role: parsedData.role });
    }
  }

  // Check if the route requires a specific role
  const requiresRole = to.matched.some(record => record.meta.requiresRole);

  // If the route has a role requirement and the user does not meet it, redirect
  if (requiresRole && userRole !== 'HR_ADMIN') {
    // Redirect to login or any other route
    next({ name: 'Login' });
  } else {
    // Proceed to the route
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
