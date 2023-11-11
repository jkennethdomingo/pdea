<script setup>
import Button from '@/components/Button.vue';
</script>

<template>
    Civil Service Eligibility

    <Button :to="{ name: 'Educational Background' }">
  Back
</Button>

<Button :to="{ name: 'Work Experience' }">
  Next
</Button>
</template>
