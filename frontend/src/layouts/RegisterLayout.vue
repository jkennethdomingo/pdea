<script setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';
import PageWrapNew from '@/components/layout/PageWrapNew.vue';
import BaseCard from '@/components/ui/BaseCard.vue';

const store = useStore();

function logFormData() {
  console.log(store.state.formData);
}

// Example: Call logFormData when the component is mounted
onMounted(() => {
  logFormData();
});
</script>

<template>
  <PageWrapNew>
    <template #header>
      <!-- Optional: Add a button to trigger logFormData -->
      <!-- <button @click="logFormData">Log Form Data</button> -->
    </template>
    <BaseCard class="min-h-[100vh]">
      <router-view />
    </BaseCard>
  </PageWrapNew>
</template>
