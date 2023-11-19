<script setup>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import LG_BaseCard from '@/components/ui/LG_BaseCard.vue';
import PageWrapNew from '@/components/layout/PageWrapNew.vue';
import Breadcrumb from '@/components/layout/Breadcrumb.vue';

const router = useRouter();
const route = useRoute();


</script>

<template>
    <PageWrapNew>
        <template #header>
    </template>
      <LG_BaseCard class="h-[80vh] overflow-hidden">
      <router-view />
    </LG_BaseCard>
    </PageWrapNew>
    
</template>
