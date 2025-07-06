<template>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Contact</h1>
    <Form :contact="contact" :submitLabel="'Update'" :onSubmit="submit" />
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Form from './Form.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({ contact: Object })

const submit = (form) => {
  form.put(`/contacts/${props.contact.id}`)
}
</script>
