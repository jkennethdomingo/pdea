<template>
  <div>
    <input type="file" ref="fileInput" @change="handleFileChange" />
    <div v-if="previewUrl">
      <h4>Preview:</h4>
      <img :src="previewUrl" alt="File Preview" />
    </div>
    <button @click="uploadFile">Upload</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import apiService from '@/composables/axios-setup'; // Adjust the path based on your project structure

const previewUrl = ref(null);
const fileInput = ref(null);

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

  // Use the axios instance from your setup
  apiService.post('beta/doUpload', formData)
    .then(response => {
      console.log('File uploaded successfully', response.data);
    })
    .catch(error => {
      console.error('Error uploading file', error);
    });
};
</script>
