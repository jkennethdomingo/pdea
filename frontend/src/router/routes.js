export default [
  {
    path: '/',
    name: 'LandingPage',
    component: () => import('@/views/LandingPage.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/human-resources',
    component: () => import('@/layouts/DashboardLayout.vue'),
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: () => import('@/views/Index.vue'),
        meta: { requiresRole: 'HR_ADMIN' },
      },
      {
        path: 'company',
        component: () => import('@/layouts/RegisterAccountLayout.vue'),
        meta: { requiresRole: 'HR_ADMIN' },
        children: [
          {
            path: '',
            name: 'Company',
            component: () => import('@/views/pages/company/Company.vue'),
          },
          {
            path: 'add-account',
            name: 'Add Account',
            component: () => import('@/views/pages/company/Register.vue'),
          },
          // ... other company routes if needed ...
        ],
      },
      {
        path: 'assign',
        component: () => import('@/layouts/AssignTrainingLayout.vue'),
        meta: { requiresRole: 'HR_ADMIN' },
        children: [
          {
            path: '',
            name: 'Assign Training Overview',
            component: () => import('@/views/pages/assign/AssignTable.vue'),
          },
          {
            path: 'add',
            name: 'Assign Training Add',
            component: () => import('@/views/pages/assign/Add.vue'),
          },
          // ... other assign routes if needed ...
        ],
      },
      // ... other HR routes if needed ...
    ],
  },
  {
    path: '/logistics',
    component: () => import('@/layouts/DashboardLayout.vue'),
    meta: { requiresRole: 'LOGISTICS_ADMIN' },
    children: [
      {
        path: 'dashboard',
        name: 'LG_Dashboard',
        component: () => import('@/views/pages/logistics/LG_Dashboard.vue'),
      },
      {
        path: 'inventory',
        name: 'LG_Inventory',
        component: () => import('@/views/pages/logistics/LG_Inventory.vue'),
      },
      {
        path: 'reports',
        name: 'LG_Reports',
        component: () => import('@/views/pages/logistics/LG_Reports.vue'),
      },
      // ... other logistics routes if needed ...
    ],
  },
  {
    path: '/auth',
    component: () => import('@/layouts/AuthenticationLayout.vue'),
    children: [
      {
        path: 'login',
        name: 'Login',
        component: () => import('@/views/auth/Login.vue'),
      },
      {
        path: 'forgot-password',
        name: 'ForgotPassword',
        component: () => import('@/views/auth/ForgotPassword.vue'),
      },
      // ... other auth routes if needed ...
    ],
  },
  // ... other routes if needed ...
];
