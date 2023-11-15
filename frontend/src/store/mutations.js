export const mutations = {
    setAuth(state, payload) {
        state.token = payload.token;
        state.userRole = payload.role;
    },
    resetFormData(state) {
        // Reset the fields for page1
        Object.keys(state.formData.page1).forEach(key => {
            if (typeof state.formData.page1[key] === 'object') {
                Object.keys(state.formData.page1[key]).forEach(innerKey => {
                    state.formData.page1[key][innerKey] = '';
                });
            } else {
                state.formData.page1[key] = '';
            }
        });

        // Reset the fields for other pages (page2, page3, etc.)
        // Repeat the above process for each page in your formData

        // Example for resetting page3
        Object.keys(state.formData.page3).forEach(key => {
            Object.keys(state.formData.page3[key]).forEach(innerKey => {
                state.formData.page3[key][innerKey] = '';
            });
        });

        // Reset page4 which is an array of objects
        state.formData.page4 = state.formData.page4.map(item => {
            return Object.keys(item).reduce((acc, key) => {
                acc[key] = '';
                return acc;
            }, {});
        });

        // Add similar logic for pages 5 to 9
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
    },
    updateDynamicForm(state, { page, data }) {
        if (Array.isArray(data)) {
            // If the data is an array, replace the entire array for the page
            state.formData[page] = data;
        } else {
            // If the data is not an array, perform an object merge
            state.formData[page] = { ...state.formData[page], ...data };
        }
    },
};
