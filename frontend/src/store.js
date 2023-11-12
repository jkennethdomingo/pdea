import { createStore } from 'vuex';
import apiService from '@/composables/axios-setup';

// Helper function to retrieve and parse stored authentication data
function getStoredAuthData() {
    const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
    return authDataString ? JSON.parse(authDataString) : null;
}

// Helper function to transform the form data
function transformFormData(formData) {
    const transformedData = {};

    // Flatten the nested structure
    Object.keys(formData).forEach(page => {
        Object.keys(formData[page]).forEach(field => {
            // Remove the page_ prefix and store in the transformedData object
            transformedData[field] = formData[page][field];
        });
    });

    // Return the transformed data
    return transformedData;
}

// State
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
        page3: { /* ... fields for page 3 ... */ },
        page4: { /* ... fields for page 4 ... */ },
        page5: { /* ... fields for page 5 ... */ },
        page6: { /* ... fields for page 6 ... */ },
        page7: { /* ... fields for page 7 ... */ },
        page8: { /* ... fields for page 8 ... */ },
        page9: { /* ... fields for page 9 ... */ }
    },
};

// Mutations
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
};

// Actions
const actions = {
    login({ commit }, payload) {
        commit('setAuth', payload);
    },
    logout({ commit }) {
        localStorage.removeItem('authData');
        sessionStorage.removeItem('authData');
        commit('clearAuth');
    },
    initializeAuth({ commit }) {
        const authData = getStoredAuthData();
        if (authData) {
            commit('setAuth', { token: authData.token, role: authData.role });
        }
    },
    submitFormData({ state }) {
        // Transform the data before submitting
        const transformedFormData = transformFormData(state.formData);

        // Implement the logic to submit the form data
        apiService.post('employee/insert', transformedFormData)
            .then(response => {
                // Handle response
            })
            .catch(error => {
                // Handle error
            });
    },
};

// Store
export default createStore({
    state,
    mutations,
    actions,
});
