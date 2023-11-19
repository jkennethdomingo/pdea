import apiService from '@/composables/axios-setup';
import { transformFormData, getStoredAuthData } from '@/utils/utils';

export const actions = {
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
    async getData({ commit }) {
        try {
            commit('setIsFetchingData', true);
            const response = await apiService.post('/materialRequisition/getData');
            if (response && response.data) {
                commit('setData', response.data);
            }
        } catch (error) {
            console.error('Error fetching  data:', error);
        } finally {
            commit('setIsFetchingData', false);
        }
    },
    async getInventoryData({ commit }) {
        try {
            commit('setLoading', true); 
          const response = await apiService.post('/manageInventory/getInventoryData');
          commit('setProcurementData', response.data.procurement);
        } catch (error) {
          console.error('Error fetching data:', error);
        } finally {
            commit('setLoading', false);
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
    async addInventory({ commit }, inventoryData) {
        try {
            commit('setIsInserting', true); // Optional: mutation to set a loading state
            const response = await apiService.post('/manageInventory/addInventory', inventoryData); // Adjust '/items' to your specific endpoint
            commit('addItem', response.data); // Assuming the API returns the inserted item
        } catch (error) {
            console.error('Insert error:', error);
            // Handle error (e.g., show a notification or set an error state)
        } finally {
            commit('setIsInserting', false); // Reset the loading state
        }
    },
    initializeAuth({ commit }) {
        const authData = getStoredAuthData();
        if (authData) {
            commit('setAuth', { token: authData.token, role: authData.role });
        }
    },
    clearFormData({ commit }) {
        commit('resetFormData');
      },
      async getTraining({ commit }) {
        try {
          commit('setLoading', true); // Start loading
      
          const response = await apiService.post('/manageTraining/getTraining');
          
          // Assuming the training data is directly in response.data
          // Change the path as per your API response structure
          commit('setTrainingData', response.data.training); 
      
        } catch (error) {
          console.error('Error fetching training data:', error);
        } finally {
          commit('setLoading', false); // End loading
        }
      },
      async addEvent({ commit }, newEvent) {
        commit('setIsAddingEvent', true); // Set loading state

        try {
            // Transform and send data to the server
            const transformedEvent = {  title: newEvent.title,
                period_from: newEvent.period_from,
                period_to: newEvent.period_to,
                number_of_hours: newEvent.number_of_hours,
                conducted_by: newEvent.conducted_by, };
            const response = await apiService.post('manageTraining/insertTraining', transformedEvent);

            // If successful, add the event to the state
            commit('addEventToState', response.data);

            // Additional logic for successful submission...
        } catch (error) {
            console.error('Event submission error:', error);
            // Error handling...
        } finally {
            commit('setIsAddingEvent', false); // Reset loading state
        }
    },

      
      
};
