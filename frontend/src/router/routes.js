import AboutView from '../views/AboutView.vue'

export default [
    {
        path: '/',
        name: 'about',
        component: AboutView
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