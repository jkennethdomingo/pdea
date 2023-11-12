import { createStore } from 'vuex';
import axios from 'axios'; // Ensure axios is imported if you plan to use it for API calls

// State
const state = {
    token: null,
    userRole: null,
    formData: {
        // Initialize states for each page of the form
        page1: { 
            designation: "",
            position: "", 
            section: "", 
         },
        page2: { /* ... fields for page 2 ... */ },
        page3: { /* ... fields for page 2 ... */ },
        page4: { /* ... fields for page 2 ... */ },
        page5: { /* ... fields for page 2 ... */ },
        page6: { /* ... fields for page 2 ... */ },
        page7: { /* ... fields for page 2 ... */ },
        page8: { /* ... fields for page 2 ... */ },
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
        // Implement the logic to submit the form data
        axios.post('api/employee/insert', state.formData)
            .then(response => {
                // Handle response
            })
            .catch(error => {
                // Handle error
            });
    },
};

// Helper function to retrieve and parse stored authentication data
function getStoredAuthData() {
    const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
    return authDataString ? JSON.parse(authDataString) : null;
}

// Store
export default createStore({
    state,
    mutations,
    actions,
});
