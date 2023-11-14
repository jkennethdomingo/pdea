<script setup>
import { useStore } from 'vuex';
import Button from '@/components/Button.vue';

const store = useStore();

const resetForm = () => {
    store.commit('resetFormData');
};
</script>

<template>
    <div>
        Questions and Others

        <Button @click="resetForm">
            Reset Form
        </Button>

        <Button :to="{ name: 'Other Information' }">
            Back
        </Button>
    </div>
</template>
