export default [
    {
        path: '/',
        component: () => import('@/layouts/DashboardLayout.vue'),
        children: [
          {
            path: '/',
            name: 'Dashboard',
            component: () => import('@/views/Index.vue'),
          },
          {
            path: '/pages/blank',
            name: 'Blank',
            component: () => import('@/views/pages/Blank.vue'),
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
    ],
    },

]