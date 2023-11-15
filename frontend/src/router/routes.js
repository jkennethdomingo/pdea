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
        component: () => import('@/layouts/CompanyStructureLayout.vue'),
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
        path: 'register',
        component: () => import('@/layouts/RegisterLayout.vue'),
        meta: { requiresRole: 'HR_ADMIN' },
        children: [
          {
            path: 'page1',
            name: 'Personal Information',
            component: () => import('@/views/pages/assign/PersonalInformation.vue'),
          },
          {
            path: 'page2',
            name: 'Family Background',
            component: () => import('@/views/pages/assign/FamilyBackground.vue'),
          },
          {
            path: 'page3',
            name: 'Educational Background',
            component: () => import('@/views/pages/assign/EducationalBackground.vue'),
          },
          {
            path: 'page4',
            name: 'Civil Service Eligibility',
            component: () => import('@/views/pages/assign/CivilServiceEligibility.vue'),
          },
          {
            path: 'page5',
            name: 'Work Experience',
            component: () => import('@/views/pages/assign/WorkExperience.vue'),
          },
          {
            path: 'page6',
            name: 'Voluntary Work',
            component: () => import('@/views/pages/assign/VoluntaryWork.vue'),
          },
          {
            path: 'page7',
            name: 'Learning And Development',
            component: () => import('@/views/pages/assign/LearningAndDevelopment.vue'),
          },
          {
            path: 'page8',
            name: 'Other Information',
            component: () => import('@/views/pages/assign/OtherInformation.vue'),
          },
          {
            path: 'page9',
            name: 'Questions And Others',
            component: () => import('@/views/pages/assign/QuestionsAndOthers.vue'),
          },
          // ... other assign routes if needed ...
        ],
      },
      {
        path: 'calendar',
        component: () => import('@/layouts/AssignTrainingLayout.vue'),
        meta: { requiresRole: 'HR_ADMIN' },
        children: [
          {
            path: '',
            name: 'Calendar',
            component: () => import('@/views/pages/assign/Calendar.vue'),
          },
        ],
      }


      // ... other HR routes if needed ...
    ],
  },
  {
    path: '/logistics',
    component: () => import('@/layouts/MainLayout.vue'),
    meta: { requiresRole: 'LOGISTICS_ADMIN' },
    children: [
      {
        path: 'dashboard',
        name: 'LG_Dashboard',
        component: () => import('@/views/pages/logistics/LG_Dashboard.vue'),
      },
      {
        path: 'lg',
        component: () => import('@/layouts/LogisticsLayout.vue'),
        children: [
          {
            path: 'inventory_management',
            children: [
              {
              path: 'inventory',
              name: 'LG_Inventory',
              component: () => import('@/views/pages/logistics/LG_Inventory.vue'),
              },
              {
              path: 'add_inventory',
              name: 'LG_Inventory_Add',
              component: () => import('@/views/pages/logistics/LG_Inventory_Add.vue'),
              },
            ],
          },

          {
            path: 'reports',
            name: 'LG_Reports',
            component: () => import('@/views/pages/logistics/LG_Reports.vue'),
          },
          {
            path: 'material_requisition',
            children: [
              {
                path: 'agent',
                name: 'LG_Agent',
                component: () => import('@/views/pages/logistics/LG_Agent.vue'),
              },
              {
                path: 'Department',
                name: 'LG_Department',
                component: () => import('@/views/pages/logistics/LG_Department.vue'),
              },
              {
                path: 'ProvincialOffice',
                name: 'LG_Provincial_Office',
                component: () => import('@/views/pages/logistics/LG_Province.vue'),
              },
              {
                path: 'RegionalOffice',
                name: 'LG_Regional_Office',
                component: () => import('@/views/pages/logistics/LG_Regional.vue'),
              },
            ],
          },
        ],
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
