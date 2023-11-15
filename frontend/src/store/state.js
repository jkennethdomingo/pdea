export const state = {
    token: null,
    userRole: null,
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
        page5: { /* ... fields for page 5 ... */ },
        page6: { /* ... fields for page 6 ... */ },
        page7: { /* ... fields for page 7 ... */ },
        page8: { /* ... fields for page 8 ... */ },
        page9: { /* ... fields for page 9 ... */ }
    },
    dropdownData: {
        designations: [],
        positions: [],
        sections: []
    },
    loadingStates: {
        isLoggingIn: false,
        isLoggingOut: false,
        isFetchingDropdownData: false,
        isSubmitting: false
    }
};
