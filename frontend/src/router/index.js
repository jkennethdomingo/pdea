import { createRouter, createWebHashHistory } from 'vue-router';
import NProgress from 'nprogress';
import routes from '@/router/routes';
import { sidebarState } from '@/composables';
import store from '@/store'; // Make sure to import the store correctly

const router = createRouter({
  history: createWebHashHistory('pdea'),
  routes,
});

router.beforeEach((to, from, next) => {
  NProgress.start();

  // Check if the route requires a specific role
  const requiresRole = to.matched.some(record => record.meta.requiresRole);
  const userRole = store.state.userRole; // Access the user role from the store

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
