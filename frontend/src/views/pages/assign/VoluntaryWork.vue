<script setup>
import Button from '@/components/Button.vue';
</script>

<template>
    Voluntary Work

    <Button :to="{ name: 'Work Experience' }">
  Back
</Button>

<Button :to="{ name: 'Learning And Development' }">
  Next
</Button>
</template>
