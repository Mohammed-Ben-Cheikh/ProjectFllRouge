<template>
  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-6">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <span class="text-indigo-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="service.icon" />
            </svg>
          </span>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-medium text-gray-900">{{ service.name }}</h3>
          <p class="mt-1 text-sm text-gray-500">{{ service.description }}</p>
        </div>
      </div>

      <div class="mt-4">
        <div class="flex items-center justify-between">
          <p class="text-lg font-medium text-gray-900">{{ service.price }} DH</p>
          <div class="flex items-center">
            <span class="text-yellow-400">
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
            </span>
            <span class="ml-1 text-sm text-gray-600">{{ service.rating }}</span>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <router-link
          :to="{ name: 'service-details', params: { slug: service.slug }}"
          class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
        >
          En savoir plus
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  service: {
    type: Object,
    required: true
  }
})
</script>
