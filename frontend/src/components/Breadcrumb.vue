<template>
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
    <li v-for="(crumb, index) in breadcrumbs" :key="index" class="inline-flex items-center">
        <a v-if="!crumb.active" :href="crumb.href" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
        <!-- Render SVG if iconPath is provided -->
        <svg v-if="crumb.iconPath" class="w-3 h-3 mr-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" :viewBox="crumb.iconViewBox">
            <path :d="crumb.iconPath"/>
        </svg>
        {{ crumb.text }}
        </a>
        <span v-else class="ml-1 text-sm font-medium text-gray-500 md:ml-1 dark:text-gray-400">{{ crumb.text }}</span>
        <!-- Breadcrumb separator -->
        <svg v-if="index < breadcrumbs.length - 1" class="w-3 h-3 ml-2.5 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
    </li>
    </ol>
</nav>
</template>

<script>
export default {
name: 'Breadcrumb',
props: {
    breadcrumbs: {
    type: Array,
    required: true
    }
}
}
</script>
  