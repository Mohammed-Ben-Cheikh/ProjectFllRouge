<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="md:flex md:items-center md:justify-between">
      <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
          Services
        </h2>
      </div>
      <div v-if="isAdmin" class="mt-4 flex md:mt-0 md:ml-4">
        <router-link
          to="/admin/services/create"
          class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Ajouter un service
        </router-link>
      </div>
    </div>

    <!-- Filtres -->
    <div class="mt-4 border-b border-gray-200 pb-4">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
          <select
            id="category"
            v-model="selectedCategory"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
          >
            <option value="">Toutes les catégories</option>
            <option v-for="category in categories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>
        </div>
        <div>
          <label for="priceRange" class="block text-sm font-medium text-gray-700">Prix maximum</label>
          <input
            type="range"
            id="priceRange"
            v-model="maxPrice"
            :min="0"
            :max="1000"
            step="50"
            class="mt-1 block w-full"
          />
          <div class="mt-1 text-sm text-gray-500">{{ maxPrice }} DH</div>
        </div>
        <div>
          <label for="rating" class="block text-sm font-medium text-gray-700">Note minimum</label>
          <select
            id="rating"
            v-model="minRating"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
          >
            <option value="0">Toutes les notes</option>
            <option value="3">3 étoiles et plus</option>
            <option value="4">4 étoiles et plus</option>
            <option value="5">5 étoiles</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Liste des services -->
    <div class="mt-8 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
      <ServiceCard
        v-for="service in filteredServices"
        :key="service.id"
        :service="service"
      />
    </div>

    <!-- État de chargement -->
    <div v-if="loading" class="mt-8 flex justify-center">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
    </div>

    <!-- État vide -->
    <div v-if="!loading && filteredServices.length === 0" class="mt-8 text-center">
      <p class="text-gray-500">Aucun service trouvé</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import ServiceCard from '@/components/services/ServiceCard.vue'

const services = ref([])
const loading = ref(true)
const selectedCategory = ref('')
const maxPrice = ref(1000)
const minRating = ref(0)
const categories = ref([])
const isAdmin = ref(false) // TODO: Get from auth state

const filteredServices = computed(() => {
  return services.value.filter(service => {
    const categoryMatch = !selectedCategory.value || service.category === selectedCategory.value
    const priceMatch = service.price <= maxPrice.value
    const ratingMatch = service.rating >= minRating.value
    return categoryMatch && priceMatch && ratingMatch
  })
})

onMounted(async () => {
  try {
    // TODO: Fetch services from API
    loading.value = false
  } catch (error) {
    console.error('Failed to fetch services:', error)
    loading.value = false
  }
})
</script>
