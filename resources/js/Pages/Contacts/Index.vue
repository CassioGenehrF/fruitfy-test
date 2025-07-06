<template>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Contacts</h1>

    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
      <div class="flex w-full md:w-1/2 gap-2">
        <input
          v-model="filters.search"
          @keyup.enter="applyFilters"
          type="text"
          placeholder="Search by name, email, or phone"
          class="border rounded px-3 py-2 w-full"
        />
        <button
          @click="applyFilters"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Search
        </button>

          <button
            @click="exportContacts"
            class="p-2 rounded hover:bg-gray-200"
            title="Export CSV"
          >
            <ArrowUpTrayIcon class="w-5 h-5 text-gray-700" />
          </button>

          <button
            @click="triggerImport"
            class="p-2 rounded hover:bg-gray-200"
            title="Import CSV"
          >
            <ArrowDownTrayIcon class="w-5 h-5 text-gray-700" />
          </button>

          <input
            ref="fileInput"
            type="file"
            accept=".csv"
            @change="handleImport"
            class="hidden"
          />
      </div>

      <div class="w-full md:w-auto flex flex-col md:flex-row items-center gap-2">
        <button
          @click="router.visit('/contacts/create')"
          class="w-full md:w-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
        >
          + New Contact
        </button>

        <button
          @click="router.visit('/')"
          class="w-full md:w-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          View Catalog
        </button>
      </div>
    </div>


    <div class="w-full overflow-x-auto">
      <table class="min-w-full border border-gray-200 rounded shadow-sm">
        <thead class="bg-gray-100">
          <tr>
            <th
              class="text-left p-3 cursor-pointer select-none"
              @click="toggleSort('is_favorite')"
            >
              #
              <span v-if="filters.sort === 'is_favorite'">
                {{ filters.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th
              class="text-left p-3 cursor-pointer select-none"
              @click="toggleSort('name')"
            >
              Name
              <span v-if="filters.sort === 'name'">
                {{ filters.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th
              class="text-left p-3 cursor-pointer select-none"
              @click="toggleSort('email')"
            >
              Email
              <span v-if="filters.sort === 'email'">
                {{ filters.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th
              class="text-left p-3 cursor-pointer select-none"
              @click="toggleSort('phone')"
            >
              Phone
              <span v-if="filters.sort === 'phone'">
                {{ filters.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th
              class="text-left p-3 cursor-pointer select-none"
              @click="toggleSort('phone')"
            >
              Birth date
              <span v-if="filters.sort === 'phone'">
                {{ filters.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th class="p-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="contact in contacts.data"
            :key="contact.id"
            class="border-t hover:bg-gray-50"
          >
            <td class="p-3 text-center">
              <StarIcon
                @click="toggleFavorite(contact.id)"
                class="text-gray-300 w-5 h-5 cursor-pointer transition duration-150 ease-in-out hover:text-yellow-500 inline"
                v-show="!contact.is_favorite"
              />
              <StarIconActive
                @click="toggleFavorite(contact.id)"
                class="text-yellow-400 w-5 h-5 cursor-pointer transition duration-150 ease-in-out hover:text-yellow-500 inline"
                v-show="contact.is_favorite"
              />
            </td>
            <td class="p-3">{{ contact.name }}</td>
            <td class="p-3">{{ contact.email }}</td>
            <td class="p-3">{{ formatPhone(contact.phone) }}</td>
            <td class="p-3">{{ formatBirthday(contact.birthdate) }}</td>
            <td class="p-3 text-center space-x-2">
              <button
                class="bg-blue-500 text-white px-3 py-1 rounded text-sm"
                @click="router.visit(`/contacts/${contact.id}/edit`)"
                title="Edit Contact"
              >
                <PencilIcon class="w-4 h-4" />
              </button>
              <button
                class="bg-red-500 text-white px-3 py-1 rounded text-sm"
                @click="confirmDelete(contact.id)"
                title="Delete Contact"
              >
                <TrashIcon class="w-4 h-4" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-6 space-x-2">
      <button
        v-for="link in contacts.links"
        :key="link.label"
        :disabled="!link.url"
        @click="goTo(link.url)"
        class="px-3 py-1 text-sm rounded border"
        :class="{
          'bg-blue-500 text-white': link.active,
          'bg-white text-gray-700 hover:bg-gray-100': !link.active && link.url,
          'opacity-50 cursor-not-allowed': !link.url,
        }"
        v-html="link.label"
      />
    </div>
  </div>

  <ConfirmModal
    :show="showModal"
    @confirm="handleConfirm"
    @cancel="() => (showModal = false)"
  />
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ConfirmModal from '@/Components/ConfirmModal.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { defineProps } from 'vue'
import { PencilIcon, TrashIcon, ArrowDownTrayIcon, ArrowUpTrayIcon, StarIcon } from '@heroicons/vue/24/outline'
import { StarIcon as StarIconActive } from '@heroicons/vue/24/solid'

defineOptions({ layout: AppLayout })

const props = defineProps({
  contacts: Object,
  filters: Object,
})

const filters = ref({
  search: '',
  sort: 'name',
  direction: 'asc'
})

const applyFilters = () => {
  router.get('/contacts', filters.value, { preserveScroll: true, preserveState: true })
}

const toggleSort = (field) => {
  if (filters.value.sort === field) {
    filters.value.direction = filters.value.direction === 'asc' ? 'desc' : 'asc'
  } else {
    filters.value.sort = field
    filters.value.direction = 'asc'
  }

  applyFilters()
}

const exportContacts = () => {
  window.location.href = '/contacts/export'
}

const handleImport = (event) => {
  const file = event.target.files[0]
  if (!file) return

  const formData = new FormData()
  formData.append('file', file)

  router.post('/contacts/import', formData, {
    preserveScroll: true
  })
}

const toggleFavorite = (id) => {
  router.patch(`/contacts/${id}/toggle-favorite`, {
    preserveScroll: true,
  })
}

const fileInput = ref(null)

const triggerImport = () => {
  fileInput.value?.click()
}

const goTo = (url) => {
  router.visit(url, { preserveScroll: true })
}

const showModal = ref(false)
const contactToDelete = ref(null)

const confirmDelete = (id) => {
  contactToDelete.value = id
  showModal.value = true
}

const handleConfirm = () => {
  router.delete(`/contacts/${contactToDelete.value}`, {
    onSuccess: () => {
      showModal.value = false
      contactToDelete.value = null
    },
    onError: () => {
      showModal.value = false
      contactToDelete.value = null
    },
  })
}

const formatPhone = (phone) => {
  const cleaned = (phone || '').toString().replace(/\D/g, '')

  if (cleaned.length === 10) {
    // (XX) XXXX-XXXX
    return cleaned.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3')
  } else if (cleaned.length === 11) {
    // (XX) XXXXX-XXXX
    return cleaned.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3')
  }

  return phone
}

const formatBirthday = (birthday) => {
  if (!birthday) return ''
  const [year, month, day] = birthday.split('-')
  return `${day}/${month}/${year}`
}
</script>
