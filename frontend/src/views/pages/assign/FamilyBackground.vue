<script setup>
import Button from '@/components/Button.vue';
</script>

<template>
    Family Background

    <Button :to="{ name: 'Personal Information' }">
  Back
</Button>

<Button :to="{ name: 'Educational Background' }">
  Next
</Button>
</template>
