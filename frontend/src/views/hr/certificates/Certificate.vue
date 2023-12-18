<template>
    <div class="absolute bottom-90 right-10 flex space-x-2 p-0">
      <!-- Print icon button -->
      <button @click="printCertificate" class="p-0 rounded dark:text-gray-200 text-gray-600 hover:text-gray-400 dark:hover:text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="currentColor" d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z"/>
        </svg>
      </button>
      <!-- Save Image icon button -->
      <button @click="saveAsImage" class="p-2 rounded dark:text-gray-200 text-gray-600 hover:text-gray-400 dark:hover:text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="currentColor" d="M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15q0-1.25-.875-2.125T12 12q-1.25 0-2.125.875T9 15q0 1.25.875 2.125T12 18m-6-8h9V6H6z"/>
        </svg>
      </button>
    </div>

  <div id="certificate" class="mx-auto bg-[#DDE6ED] dark:bg-gray-600 p-8 rounded-md shadow-md text-center w-full h-[95%] bg-cover bg-center bg-no-repeat"
       style="background-image: url('last.png');">
    
    <div class="mb-2 flex justify-center">
      <img src="@/assets/logo.png" alt="PDEA Logo" class="h-20">
    </div>

    <h3 class="italic text-lg mb-4">This</h3>
    <h1 class="text-4xl mb-4" contenteditable="true">Certificate of Achievement</h1>
    <h3 class="italic text-lg mb-4">is presented to</h3>
    <h3 class="text-4xl font-bold mb-6 underline" contenteditable="true">SHIELA MARIE C. CHAY</h3>
    <h3 class="text-lg" contenteditable="true">for her active participation during the conduct of <br>
      <span class="font-semibold" contenteditable="true">Mental Health Awareness Lecture</span>.</h3>
    <h3 class="text-lg mb-6">held on <span class="underline" contenteditable="true">October 10, 2023, at PDEA Conference Room, Sta. Isabel, Calapan City, Oriental Mindoro</span></h3>
    <h3 class="text-lg mb-12" contenteditable="true">Given this 10<sup>th</sup> day of <span class="underline" contenteditable="true">October, 2023</span></h3>

    <h2 class="text-lg font-bold underline" contenteditable="true">DIR III GIL CESARIO P. CASTRO</h2>
    <h2 contenteditable="true">Regional Director</h2>
  </div>
</template>

<script setup>
function printCertificate() {
  window.print();
}
</script>

<style>
  /* Print-specific styles */
  @media print {
    body * {
      display: none; /* Hide all elements by default */
    }
    #certificate, #certificate * {
      display: block; /* Display the certificate and its children */
    }
    #certificate {
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 20mm;
      box-shadow: none; /* Remove shadows */
      background-image: none; /* Background images do not print by default */
    }
    #certificate img {
      display: block; /* Ensure images are displayed */
    }
  }
</style>
