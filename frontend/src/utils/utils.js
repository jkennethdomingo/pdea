export function getStoredAuthData() {
    const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
    return authDataString ? JSON.parse(authDataString) : null;
}

export function transformFormData(formData) {
    const transformedData = {};

    Object.keys(formData).forEach(page => {
        Object.keys(formData[page]).forEach(field => {
            // Check if the field is an array and handle it accordingly
            if (Array.isArray(formData[page][field])) {
                // If the field is an array, we need to preserve the array structure
                transformedData[field] = formData[page][field].map(item => ({ ...item }));
            } else {
                // For non-array fields, assign them as before
                transformedData[field] = formData[page][field];
            }
        });
    });

    return transformedData;
}

