<template>
  <div v-if="riad" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Riad Header -->
    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8">
      <!-- Image Gallery -->
      <div class="relative">
        <div class="aspect-w-3 aspect-h-2 rounded-lg overflow-hidden">
          <img :src="riad.mainImage" :alt="riad.name" class="w-full h-full object-center object-cover" />
        </div>
        <div class="mt-4 grid grid-cols-4 gap-4">
          <div v-for="(image, index) in riad.images" :key="index" class="relative aspect-w-1 aspect-h-1">
            <img :src="image" :alt="`${riad.name} - Image ${index + 1}`" class="w-full h-full object-center object-cover rounded-lg" />
          </div>
        </div>
      </div>

      <!-- Riad Info -->
      <div class="mt-8 lg:mt-0">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ riad.name }}</h1>
        <div class="mt-3">
          <h2 class="sr-only">Riad information</h2>
          <p class="text-3xl text-gray-900">{{ riad.price }} DH / nuit</p>
        </div>

        <!-- Rating -->
        <div class="mt-4">
          <h3 class="sr-only">Reviews</h3>
          <div class="flex items-center">
            <div class="flex items-center">
              <span v-for="rating in 5" :key="rating" class="text-yellow-400">
                <svg class="h-5 w-5" :class="rating <= riad.rating ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </span>
            </div>
            <p class="ml-2 text-sm text-gray-500">{{ riad.reviews }} avis</p>
          </div>
        </div>

        <div class="mt-6">
          <h3 class="text-sm font-medium text-gray-900">Description</h3>
          <div class="mt-4 prose prose-sm text-gray-500" v-html="riad.description"></div>
        </div>

        <!-- Reservation Button -->
        <div class="mt-8">
          <button
            type="button"
            class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            @click="startReservation"
          >
            Réserver maintenant
          </button>
        </div>
      </div>
    </div>

    <!-- Chambres -->
    <div class="mt-16">
      <h2 class="text-2xl font-bold text-gray-900">Chambres disponibles</h2>
      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="chambre in riad.chambres" :key="chambre.id" class="group relative">
          <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75">
            <img :src="chambre.image" :alt="chambre.name" class="w-full h-full object-center object-cover" />
          </div>
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-sm text-gray-700">{{ chambre.name }}</h3>
              <p class="mt-1 text-sm text-gray-500">{{ chambre.type }}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ chambre.price }} DH</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Services -->
    <div class="mt-16">
      <h2 class="text-2xl font-bold text-gray-900">Services</h2>
      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
        <div v-for="service in riad.services" :key="service.id" class="group relative">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <span class="text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="service.icon" />
                </svg>
              </span>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-medium text-gray-900">{{ service.name }}</h3>
              <p class="mt-2 text-sm text-gray-500">{{ service.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Avis -->
    <div class="mt-16">
      <h2 class="text-2xl font-bold text-gray-900">Avis des clients</h2>
      <div class="mt-6 space-y-10">
        <div v-for="avis in riad.avis" :key="avis.id" class="flex">
          <div class="flex-shrink-0">
            <img class="h-12 w-12 rounded-full" :src="avis.userImage" :alt="avis.userName" />
          </div>
          <div class="ml-4">
            <h4 class="text-sm font-bold text-gray-900">{{ avis.userName }}</h4>
            <div class="mt-1 flex items-center">
              <span v-for="rating in 5" :key="rating" class="text-yellow-400">
                <svg class="h-4 w-4" :class="rating <= avis.rating ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </span>
            </div>
            <p class="mt-2 text-sm text-gray-500">{{ avis.comment }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div v-else-if="loading" class="min-h-screen flex items-center justify-center">
    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const riad = ref(null)
const loading = ref(true)

const startReservation = () => {
  router.push({ name: 'reservation', params: { riadSlug: route.params.slug } })
}

onMounted(async () => {
  try {
    // TODO: Fetch riad details from API using route.params.slug
    loading.value = false
  } catch (error) {
    console.error('Failed to fetch riad details:', error)
    loading.value = false
  }
})
</script>
