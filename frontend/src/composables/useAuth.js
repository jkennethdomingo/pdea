import { jwtDecode } from 'jwt-decode';
import apiService from '@/composables/axios-setup';

export function useAuth(router, store) {
    const performLogin = async (email, password, remember) => {
        const response = await apiService.post('/auth/login', { email, password, remember });
        const decodedToken = jwtDecode(response.data.token);

        // Check for valid issuer
        if (decodedToken.iss !== 'pdeabackend.com') {
            throw new Error('Invalid token issuer.');
        }

        // Get current time in seconds since epoch
        const currentTime = Date.now() / 1000;

        // Check if the token is expired or not yet valid
        if (decodedToken.exp < currentTime || decodedToken.iat > currentTime) {
            throw new Error('Invalid token timing.');
        }

        // Store the token in Vuex store along with other decoded data
        store.commit('setAuth', {
            token: response.data.token,
            role: decodedToken.role,
            employeeID: decodedToken.sub,
            expiration: decodedToken.exp,
            issuedAt: decodedToken.iat
        });

        // Persist the token and timing information
        const storage = remember ? localStorage : sessionStorage;
        storage.setItem('authToken', response.data.token);
        storage.setItem('authExpiration', decodedToken.exp.toString());
        storage.setItem('authIssuedAt', decodedToken.iat.toString());

        return { role: decodedToken.role, shouldRemember: remember };
    };

    const redirectToDashboard = (role, roleToRoute) => {
        const route = roleToRoute[role] || { name: 'LandingPage' };
        router.push(route);
    };

    return { login: performLogin, redirectToDashboard };
}
