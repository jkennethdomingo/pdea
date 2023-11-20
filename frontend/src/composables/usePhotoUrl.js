import { ref } from 'vue';

export function usePhotoUrl() {
  // Base URL for photos
  const baseUrl = ref('http://backend.test/uploads/');

  // Method to get the full URL for a photo
  const getPhotoUrl = (photo) => {
    return `${baseUrl.value}${photo}`;
  };

  return {
    baseUrl,
    getPhotoUrl
  };
}
