<script setup>
import Button from '@/components/Button.vue';
</script>

<template>
    Educational Background

    <Button :to="{ name: 'Family Background' }">
  Back
</Button>

<Button :to="{ name: 'Civil Service Eligibility' }">
  Next
</Button>
</template>
