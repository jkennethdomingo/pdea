<script setup>
import { useStore } from 'vuex';
import Button from '@/components/base/Button.vue';
import { ref } from 'vue';

const isModalOpen = ref(false);


const store = useStore();


</script>

<template>
    <div>
        Questions and Others
        <div class="border border-green-600 rounded p-4 shadow-lg my-4">
    <div class="max-w-4xl mx-auto p-4">
  <!-- Question 34 -->
  <div class="mb-8">
    <label class="block  text-black dark:text-white text-l mb-2">
     1.) Are you related by consanguinity or affinity to the appointing or recommending authority, or to chief of bureau or office or to the person who has immediate supervision over you in the Bureau or Department where you will be appointed,
    </label>
    <div class="flex flex-col space-y-4">
      <div>
        <label class="inline-flex items-center text-black dark:text-white">
          <span class="ml-2">A. within the third degree?</span>
        </label>
        <label class="inline-flex items-center ml-6">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">YES</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">NO</span>
        </label>
      </div>
      <div>
        <label class="inline-flex items-center text-black dark:text-white">
          <span class="ml-2">B. within the fourth degree (for Local Government Unit - Career Employees)?</span>
        </label>
        <label class="inline-flex items-center ml-6">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" id="yesCheckbox">
          <span class="ml-2 text-black dark:text-white">YES</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox  bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">NO</span>
        </label>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>
<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <div class="mb-4">
    <label class="block text-black dark:text-white mb-2" for="guilty">
      a. Have you ever been found guilty of any administrative offense?
    </label>
    <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
    <input id="guilty-details" name="guilty-details" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="If YES, give details:">
  </div>

  <div class="mb-4">
    <label class="block text-black dark:text-white text-l mb-2" for="charged">
      b. Have you been criminally charged before any court?
    </label>
    <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="charged-yes" name="charged" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="charged-no" name="charged" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
    <input id="charged-details" name="charged-details" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="If YES, give details:">
    <input id="charged-date" name="charged-date" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="Date Filed:">
    <input id="case-status" name="case-status" type="text" class="form-input mt-2 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm" placeholder="Status of Case/s:">
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 2 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      2.) Have you ever been convicted of any crime or violation of any law, decree, ordinance or 
      regulation by any court or tribunal?
    </label>
    <div class="flex flex-col space-y-4">
      <div>
        <label class="inline-flex items-center text-black dark:text-white">
          <span class="ml-2">b. within the fourth degree (for Local Government Unit - Career Employees)?</span>
        </label>
        <label class="inline-flex items-center ml-6">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">YES</span>
        </label>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600">
          <span class="ml-2 text-black dark:text-white">NO</span>
        </label>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>
    
<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 3 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      3.) Have you ever been separated from the service in any of the following modes: resignation, 
      retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or 
      phased out (abolition) in the public or private sector?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      a. Have you ever been a candidate in a national or local election held within the last year 
     (except Barangay election)?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
      <div class="py-4 mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      b. Have you resigned from the government service during the three (3)-month period before 
      the last election to promote/actively campaign for a national or local candidate?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
    </div>
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 4 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      4.) Have you acquired the status of an immigrant or permanent resident of another country?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, give details (country): " class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>

<hr class="my-6 h-0.5 border-t-0 bg-black opacity-10 dark:bg-white  dark:opacity-10" />

<div class="max-w-4xl mx-auto p-4">
  <!-- Question 5 -->
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
  <div class="mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      5.) Have you acquired the status of an immigrant or permanent resident of another country?
          Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons 
          (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following;
    </label>
  </div>
      <!-- A. -->
      a. Are you a member of any indigenous group?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="If YES, please specify:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
      
      <div class="py-4 mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      <!-- B -->
      b. Are you a person with disability?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="f YES, please specify ID No:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>

    <div class="py-4 mb-8">
    <label class="block text-black dark:text-white text-l mb-2">
      <!-- C -->
      C. re you a solo parent?
    </label>
    <div class="mt-2">
      <div>
        <div class="mt-2">
      <label class="inline-flex items-center">
        <input id="guilty-yes" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="yes">
        <span class="ml-2 text-black dark:text-white">Yes</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input id="guilty-no" name="guilty" type="checkbox" class="form-checkbox bg-white dark:bg-dark-eval-2 border-green-600" value="no">
        <span class="ml-2 text-black dark:text-white">No</span>
      </label>
    </div>
      </div>
      <input type="text" placeholder="f YES, please specify ID No:" class="form-input mt-1 block w-full bg-white dark:bg-dark-eval-2 border-green-600 rounded-md shadow-sm">
    </div>
  </div>
</div>
    </div>
  </div>
</div>
</div>

  

      
  <!-- Modal toggle button -->
  <button @click="isModalOpen = true" class="justify-self-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Submit
  </button>

  <!-- Main modal -->
  <div v-show="isModalOpen" id="default-modal" tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Terms of Service
          </h3>
          <button @click="isModalOpen = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and
            complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the
            Philippines.
          </p>
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            I authorize the agency head/authorized representative to verify/validate the contents stated
            herein. I agree that any misrepresentation made in this document and its attachments shall cause the
            filing of administrative/criminal case/s against me.
          </p>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button @click="isModalOpen = false" data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
          <button @click="isModalOpen = false" data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
        </div>
      </div>
    </div>
  </div>


        <Button :to="{ name: 'Other Information' }">
            Back
        </Button>
    </div>
</template>
