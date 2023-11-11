<script setup>

import PageWrapNew from '@/components/PageWrapNew.vue';
import BaseCard from '@/components/BaseCard.vue';

</script>

<template>
  <PageWrapNew>
    <template #header>
      
    </template>
    <BaseCard class="h-[72vh] overflow-y-scroll">
      <router-view />
    </BaseCard>
  </PageWrapNew>
</template>
