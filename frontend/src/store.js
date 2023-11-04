import { createStore } from 'vuex';
import { jwtDecode } from 'jwt-decode'; 

// State
const state = {
    token: null,
    userRole: null,
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
};

// Actions
const actions = {
    login({ commit }, payload) {
        commit('setAuth', payload);
    },
    logout({ commit }) {
        // Ensure to remove 'authData' which is the key we're using to store token and role
        localStorage.removeItem('authData');
        sessionStorage.removeItem('authData');
        commit('clearAuth');
    },
    initializeAuth({ commit }) {
        // Retrieve the authData from storage
        const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
        
        if (authDataString) {
            // Parse the JSON string back into an object
            const authData = JSON.parse(authDataString);
            const token = authData.token;
            const userRole = authData.role;

            // Make sure both token and role exist before setting them to the state
            if (token && userRole) {
                commit('setAuth', { token, role: userRole });
            }
        }
    },
};

// Store
export default createStore({
    state,
    mutations,
    actions,
});