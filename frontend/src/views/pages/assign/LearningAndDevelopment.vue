<script setup>
import Button from '@/components/Button.vue';
</script>

<template>

    Learning And Development

    <Button :to="{ name: 'Voluntary Work' }">
  Back
</Button>

<Button :to="{ name: 'Other Information' }">
  Next
</Button>
</template>
