<script setup>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import LG_BaseCard from '@/components/LG_BaseCard.vue';

const router = useRouter();
const route = useRoute();


</script>

<template>
      <LG_BaseCard class="h-[100vh] overflow-y-scroll">
      <router-view />
    </LG_BaseCard>
</template>
