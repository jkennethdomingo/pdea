<template>
  <div class="p-6">
    <div :class="['relative p-4 rounded-md shadow-lg dark:bg-dark-eval-3', toastBackgroundClass]">
      <div class="flex items-start gap-4">
        <span :class="['inline-flex p-1 rounded-full', iconBackgroundClass]">
          <Icon :icon="icon" aria-hidden="true" class="w-6 h-6 text-white" />
        </span>

        <Button
          @click="handleClose"
          iconOnly
          size="sm"
          variant="secondary"
          srText="Close notification"
          class="absolute right-2 top-2"
          icon="mdi:window-close"
        />

        <div class="space-y-2">
          <div :class="textVariantClass">{{ title }}</div>
          <p class="text-gray-600 dark:text-gray-400">{{ text }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, computed } from 'vue';
import { Icon } from '@iconify/vue'
import '@/toast/style.css'
import Button from '@/components/Button.vue'

export default defineComponent({
  components: {
    Icon,
    Button
  },
  props: {
    variant: {
      type: String,
      default: 'primary',
      validator(value) {
        return ['primary', 'success', 'warning', 'error', 'info'].includes(value)
      },
    },
    title: {
      type: String,
      default: 'Notification',
    },
    text: {
      type: String,
      default: null,
    },
    hideClose: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['close-toast'],
  setup(props, { emit }) {
    const toastBackgroundClass = computed(() => ({
      'bg-white': props.variant === 'primary',
      'bg-green-100': props.variant === 'success',
      'bg-yellow-100': props.variant === 'warning',
      'bg-red-100': props.variant === 'error',
      'bg-cyan-100': props.variant === 'info',
    }));

    const iconBackgroundClass = computed(() => ({
      'bg-purple-400': props.variant === 'primary',
      'bg-green-400': props.variant === 'success',
      'bg-yellow-400': props.variant === 'warning',
      'bg-red-400': props.variant === 'error',
      'bg-cyan-400': props.variant === 'info',
    }));

    const textVariantClass = computed(() => ({
      'text-purple-500': props.variant === 'primary',
      'text-green-500': props.variant === 'success',
      'text-yellow-500': props.variant === 'warning',
      'text-red-500': props.variant === 'error',
      'text-cyan-500': props.variant === 'info',
    }));

    const icon = computed(() => {
      switch (props.variant) {
        case 'primary':
          return 'mdi:check'
        case 'success':
          return 'mdi:check'
        case 'warning':
          return 'mdi:exclamation'
        case 'error':
          return 'mdi:close'
        case 'info':
          return 'mdi:help'
        default:
          return ''
      }
    });

    function handleClose() {
      emit('close-toast')
    }

    return {
      toastBackgroundClass,
      iconBackgroundClass,
      textVariantClass,
      handleClose,
      icon
    }
  }
})
</script>

<!-- Add style if needed -->
<style scoped>
@import '@/toast/style.css';
</style>
