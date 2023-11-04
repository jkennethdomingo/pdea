export default [
  {
    path: '/',
    name: 'LandingPage',
    component: () => import('@/views/LandingPage.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/',
    component: () => import('@/layouts/DashboardLayout.vue'),
    children: [
      {
        path: '/hr-dashboard',
        name: 'Dashboard',
        component: () => import('@/views/Index.vue'),
        meta: { requiresRole: 'HR_ADMIN' }, 
      },
      {
        path: '/pages/company',
        name: 'Company',
        component: () => import('@/views/pages/Company.vue'),
        meta: { requiresRole: 'HR_ADMIN' }, 
      },
      {
        path: '/pages/blank',
        name: 'Blank',
        component: () => import('@/views/pages/Blank.vue'),
        meta: { requiresRole: 'HR_ADMIN' }, 
      },
    ],
},
  {
    path: '/',
    component: () => import('@/layouts/DashboardLayout.vue'),
    children: [
      {
        path: '/logistics-dashboard',
        name: 'LG_Dashboard',
        component: () => import('@/views/pages/logistics/LG_Dashboard.vue'),
        meta: { requiresRole: 'LOGISTICS_ADMIN' }, 
      },
    ],
},
    {
    path: '/auth',
    name: 'Auth',
    component: () => import('@/layouts/AuthenticationLayout.vue'),
    children: [
        {
        path: '/auth/login',
        name: 'Login',
        component: () => import('@/views/auth/Login.vue'),
        },
        {
          path: '/auth/forgot-password',
          name: 'ForgotPassword',
          component: () => import('@/views/auth/ForgotPassword.vue'),
        },
    ],
    },

]