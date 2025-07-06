<template>
  <div class="min-h-screen bg-gray-100 p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-center md:text-left w-full">Contact Catalog</h1>

      <button
        @click="goToContacts"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
      >
        Manage Contacts
      </button>
    </div>

    <div class="flex flex-wrap gap-6 justify-center">
      <ContactCatalog
        v-for="contact in contacts"
        :key="contact.id"
        :contact="contact"
      />
    </div>
  </div>
</template>

<script setup>
import ContactCatalog from '@/Components/ContactCatalog.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const props = defineProps({
  contacts: Array
})

const goToContacts = () => {
  router.visit('/contacts')
}
</script>
