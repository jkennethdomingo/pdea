<template> <!--TODO Backup and Restore-->
    <div>
      <button @click="backupDatabase">Backup Database</button>
      <button @click="restoreDatabase">Restore Database</button>
    </div>
  </template> 
<script>
import apiService from '@/composables/axios-setup'; // Adjust the path based on your project structure

export default {
  methods: {
    backupDatabase() {
      apiService.get('/database/backup')
        .then(response => {
          console.log('Database backup initiated', response.data);
        })
        .catch(error => {
          console.error('Error initiating database backup', error);
        });
    },
    restoreDatabase() {
      apiService.get('/database/restore')
        .then(response => {
          console.log('Database restore initiated', response.data);
        })
        .catch(error => {
          console.error('Error initiating database restore', error);
        });
    }
  }
};
</script>
  