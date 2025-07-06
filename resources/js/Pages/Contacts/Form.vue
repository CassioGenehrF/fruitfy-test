<template>
  <form @submit.prevent="submit" class="space-y-4">
    <div>
      <label for="name" class="block text-sm font-medium mb-1">Name</label>
      <input
        id="name"
        v-model="form.name"
        type="text"
        class="input"
        :class="{ 'border-red-500': form.errors.name }"
      />
      <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">
        {{ form.errors.name[0] }}
      </p>
    </div>

    <div>
      <label for="email" class="block text-sm font-medium mb-1">Email</label>
      <input
        id="email"
        v-model="form.email"
        type="email"
        class="input"
        :class="{ 'border-red-500': form.errors.email }"
      />
      <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">
        {{ form.errors.email[0] }}
      </p>
    </div>

    <div>
      <label for="phone" class="block text-sm font-medium mb-1">Phone</label>
      <input
        id="phone"
        v-model="form.phone"
        type="tel"
        class="input"
        :class="{ 'border-red-500': form.errors.phone }"
      />
      <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">
        {{ form.errors.phone[0] }}
      </p>
    </div>

    <div>
      <label for="birthdate" class="block text-sm font-medium mb-1">Birth date</label>
      <input
        id="birthdate"
        v-model="form.birthdate"
        type="date"
        class="input"
        :class="{ 'border-red-500': form.errors.birthdate }"
      />
      <p v-if="form.errors.birthdate" class="text-red-500 text-sm mt-1">{{ form.errors.birthdate }}</p>
    </div>

    <div class="flex justify-end gap-2 pt-4">
      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
      >
        {{ form.processing ? 'Saving...' : submitLabel }}
      </button>

      <button
        type="button"
        @click="router.visit('/contacts')"
        class="text-gray-600 hover:text-gray-800"
      >
        Cancel
      </button>
    </div>
  </form>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
  contact: Object,
  submitLabel: {
    type: String,
    default: 'Save',
  },
  onSubmit: Function,
})

const form = useForm({
  name: props.contact?.name || '',
  email: props.contact?.email || '',
  phone: props.contact?.phone || '',
  birthdate: props.contact?.birthdate || '',
})

const submit = () => {
  props.onSubmit(form)
}
</script>

<style scoped>
.input {
  @apply w-full border-gray-300 rounded px-3 py-2 shadow-sm border focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition;
}
</style>
