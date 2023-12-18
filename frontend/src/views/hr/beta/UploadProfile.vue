<template>
  <div>
    <input type="file" ref="fileInput" @change="handleFileChange" />
    <div v-if="previewUrl">
      <h4>Preview:</h4>
      <img :src="previewUrl" alt="File Preview" />
    </div>
    <button @click="uploadFile">Upload</button>
    <button @click="handleLogout">Logout</button> <!-- Logout button added -->
  </div>
</template>

<script setup>
import { ref } from 'vue';
import apiService from '@/composables/axios-setup'; // Adjust the path based on your project structure
import { checkToken } from '@/utils/auth';
import { useStore } from 'vuex';

const previewUrl = ref(null);
const fileInput = ref(null);
const store = useStore();

const handleFileChange = () => {
  const file = fileInput.value.files[0];
  if (file) {
    displayFilePreview(file);
  } else {
    previewUrl.value = null;
    console.error('No file selected');
  }
};

const displayFilePreview = (file) => {
  const reader = new FileReader();
  reader.onload = (event) => {
    previewUrl.value = event.target.result;
  };
  reader.readAsDataURL(file);
};

const uploadFile = () => {
  const file = fileInput.value.files[0];
  if (file) {
    uploadFileToServer(file);
  } else {
    previewUrl.value = null;
    console.error('No file selected');
  }
};

const uploadFileToServer = (file) => {
  const formData = new FormData();
  formData.append('file', file);
  apiService.post('beta/doUpload', formData)
    .then(response => {
      console.log('File uploaded successfully', response.data);
    })
    .catch(error => {
      console.error('Error uploading file', error);
    });
};

const handleLogout = async () => {
  try {
    await checkToken(store); // Assuming checkToken handles the logout process
    console.log('Logout successful');
    // Redirect or update UI as needed after successful logout
  } catch (error) {
    console.error('Error during logout', error);
  }
};
</script>
