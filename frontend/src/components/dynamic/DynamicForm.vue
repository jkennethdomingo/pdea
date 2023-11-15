<script setup>
import { computed, ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { initDropdowns } from 'flowbite';

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
  <div class="max-w-sm mx-auto">
    <label for="children_count" class="block text-gray-700 text-sm dark:text-white mb-2">
      Children Quantity:
    </label>
    <input type="number" id="children_count" v-model.number="childrenCount" class="shadow border dark:bg-dark-eval-2 rounded py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline text-center">
  </div>

  <div v-for="(child, index) in childrenData" :key="index" class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label :for="'child_name_' + index" class="block text-gray-700 text-sm dark:text-white mb-2">
        Child {{ index + 1 }} Full Name:
      </label>
      <input :id="'child_name_' + index" type="text" v-model="child.full_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="w-full md:w-1/2 px-3">
      <label :for="'child_dob_' + index" class="block text-gray-700 text-sm dark:text-white mb-2">
        Date of Birth (mm/dd/yyyy):
      </label>
      <input :id="'child_dob_' + index" type="date" v-model="child.date_of_birth" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
  </div>
</template>