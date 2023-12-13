const svgIcon = `
<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
  <path fill="currentColor" fill-rule="evenodd" 
    d="M8 7a4 4 0 1 1 8 0a4 4 0 0 1-8 0Zm0 6a5 5 0 0 0-5 5a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3a5 5 0 0 0-5-5H8Z" 
    clip-rule="evenodd"/>
</svg>`;

const svgBase64 = btoa(svgIcon);

export const state = {
    token: null,
    userRole: null,
    employeeID: null,
    formData: {
        page1: {
            EmployeeID: '',
            surname: '',
            first_name: '',
            middle_name: '',
            name_extension: '',
            sex: '',
            civil_status: '',
            height: '',
            weight: '',
            photo: '',
            blood_type: '',
            gsis_id_no: '',
            pag_ibig_id_no: '',
            philhealth_no: '',
            sss_no: '',
            tin_no: '',
            agency_employee_no: '',
            citizenship: '',
            country: '',
            residentialForm: {
                house_block_lot_no: '',
                street: '',
                subdivision_village: '',
                region: '',
                province: '',
                municipality: '',
                barangay: '',
                zip_code: '',
            },
            permanentForm: {
                house_block_lot_no: '',
                street: '',
                subdivision_village: '',
                region: '',
                province: '',
                municipality: '',
                barangay: '',
                zip_code: '',
            },
        },
        page2: { /* ... fields for page 2 ... */ },
        page3: { 
            Elementary: {
                name_of_school: '',
                degree_course:'',
                period_of_attendance_from:'',
                period_of_attendance_to:'',
                highest_level_units_earned:'',
                year_graduated:'',
                scholarship_academic_honors_received:''
            },
            Secondary: {
                name_of_school: '',
                degree_course:'',
                period_of_attendance_from:'',
                period_of_attendance_to:'',
                highest_level_units_earned:'',
                year_graduated:'',
                scholarship_academic_honors_received:''
            },
            Vocational: {
                name_of_school: '',
                degree_course:'',
                period_of_attendance_from:'',
                period_of_attendance_to:'',
                highest_level_units_earned:'',
                year_graduated:'',
                scholarship_academic_honors_received:''
            },
            College: {
                name_of_school: '',
                degree_course:'',
                period_of_attendance_from:'',
                period_of_attendance_to:'',
                highest_level_units_earned:'',
                year_graduated:'',
                scholarship_academic_honors_received:''
            },
            GraduateStudies: {
                name_of_school: '',
                degree_course:'',
                period_of_attendance_from:'',
                period_of_attendance_to:'',
                highest_level_units_earned:'',
                year_graduated:'',
                scholarship_academic_honors_received:''
            }
        },
        page4: {
            CivilService: [], // Make sure this is initialized
        },
        page5: { 
            WorkExperience: [], 
        },
        page6: { 
            VoluntaryWork: [], // Make sure this is initialized
        },
        page7: { 
            LearningDevelopment: [], // Make sure
        },
        page8: { 
            OtherInformation: [], // Make sure
        },
        page9: { 
           
        }
    },
    dropdownData: {
        designations: [],
        positions: [],
        sections: [],
        employee: [],
        department: [],
        provincial_office: [],
        regional_office: [],
        divisions: [],
    },
    loadingStates: {
        isLoggingIn: false,
        isLoggingOut: false,
        isFetchingDropdownData: false,
        isSubmitting: false
    },
    procurementData: [],
    isLoading: false, 
    training: [],
    trainingbyTitle: [],
    events: [],
    agentData: [],
    activeProcurementData: [],
    archivedProcurementData: [],
    departmentData: [],
    provinceData: [],
    regionData: [],
    employeeInfo: [],
    EmployeeOnLeave: [],
    todaysLeavesCount: 0,
    todayTrainingCount: 0,
    todaysOnTrainingCount: 0,
    activeEmployeesCount: 0,
    employeeStatusPercentages: {
        activePercentage: 0,
        onTrainingPercentage: 0,
        onLeavePercentage: 0,
      },
    activeEmployeesLast13Days: [],
    activeEmployeesPercentagesLast13Days: [],
    combinedEvents: {
        employeeBirthdays: [],
        training: [],
        employeeOnLeave: []
      },
      upcomingEmployeeBirthdays: [],
    upcomingTraining: [],
    upcomingEmployeeOnLeave: [],
    approvedLeaves: [],
  unassignedUpcomingTrainings: [],
  countOfUnassignedUpcomingTrainings: 0,
  employeeInformation: null,
  employeeLeaveTypesWithBalance: [],
  pendingLeaveRequests: [],
  leaveRequests: {
    pending: [],
    approved: [],
    rejected: []
  },
  employeePendingLeaves: [],
  leaveApprovalResult: null,
  employeeleaveRequests: {
    pending: [],
    approved: [],
    rejected: []
  },
  trainingsWithoutEmployees: [],
  trainingSessions: {
    unassigned_or_pending: [],
    upcoming: [],
    finished: []
  },
  asset_type: [],
  activePPEData: [],
  archivedPPEData: [],
  trainees: [], 
  photoPreviewUrl: `data:image/svg+xml;base64,${svgBase64}`,
};
