import { createStore } from 'vuex';
import VuexPersist from 'vuex-persist';
import apiService from '@/composables/axios-setup';

function getStoredAuthData() {
    const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
    return authDataString ? JSON.parse(authDataString) : null;
}

function transformFormData(formData) {
    const transformedData = {};

    Object.keys(formData).forEach(page => {
        Object.keys(formData[page]).forEach(field => {
            transformedData[field] = formData[page][field];
        });
    });

    return transformedData;
}

const state = {
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
        page4: { career_service: '', rating: '', date_of_examination: '', place_of_examination: '', license_number: '', license_date_of_validity: '' },
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

const mutations = {
    setAuth(state, payload) {
        state.token = payload.token;
        state.userRole = payload.role;
    },
    clearAuth(state) {
        state.token = null;
        state.userRole = null;
    },
    updateFormData(state, { page, data }) {
        state.formData[page] = { ...state.formData[page], ...data };
    },
    setDropdownData(state, payload) {
        state.dropdownData.designations = payload.designations;
        state.dropdownData.positions = payload.positions;
        state.dropdownData.sections = payload.sections;
    },
    setIsLoggingIn(state, status) {
        state.loadingStates.isLoggingIn = status;
    },
    setIsLoggingOut(state, status) {
        state.loadingStates.isLoggingOut = status;
    },
    setIsFetchingDropdownData(state, status) {
        state.loadingStates.isFetchingDropdownData = status;
    },
    setIsSubmitting(state, status) {
        state.loadingStates.isSubmitting = status;
    }
};

const actions = {
    async login({ commit }, payload) {
        try {
            commit('setIsLoggingIn', true);
            const response = await apiService.post('/login', payload);
            commit('setAuth', { token: response.data.token, role: response.data.role });
        } catch (error) {
            console.error('Login error:', error);
        } finally {
            commit('setIsLoggingIn', false);
        }
    },
    async logout({ commit }) {
        try {
            commit('setIsLoggingOut', true);
            // Logout logic here
            localStorage.removeItem('authData');
            sessionStorage.removeItem('authData');
            commit('clearAuth');
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            commit('setIsLoggingOut', false);
        }
    },
    async getDropdownData({ commit }) {
        try {
            commit('setIsFetchingDropdownData', true);
            const response = await apiService.post('/employee/getDropdownData');
            if (response && response.data) {
                commit('setDropdownData', response.data);
            }
        } catch (error) {
            console.error('Error fetching dropdown data:', error);
        } finally {
            commit('setIsFetchingDropdownData', false);
        }
    },
    async submitFormData({ commit, state }) {
        if (state.loadingStates.isSubmitting) return;

        try {
            commit('setIsSubmitting', true);
            const transformedFormData = transformFormData(state.formData);
            await apiService.post('employee/insert', transformedFormData);
            // Handle response here
        } catch (error) {
            console.error('Form submission error:', error);
        } finally {
            commit('setIsSubmitting', false);
        }
    },
    initializeAuth({ commit }) {
        const authData = getStoredAuthData();
        if (authData) {
            commit('setAuth', { token: authData.token, role: authData.role });
        }
    },
};

const vuexLocal = new VuexPersist({
    storage: window.localStorage,
    reducer: state => ({
        token: state.token,
        userRole: state.userRole
    })
});

export default createStore({
    state,
    mutations,
    actions,
    plugins: [vuexLocal.plugin]
});