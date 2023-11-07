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

  // Initialize authentication state from storage if it hasn't been already
  if (!store.state.userRole) {
    store.dispatch('initializeAuth');
  }

  let userRole = store.state.userRole;

  const requiresRole = to.matched.some(record => record.meta.requiresRole);

  if (requiresRole) {
    const routeRole = to.matched.find(record => record.meta.requiresRole).meta.requiresRole;
    if (userRole !== routeRole) {
      next({ name: 'Login' });
    } else {
      next();
    }
  } else {
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
