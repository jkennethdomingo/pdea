<script setup>
import { computed, ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import { initDropdowns } from 'flowbite';

// Props
const props = defineProps({
  pageNumber: Number,
  fieldSchema: Array,
  arrayName: String
});

const store = useStore();

// Dynamically access form data
const formData = computed(() => {
  const pageData = store.state.formData[`page${props.pageNumber}`];
  return pageData ? pageData[props.arrayName] : [];
});

// Initialize rowData based on the Vuex state
const rowCount = ref(formData.value.length);
const rowData = ref(formData.value);

onMounted(() => {
  initDropdowns();
  // Ensure rowCount is updated when formData is initialized or changed
  watch(formData, (newFormData) => {
    rowData.value = [...newFormData];
    rowCount.value = newFormData.length;
  }, { immediate: true });
});

watch(formData, (newValue) => {
  console.log('Form Data Updated:', newValue);
}, { deep: true });



// Watch for changes in rowCount and update rowData and Vuex store accordingly
watch(rowCount, (newCount, oldCount) => {
  if (newCount > oldCount) {
    // Add new row objects based on the field schema
    for (let i = oldCount; i < newCount; i++) {
      const newRow = {};
      props.fieldSchema.forEach(field => {
        newRow[field.name] = '';
      });
      rowData.value.push(newRow);
    }
  } else if (newCount < oldCount) {
    // Remove excess row objects
    rowData.value.splice(newCount);
  }
  // Here we update the Vuex store with the new rowData
  store.commit('updateDynamicForm', {
    page: `page${props.pageNumber}`,
    data: { [props.arrayName]: rowData.value }
  });
});

// If rowData is directly edited (e.g., user input), update the Vuex store
watch(rowData, (newRowData) => {
  // This mutation updates the Vuex store
  store.commit('updateDynamicForm', {
    page: `page${props.pageNumber}`,
    data: { [props.arrayName]: newRowData }
  });
}, { deep: true });

</script>


<template>
  <div class="max-w-sm mx-auto">
    <label for="row_count" class="block text-gray-700 text-sm dark:text-white mb-2">
      Row Count:
    </label>
    <input type="number" id="row_count" v-model.number="rowCount" class="shadow border dark:bg-dark-eval-2 rounded py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline text-center">
  </div>

  <div v-for="(row, rowIndex) in rowData" :key="rowIndex" class="flex flex-wrap -mx-3 mb-4">
    <div v-for="(field, fieldIndex) in fieldSchema" :key="fieldIndex" class="w-full px-3 mb-6 md:mb-0">
      <label :for="`field_${rowIndex}_${field.name}`" class="block text-gray-700 text-sm dark:text-white mb-2">
        {{ field.label }}:
      </label>
      <input :id="`field_${rowIndex}_${field.name}`" :type="field.type" v-model="row[field.name]" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
    </div>
  </div>
</template>
