<template>
    <section class="gradient-form h-full bg-neutral-200 dark:bg-neutral-700">
  <div class="container h-full p-10">
    <div
      class="g-6 flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200">
      <div class="w-full">
        <div
          class="block rounded-lg bg-white shadow-lg dark:bg-neutral-800">
          <div class="g-0 lg:flex lg:flex-wrap">
            <!-- Left column container-->
            <div class="px-4 md:px-0 lg:w-6/12">
              <div class="md:mx-6 md:p-12">
                <!--Logo-->
                <div class="text-center">
                  <img
                    class="mx-auto w-40"
                    img :src="require('@/assets/logo.png')"
                    alt="logo" />
                  <h4 class="mb-12 mt-1 pb-1 text-xl font-semibold">
                    Welcome Back
                  </h4>
                </div>
                
                <form>
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                    <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-700 dark:focus:border-green-700 dark:shadow-sm-light" placeholder="name@pdea.gov.ph" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                    <input type="password" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-700 dark:focus:border-green-700 dark:shadow-sm-light" required>
                </div>
                <div class="flex items-center justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5 mb-6">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                          </div>
                      </div>
                      <a href="#" class="text-blue-500 mb-6 text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                  </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Login</button>
                </form>

              </div>
            </div>

            <!-- Right column container with background and description-->
            <div
              class="flex items-center rounded-b-lg lg:w-6/12 lg:rounded-r-lg lg:rounded-bl-none"
              style="background: linear-gradient(to right, #006E4E, #006E4E, #006346, #006346)">
              <div class="px-4 py-6 text-white md:mx-6 md:p-12">   
                <figure class="max-w-screen-md mx-auto text-center">
                    <svg class="w-7 h-7 mx-auto mb-3 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 14">
                        <path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z"/>
                    </svg>
                    <blockquote>
                        <p class="text-xl italic font-medium text-gray-900 dark:text-white">
                            "PDEA MIMAROPA Region IV-B is dedicated to ensuring 
                            a drug-free MIMAROPA through rigorous enforcement 
                            and prevention efforts in the region"</p>
                    </blockquote>
                    <figcaption class="flex items-center justify-center mt-6 space-x-3">
                    </figcaption>
                </figure>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <PageFooter />
</section>
</template>

<script>
import InputIconWrapper from '@/components/InputIconWrapper.vue';
import Label from '@/components/Label.vue';
import Input from '@/components/Input.vue';
import Checkbox from '@/components/Checkbox.vue';
import Button from '@/components/Button.vue';
import PageFooter from '@/components/PageFooter.vue';
export default {
  components: {
    InputIconWrapper,
    Label,
    Input,
    Checkbox,
    Button,
    PageFooter
  },
  props: {
    loginForm: {
      type: Object,
      required: true
    }
  },
  emits: ['submit']
  // ...other options
}
</script>

<style>
/* Your styles here */
</style>
