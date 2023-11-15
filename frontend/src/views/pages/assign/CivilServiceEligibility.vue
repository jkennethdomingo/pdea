<script setup>
import { computed, ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import { initDropdowns } from 'flowbite';
import DynamicForm from '@/components/dynamic/DynamicForm.vue';

const store = useStore();

onMounted(() => {
  initDropdowns();
});

const formData = computed(() => store.state.formData.page2);

watch(formData, (newValue) => {
  console.log('Form Data Updated:', newValue);
}, { deep: true });

const isSubmitting = ref(false);
const handleSubmit = async () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;

  try {
    await store.dispatch('submitFormData');
    // Success feedback
  } catch (error) {
    console.error('Error submitting form data:', error);
    // Error feedback
  } finally {
    isSubmitting.value = false;
  }
};

const childrenCount = ref(0);
const childrenData = ref([]);

// Update the childrenData array based on childrenCount
watch(childrenCount, (newCount) => {
  if (newCount > childrenData.value.length) {
    // Add new child objects
    for (let i = childrenData.value.length; i < newCount; i++) {
      childrenData.value.push({ full_name: '', date_of_birth: '' });
    }
  } else {
    // Remove excess child objects
    childrenData.value.splice(newCount);
  }
});

// Update formData when childrenData changes
watch(childrenData, (newChildrenData) => {
  formData.value.children = newChildrenData;
}, { deep: true });

</script>

<template>
  <DynamicForm />

</template>
