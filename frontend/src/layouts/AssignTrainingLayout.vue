<script setup>
import PageWrapNew from '@/components/PageWrapNew.vue'
import Breadcrumb from '@/components/Breadcrumb.vue'
import BaseCard from '@/components/BaseCard.vue'

const myBreadcrumbs = [
{
href: '#',
text: 'Home',
iconPath: 'M19.707 9.293l-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z',
iconViewBox: '0 0 20 20',
active: false
},
{ href: '#', text: 'Projects', active: false },
{ href: '#', text: 'Flowbite', active: true },
];
</script>

<template>
    <PageWrapNew>
        <template #header>
            <Breadcrumb :breadcrumbs="myBreadcrumbs"/>
        </template>

        <BaseCard class="h-[72vh]">
            <router-view />
        </BaseCard>
    </PageWrapNew>
</template>
