<template>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Create Contact</h1>
    <Form :submitLabel="'Create'" :onSubmit="submit" />
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Form from './Form.vue'

defineOptions({ layout: AppLayout })

const submit = (form) => {
  form.post('/contacts');
}
</script>
