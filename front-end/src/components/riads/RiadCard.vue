<template>
  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <img :src="riad.image" :alt="riad.name" class="w-full h-48 object-cover" />
    <div class="p-4">
      <h3 class="text-xl font-semibold text-gray-900">{{ riad.name }}</h3>
      <p class="mt-1 text-gray-500">{{ riad.city }}</p>
      <div class="mt-4 flex items-center justify-between">
        <div class="flex items-center">
          <span class="text-yellow-400">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </span>
          <span class="ml-1 text-sm text-gray-600">{{ riad.rating }}</span>
        </div>
        <router-link
          :to="{ name: 'riad-details', params: { slug: riad.slug }}"
          class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
        >
          Voir plus
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  riad: {
    type: Object,
    required: true
  }
})
</script>
