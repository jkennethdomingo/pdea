<script setup>
import { computed, ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { initDropdowns } from 'flowbite';
import { useRouter } from 'vue-router';

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
    // Success feedback (toast, modal, etc.) goes here
  } catch (error) {
    console.error('Error submitting form data:', error);
    // Error feedback (toast, modal, etc.) goes here
  } finally {
    isSubmitting.value = false;
  }
};

const childrenCount = ref(0);
const childrenData = ref([]);

// Define a computed property for children data in formData
const childrenFormData = computed({
  get: () => formData.value.children,
  set: (newChildren) => { formData.value.children = newChildren; }
});

// Update childrenData watch to modify formData
watch(childrenData, (newChildrenData) => {
  childrenFormData.value = newChildrenData;
}, { deep: true });

// Watch the childrenCount and update childrenData accordingly
watch(childrenCount, (newCount) => {
  childrenData.value = Array.from({ length: newCount }, (_, index) => childrenData.value[index] || { full_name: '', date_of_birth: '' });
});

const router = useRouter();

const goToPersonalInfo = () => {
  router.push({ name: 'Personal Information' });
};
const goToEducBg = () => {
  router.push({ name: 'Educational Background' });
};
const goToCvEligibility = () => {
  router.push({ name: 'Civil Service Eligibility' });
};
const goToWorkExp = () => {
  router.push({ name: 'Work Experience' });
};
const goToVolWork = () => {
  router.push({ name: 'Voluntary Work' });
};
const goToLearnDev = () => {
  router.push({ name: 'Learning And Development' });
};

</script>

<template>
<form @submit.prevent="handleSubmit">
  <ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToPersonalInfo">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S1
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Personal Information</h3>
        </span>
    </li>
    <li class="flex items-center text-green-600 dark:text-green-500 space-x-2.5 rtl:space-x-reverse cursor-pointer">
        <span class="flex items-center justify-center w-8 h-8 border border-green-600 rounded-full shrink-0 dark:border-green-500">
            S2
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Family Background</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToEducBg">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S3
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Educational Background</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToCvEligibility">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S4
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Civil Service Eligibility</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToWorkExp">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S5
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Work Experience</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToVolWork">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S6
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Voluntary Work</h3>
        </span>
    </li>
    <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse cursor-pointer" @click="goToLearnDev">
        <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            S7
        </span>
        <span>
            <h3 class="font-semibold leading-tight">Learning And Development</h3>
        </span>
    </li>
</ol>

<hr class="my-3 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

  <p class="text-xl text-gray-900 dark:text-white font-bold">Family Background</p>
    <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Surname -->
      <div>
        <label for="spouse_surname" class="block text-gray-700 text-sm dark:text-white mb-2">Spouse's Surname:</label>
        <input type="text" id="spouse_surname" v-model="formData.spouse_surname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- First Name -->
      <div>
        <label for="spouse_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">First Name:</label>
        <input type="text" id="spouse_first_name" v-model="formData.spouse_first_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Middle Name -->
      <div>
        <label for="spouse_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Middle Name:</label>
        <input type="text" id="spouse_middle_name" v-model="formData.spouse_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Name Extension -->
      <div>
        <label for="spouse_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
        <input type="text" id="spouse_name_extension" v-model="formData.spouse_name_extension" placeholder="e.g., Jr, Sr" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- occupation -->
      <div>
        <label for="spouse_occupation" class="block text-gray-700 text-sm dark:text-white mb-2">Occupation:</label>
        <input type="text" id="spouse_occupation" v-model="formData.spouse_occupation" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- Business Name -->
      <div>
        <label for="spouse_employer_business_name" class="block text-gray-700 text-sm dark:text-white mb-2">Business Name:</label>
        <input type="text" id="spouse_employer_business_name" v-model="formData.spouse_employer_business_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- address -->
      <div>
        <label for="spouse_business_address" class="block text-gray-700 text-sm dark:text-white mb-2">Business Address:</label>
        <input type="text" id="spouse_business_address" v-model="formData.spouse_business_address" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- telephone -->
      <div>
        <label for="spouse_telephone_no" class="block text-gray-700 text-sm dark:text-white mb-2">Telephone Number:</label>
        <input type="text" id="spouse_telephone_no" v-model="formData.spouse_telephone_no" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>


   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- Father Name -->
      <div>
        <label for="father_surname" class="block text-gray-700 text-sm dark:text-white mb-2">Father Name:</label>
        <input type="text" id="father_surname" v-model="formData.father_surname" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- First Name -->
      <div>
        <label for="father_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">Father Firstname:</label>
        <input type="text" id="father_first_name" v-model="formData.father_first_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Middle Name -->
      <div>
        <label for="father_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2"> Father Middlename:</label>
        <input type="text" id="father_middle_name" v-model="formData.father_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Name Extension -->
      <div>
        <label for="father_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
        <input type="text" id="father_name_extension" v-model="formData.father_name_extension" placeholder="e.g., Jr, Sr" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   
   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

   <div class="mb-4 grid grid-cols-4 gap-4">
      <!-- mother maiden name -->
      <div>
        <label for="mother_maiden_name" class="block text-gray-700 text-sm dark:text-white mb-2">Mother Maiden Name:</label>
        <input type="text" id="mother_maiden_name" v-model="formData.mother_maiden_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white  leading-tight  focus:outline-none focus:shadow-outline">
      </div>
      <!-- First Name -->
      <div>
        <label for="mother_first_name" class="block text-gray-700 text-sm dark:text-white mb-2">Mother Firstname:</label>
        <input type="text" id="mother_first_name" v-model="formData.mother_first_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Mother Middlename -->
      <div>
        <label for="mother_middle_name" class="block text-gray-700 text-sm dark:text-white mb-2">Mother Middlename :</label>
        <input type="text" id="mother_middle_name" v-model="formData.mother_middle_name" class="shadow border  dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <!-- Name Extension -->
      <div>
        <label for="father_name_extension" class="block text-gray-700 text-sm dark:text-white mb-2">Name Extension:</label>
        <input type="text" id="mother_name_extension" v-model="formData.mother_name_extension" placeholder="e.g., Jr, Sr" class="shadow border  dark:bg-dark-eval-2 rounded w-32 py-2 px-3 text-gray-700  dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
   </div>

   <hr class="my-12 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

  <div class="container mx-auto px-4">
    <div class="max-w-sm mx-auto">
      <label for="children_count" class="block text-gray-700 text-sm dark:text-white mb-2">Children Quantity:</label>
      <input type="number" id="children_count" v-model.number="childrenCount" class="shadow border dark:bg-dark-eval-2 rounded py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline text-center">
    </div>
    
    <div v-for="(child, index) in childrenData" :key="index" class="flex flex-wrap -mx-3 mb-4">
      <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label :for="'child_name_' + index" class="block text-gray-700 text-sm dark:text-white mb-2">Child {{ index + 1 }} Full Name:</label>
        <input :id="'child_name_' + index" type="text" v-model="child.full_name" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div class="w-full md:w-1/2 px-3">
        <label :for="'child_dob_' + index" class="block text-gray-700 text-sm dark:text-white mb-2">Date of Birth (mm/dd/yyyy):</label>
        <input :id="'child_dob_' + index" type="date" v-model="child.date_of_birth" class="shadow border dark:bg-dark-eval-2 rounded w-full py-2 px-3 text-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
      </div>
    </div>
  </div>
</form>
  

<div class="flex justify-between">
  <div>
    <Button :to="{ name: 'Personal Information' }">
      Back
    </Button>
  </div>
  <div>
    <Button :to="{ name: 'Educational Background' }">
      Next
    </Button>
  </div>
</div>

</template>
