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

  // Initialize once and store the result
  let userRole = store.state.userRole || store.dispatch('initializeAuth');

  // Combine both role checks in a single iteration
  const routeRoleRecord = to.matched.find(record => record.meta.requiresRole);

  if (routeRoleRecord) {
    const routeRole = routeRoleRecord.meta.requiresRole;
    if (userRole !== routeRole) {
      return next({ name: 'Login' }); // Redirect if user role doesn't match
    }
  }

  next(); // Proceed if no role is required or if it matches
});

router.afterEach(() => {
  // Move the window width check to a more appropriate place if possible
  if (window.innerWidth <= 1024) {
    sidebarState.isOpen = false;
  }
  NProgress.done();
});

export default router;
