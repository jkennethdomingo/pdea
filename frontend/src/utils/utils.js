export function getStoredAuthData() {
    const authDataString = localStorage.getItem('authData') || sessionStorage.getItem('authData');
    return authDataString ? JSON.parse(authDataString) : null;
}

export function transformFormData(formData) {
    const transformedData = {};

    Object.keys(formData).forEach(page => {
        Object.keys(formData[page]).forEach(field => {
            transformedData[field] = formData[page][field];
        });
    });

    return transformedData;
}
