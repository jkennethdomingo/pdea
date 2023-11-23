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
            const response = await apiService.post('/materialRequisition/getAgentData');
            if (response && response.data) {
                commit('setData', response.data);
            }
        } catch (error) {
            console.error('Error fetching  data:', error);
        } finally {
            commit('setIsFetchingData', false);
        }
    },
    async getActiveInventoryData({ commit }) {
        try {
            commit('setLoading', true); 
          const response = await apiService.post('/manageInventory/getActiveInventoryData');
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
            // Prepare the event data, including any employee assignments
            const transformedEvent = {  
                title: newEvent.title,
                period_from: newEvent.period_from,
                period_to: newEvent.period_to,
                number_of_hours: newEvent.number_of_hours,
                conducted_by: newEvent.conducted_by,
                employees: newEvent.employees || [], // Include an empty array if no employees are assigned
            };
    
            // Send the new event data to the server
            const response = await apiService.post('manageTraining/insertTraining', transformedEvent);
    
            // If successful, add the event to the state
            commit('addEventToState', response.data);
    
            // Handle any additional logic for successful submission here...
    
        } catch (error) {
            console.error('Event submission error:', error);
            // Handle the error here...
    
        } finally {
            commit('setIsAddingEvent', false); // Reset loading state
        }
    },
    

    async editEvent({ commit }, updatedEvent) {
      commit('setIsEditingEvent', true); // Set loading state
  
      try {
        // Prepare the payload for the API request. Include 'title' for lookup and optional 'employees'.
        const payload = { 
          training_id: updatedEvent.training_id,
          title: updatedEvent.title,
          period_from: updatedEvent.period_from,
          period_to: updatedEvent.period_to,
          number_of_hours: updatedEvent.number_of_hours,
          conducted_by: updatedEvent.conducted_by,
          employees: updatedEvent.employees, // This can be an array of employee IDs or omitted if no changes
        };
  
        // Send the update request to the server
        const response = await apiService.post('manageTraining/editTraining', payload);
  
        // If successful, update the event in the state
        commit('updateEventInState', response.data);
  
        // Additional logic for successful update...
      } catch (error) {
        console.error('Event update error:', error);
        // Error handling...
      } finally {
        commit('setIsEditingEvent', false); // Reset loading state
      }
    },
    
    async fetchagentData({ commit }) {
        try {
          const response = await apiService.post('materialRequisition/getAgentData');
          commit('setagentData', response.data.personal_information);
        } catch (error) {
          console.error(error);
        }
      },
      

      async fetchdepartmentData({ commit }) {
        try {
          const response = await apiService.post('materialRequisition/getDepartmentData');
          commit('setdepartmentData', response.data.department);
        } catch (error) {
          console.error(error);
        }
      },

      async fetchprovinceData({ commit }) {
        try {
          const response = await apiService.post('materialRequisition/getProvinceData');
          commit('setprovinceData', response.data.provincial_office);
        } catch (error) {
          console.error(error);
        }
      },
      
      async fetchregionData({ commit }) {
        try {
          const response = await apiService.post('materialRequisition/getRegionData');
          commit('setregionData', response.data.regional_office);
        } catch (error) {
          console.error(error);
        }
      },

      async deleteItem({ commit }, itemId) {
        try {
          // Call your API endpoint using Axios
          const response = await apiService.post(`/manageInventory/archiveInventory/${itemId}`, {
            id: itemId // Include the body if necessary
          });
    
          // Check the response status and handle accordingly
          if (response.status !== 200) {
            throw new Error('Error archiving item');
          }
    
          const data = response.data;
    
          // You might want to commit a mutation to update your state here
          // For example:
          // commit('REMOVE_ITEM_FROM_STATE', itemId);
    
          return data; // Or handle the response as needed
        } catch (error) {
          console.error('Error in deleteItem action:', error);
          throw error; // Rethrow the error for further handling
        }
      },

      async getInventoryData({ commit }) {
        try {
            commit('setLoading', true);
            const response = await apiService.post('/manageInventory/getInventoryData');
            const activeData = response.data.Active;
            const archivedData = response.data.Archive;
    
            // Commit both active and archived data to a single mutation
            commit('setFilteredProcurementData', { activeData, archivedData });
    
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            commit('setLoading', false);
        }
    },

    async getTrainingByTitle({ commit }, title) {
      try {
        const response = await apiService.get(`manageTraining/getTrainingByTitle/${title}`);
        commit('SET_TRAINING', response.data.training);
      } catch (error) {
        console.error('Error fetching training data:', error);
      }
    },
    
    async fetchEmployeeInfo({ commit }) {
      try {
        // Replace `apiService.post` with the actual API call to your CI4 backend.
        const response = await apiService.post('manageTraining/getEmployeeInfo');
        commit('setEmployeeInfo', response.data);
      } catch (error) {
        console.error(error);
      }
    }
      
      
};
