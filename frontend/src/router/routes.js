export default [
  {
    path: '/',
    name: 'LandingPage',
    component: () => import('@/views/Index.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/human-resources',
    component: () => import('@/layouts/DashboardLayout.vue'),
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: () => import('@/views/hr/Index.vue'),
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
            component: () => import('@/views/hr/company_structure/CompanyStructure.vue'),
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
            component: () => import('@/views/hr/insert_employee/PersonalInformation.vue'),
          },
          {
            path: 'page2',
            name: 'Family Background',
            component: () => import('@/views/hr/insert_employee/FamilyBackground.vue'),
          },
          {
            path: 'page3',
            name: 'Educational Background',
            component: () => import('@/views/hr/insert_employee/EducationalBackground.vue'),
          },
          {
            path: 'page4',
            name: 'Civil Service Eligibility',
            component: () => import('@/views/hr/insert_employee/CivilServiceEligibility.vue'),
          },
          {
            path: 'page5',
            name: 'Work Experience',
            component: () => import('@/views/hr/insert_employee/WorkExperience.vue'),
          },
          {
            path: 'page6',
            name: 'Voluntary Work',
            component: () => import('@/views/hr/insert_employee/VoluntaryWork.vue'),
          },
          {
            path: 'page7',
            name: 'Learning And Development',
            component: () => import('@/views/hr/insert_employee/LearningAndDevelopment.vue'),
          },
          {
            path: 'page8',
            name: 'Other Information',
            component: () => import('@/views/hr/insert_employee/OtherInformation.vue'),
          },
          {
            path: 'page9',
            name: 'Questions And Others',
            component: () => import('@/views/hr/insert_employee/QuestionsAndOthers.vue'),
          },
          // ... other assign routes if needed ...
        ],
      },
      {
        path: 'beta',
        component: () => import('@/layouts/RegisterLayout.vue'),
        children: [
          {
            path: 'beta',
            name: 'Beta',
            component: () => import('@/views/hr/beta/UploadProfile.vue'),
          },
        ],
      },
      {
        path: 'calendar',
        children: [
          {
              path: 'assignTraining',
              component: () => import('@/layouts/AssignTrainingLayout.vue'),
              meta: { requiresRole: 'HR_ADMIN' },
              children: [
                {
                  path: '',
                  name: 'Assign Training',
                  component: () => import('@/views/hr/assign_training/AssignTraining.vue'),
                },
              ],
            },
            {
              path: 'manageLeave',
              component: () => import('@/layouts/ManageLeaveLayout.vue'),
              meta: { requiresRole: 'HR_ADMIN' },
              children: [
                {
                  path: '',
                  name: 'Manage Leave',
                  component: () => import('@/views/hr/assign_training/ManageLeave.vue'),
                },
              ],
            },
        ],
      },



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
        component: () => import('@/views/logistics/Index.vue'),
      },
      {
        path: 'lg',
        component: () => import('@/layouts/ProcurementLayout.vue'),
        children: [
          {
            path: 'inventory_management',
            children: [
              {
              path: 'inventory',
              name: 'LG_Inventory',
              component: () => import('@/views/logistics/manage_inventory/LG_Inventory.vue'),
              },
              {
              path: 'add_inventory',
              name: 'LG_Inventory_Add',
              component: () => import('@/views/logistics/manage_inventory/LG_Inventory_Add.vue'),
              },
            ],
          },
          {
            path: 'property_management',
            children: [
              {
                path: 'property',
                name: 'LG_Property_Monitoring',
                component: () => import('@/views/logistics/manage_inventory/LG_Property_Monitoring.vue'),
                },
                {
                  path: 'add',
                  name: 'LG_Property_Add',
                  component: () => import('@/views/logistics/manage_inventory/LG_Property_Add.vue'),
                  },
            ],
          },
          
        ],
      },
      {
        path: '',
        component: () => import('@/layouts/LogisticsLayout.vue'),
        children: [
          {
            path: 'reports',
            name: 'LG_Reports',
            component: () => import('@/views/logistics/reports/LG_Reports.vue'),
          },
          {
            path: 'material_requisition',
            children: [
              {
                path: 'agent',
                name: 'LG_Agent',
                component: () => import('@/views/logistics/material_requisition/LG_Agent.vue'),
              },
              {
                path: 'Department',
                name: 'LG_Department',
                component: () => import('@/views/logistics/material_requisition/LG_Department.vue'),
              },
              {
                path: 'ProvincialOffice',
                name: 'LG_Provincial_Office',
                component: () => import('@/views/logistics/material_requisition/LG_Province.vue'),
              },
              {
                path: 'RegionalOffice',
                name: 'LG_Regional_Office',
                component: () => import('@/views/logistics/material_requisition/LG_Regional.vue'),
              },
            ],
          },
        ],

      }
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
