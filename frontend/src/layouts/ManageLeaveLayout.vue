<script setup>

import PageWrapNew from '@/components/layout/PageWrapNew.vue';
import BaseCard from '@/components/ui/BaseCard.vue';

</script>

<template>
  <PageWrapNew>
    <template #header>
      
    </template>
    <BaseCard >
      <router-view />
    </BaseCard>
  </PageWrapNew>
</template>
