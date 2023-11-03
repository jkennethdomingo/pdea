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
        localStorage.removeItem('jwtToken');
        sessionStorage.removeItem('jwtToken');
        commit('clearAuth');
    },
    initializeAuth({ commit }) {
        const token = localStorage.getItem('jwtToken') || sessionStorage.getItem('jwtToken');
        if (token) {
        // Decode the token to get the user's role
        const userRole = jwtDecode(token).role; // Now jwtDecode should be available
        commit('setAuth', { token, role: userRole });
        }
    },
};

// Store
export default createStore({
    state,
    mutations,
    actions,
});
