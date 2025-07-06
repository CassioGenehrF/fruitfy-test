<template>
  <transition name="slide-fade">
    <div
      v-if="message"
      class="fixed top-5 right-5 max-w-sm w-full rounded-lg shadow-lg p-4 flex items-center gap-3 z-50"
      :class="toastClass"
    >
      <component :is="icon" class="w-6 h-6 flex-shrink-0" />
      <span class="text-sm font-medium">{{ message }}</span>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/outline'

const flash = computed(() => usePage().props?.flash || {})
const message = ref(null)
const type = ref('success')

watch(
  () => [flash.value.success, flash.value.error],
  ([success, error]) => {
    if (success) {
      message.value = success
      type.value = 'success'
    } else if (error) {
      message.value = error
      type.value = 'error'
    }

    if (message.value) {
      setTimeout(() => {
        message.value = null
      }, 5000)
    }
  },
  { immediate: true, deep: true }
)

const toastClass = computed(() => {
  return {
    'bg-green-100 text-green-800': type.value === 'success',
    'bg-red-100 text-red-800': type.value === 'error',
  }
})

const icon = computed(() => {
  return type.value === 'error' ? XCircleIcon : CheckCircleIcon
})
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.4s ease;
}
.slide-fade-leave-active {
  transition: opacity 0.3s ease;
}
.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}
.slide-fade-leave-to {
  opacity: 0;
}
</style>
