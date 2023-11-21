export const mutations = {
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
    resetFormData(state) {
        // Set formData to its initial state
        state.formData = {
          page1: { /* ... initial page1 fields ... */ },
          page2: { /* ... initial page2 fields ... */ },
          page3: { /* ... initial page3 fields ... */ },
          page4: { /* ... initial page4 fields ... */ },
          page5: { /* ... initial page5 fields ... */ },
          page6: { /* ... initial page2 fields ... */ },
          page7: { /* ... initial page7 fields ... */ },
          page8: { /* ... initial page8 fields ... */ },
          page9: { /* ... initial page9 fields ... */ },
          // ... all other pages to their initial state
        };
    },
    setIsFetchingData(state, isFetching) {
    state.isFetchingData = isFetching;
    },
    setData(state, data) {
    // Assuming the API returns data in a structured format
    // that matches the keys in `dropdownData`
    state.dropdownData = {
        ...state.dropdownData,
        ...data
    };
    
    },
    setInventoryData(state, data) {
        state.inventoryData = data;
      },
      
      setProcurementData(state, payload) {
        state.procurementData = payload;
      },

      setLoading(state, isLoading) {
        state.isLoading = isLoading;
      },
      setTrainingData(state, trainingData) {
        state.training = trainingData;
      },
      setIsAddingEvent(state, isLoading) {
        state.loadingStates.isAddingEvent = isLoading;
    },
    addEventToState(state, event) {
        state.events.push(event);
    },
    setagentData(state, data) {
        state.agentData = data;
      },
      setdepartmentData(state, data) {
        state.departmentData = data;
      },
      setprovinceData(state, data) {
        state.provinceData = data;
      },
      setregionData(state, data) {
        state.regionData = data;
      },

      setFilteredProcurementData(state, { activeData, archivedData }) {
        state.activeProcurementData = activeData;
        state.archivedProcurementData = archivedData;
    },
};
