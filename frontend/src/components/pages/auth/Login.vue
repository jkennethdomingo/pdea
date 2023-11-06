<template>
    <form @submit.prevent="$emit('submit')">
        <div class="grid gap-6">
            <!-- Email input -->
            <div class="space-y-2">
                <Label for="email" value="Email" />
                <InputIconWrapper icon="mdi:email-outline">
                    <Input
                        withIcon
                        id="email"
                        type="email"
                        class="block w-full"
                        placeholder="Email"
                        v-model="loginForm.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </InputIconWrapper>
            </div>

            <!-- Password input -->
            <div class="space-y-2">
                <Label for="password" value="Password" />
                <InputIconWrapper icon="mdi:lock-outline">
                    <Input
                        withIcon
                        id="password"
                        type="password"
                        class="block w-full"
                        placeholder="Password"
                        v-model="loginForm.password"
                        required
                        autocomplete="current-password"
                    />
                </InputIconWrapper>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox
                        name="remember"
                        v-model="loginForm.remember"
                    />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                <router-link
                    :to="{ name: 'ForgotPassword' }"
                    class="text-sm text-blue-500 hover:underline"
                >
                    Forgot your password?
                </router-link>
            </div>

            <!-- Login button -->
            <div>
                <Button
                    type="submit"
                    class="justify-center w-full gap-2"
                    :disabled="loginForm.processing"
                    left-icon="mdi:login"
                >
                    <span>Log in</span>
                </Button>
            </div>
        </div>
    </form>
</template>

<script>
import InputIconWrapper from '@/components/InputIconWrapper.vue';
import Label from '@/components/Label.vue';
import Input from '@/components/Input.vue';
import Checkbox from '@/components/Checkbox.vue';
import Button from '@/components/Button.vue';

export default {
  components: {
    InputIconWrapper,
    Label,
    Input,
    Checkbox,
    Button
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
