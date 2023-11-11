<script setup>
import Button from '@/components/Button.vue';
</script>

<template>

Other Information

    <Button :to="{ name: 'Learning And Development' }">
  Back
</Button>

<Button :to="{ name: 'Questions And Others' }">
  Next
</Button>
</template>
