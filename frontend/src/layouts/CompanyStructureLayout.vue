<script setup>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import PageWrapNew from '@/components/PageWrapNew.vue';
import BaseCard from '@/components/BaseCard.vue';

const router = useRouter();
const route = useRoute();


</script>

<template>
  <PageWrapNew>
    <template #header>
      <BaseCard class="h-[72vh] overflow-y-scroll">
      <router-view />
    </BaseCard>
    </template>
  </PageWrapNew>
</template>
