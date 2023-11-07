<script setup>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import PageWrapNew from '@/components/PageWrapNew.vue';
import Breadcrumb from '@/components/Breadcrumb.vue';
import BaseCard from '@/components/BaseCard.vue';

const router = useRouter();
const route = useRoute();

function generateBreadcrumbs(route) {
  const breadcrumbs = [
    {
      name: 'Assign Training Overview', // route name for "Overview"
      text: 'Overview',
      active: false // it's never active because it's the base breadcrumb
    }
  ];

  // Check if the current route is a child of "Assign Training" (excluding Overview itself)
  if (route.name !== 'Assign Training Overview') {
    breadcrumbs.push({
      name: route.name, // the current route name
      text: route.meta.breadcrumbTitle || route.name, // you might use a meta field for a nicer title, or fallback to the route name
      active: true // current route is always active
    });
  }

  return breadcrumbs;
}

const myBreadcrumbs = computed(() => generateBreadcrumbs(route));
</script>

<template>
  <PageWrapNew>
    <template #header>
      <Breadcrumb :breadcrumbs="myBreadcrumbs" />
    </template>
    <BaseCard class="h-[72vh]">
      <router-view />
    </BaseCard>
  </PageWrapNew>
</template>
