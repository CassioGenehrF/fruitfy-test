<template>
  <div class="min-h-screen bg-gray-100 text-gray-900">
    <header class="w-full flex justify-between items-center h-14 bg-[#0098D4] backdrop-blur-sm p-2 px-4 md:px-10">
      <div class="max-w-4xl mx-auto flex justify-center items-center">
        <img src="https://app.fruitfy.io/assets/logo_abacaxi_amarelo.png" alt="Fruitfy Logo" class="h-12">
      </div>
    </header>

    <Toast />
    <slot />
  </div>
</template>

<script setup>
import Toast from '@/Components/Toast.vue'
</script>
