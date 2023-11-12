import { jwtDecode } from 'jwt-decode';
import apiService from '@/composables/axios-setup'; // Import your apiService

export function useAuth(router, store) {
    const performLogin = async (email, password, remember) => {
        // Use apiService instance instead of axios
        const response = await apiService.post('/auth/login', { email, password });
        const decodedToken = jwtDecode(response.data.token);

        store.commit('setAuth', { token: response.data.token, role: decodedToken.role });
        const authData = {
            token: response.data.token,
            role: decodedToken.role
        };

        const storage = remember ? localStorage : sessionStorage;
        storage.setItem('authData', JSON.stringify(authData));

        return { role: decodedToken.role, shouldRemember: remember };
    };

    const redirectToDashboard = (role, roleToRoute) => {
        const route = roleToRoute[role] || { name: 'LandingPage' };
        router.push(route);
    };

    return { login: performLogin, redirectToDashboard };
}
