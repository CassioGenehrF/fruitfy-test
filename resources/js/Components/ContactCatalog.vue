<template>
  <div
    class="flip-card w-64 h-40 perspective"
    @click="flipped = !flipped"
  >
    <div :class="['flip-card-inner', { flipped }]">
      <div class="flip-card-front bg-white border rounded-lg shadow p-4 flex flex-col items-center justify-center">
        <img
          :src="gravatarUrl(contact.email)"
          alt="Avatar"
          class="w-14 h-14 rounded-full mb-2"
        />
        <h2 class="text-lg font-semibold text-center">{{ contact.name }}</h2>
        <p class="text-xs text-gray-400 mt-4">Click to see more</p>
      </div>

      <div class="flip-card-back bg-white border rounded-lg shadow p-4 flex flex-col justify-center items-center text-center">
        <p class="text-sm"><strong>Email:</strong> {{ contact.email }}</p>
        <p class="text-sm mt-2"><strong>Phone:</strong> {{ formatPhone(contact.phone) }}</p>
        <p class="text-sm mt-2"><strong>Birth date:</strong> {{ formatBirthday(contact.birthdate) }}</p>
        <p class="text-xs text-gray-400 mt-4">Click to flip back</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import md5 from 'blueimp-md5'
import { ref } from 'vue'
import { defineProps } from 'vue'

const props = defineProps({
  contact: Object,
})

const flipped = ref(false)

const gravatarUrl = (email) => {
  const hash = md5(email.trim().toLowerCase())
  return `https://www.gravatar.com/avatar/${hash}?s=100&d=identicon`
}

const formatPhone = (phone) => {
  const cleaned = phone.replace(/\D/g, '')
  if (cleaned.length === 11)
    return cleaned.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3')
  if (cleaned.length === 10)
    return cleaned.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3')
  return phone
}

const formatBirthday = (birthday) => {
  if (!birthday) return ''
  const [year, month, day] = birthday.split('-')
  return `${day}/${month}/${year}`
}
</script>

<style scoped>
.perspective {
  perspective: 1000px;
}
.flip-card {
  cursor: pointer;
}
.flip-card-inner {
  transition: transform 0.6s;
  transform-style: preserve-3d;
  position: relative;
  width: 100%;
  height: 100%;
}
.flip-card-inner.flipped {
  transform: rotateY(180deg);
}
.flip-card-front,
.flip-card-back {
  backface-visibility: hidden;
  position: absolute;
  width: 100%;
  height: 100%;
}
.flip-card-back {
  transform: rotateY(180deg);
}
</style>
