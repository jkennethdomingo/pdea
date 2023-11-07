import { createStore } from 'vuex';

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
