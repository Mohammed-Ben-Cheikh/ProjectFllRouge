<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="md:flex md:items-center md:justify-between">
      <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
          Riads
        </h2>
      </div>
      <div v-if="isAdmin" class="mt-4 flex md:mt-0 md:ml-4">
        <router-link
          to="/admin/riads/create"
          class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Ajouter un Riad
        </router-link>
      </div>
    </div>

    <!-- Filters -->
    <div class="mt-4 border-b border-gray-200 pb-4">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div>
          <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
          <select
            id="city"
            v-model="selectedCity"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
          >
            <option value="">Toutes les villes</option>
            <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Riad Grid -->
    <div class="mt-8 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
      <RiadCard
        v-for="riad in filteredRiads"
        :key="riad.id"
        :riad="riad"
      />
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="mt-8 flex justify-center">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
    </div>

    <!-- Empty State -->
    <div v-if="!loading && filteredRiads.length === 0" class="mt-8 text-center">
      <p class="text-gray-500">Aucun riad trouvé</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import RiadCard from '@/components/riads/RiadCard.vue'

const riads = ref([])
const loading = ref(true)
const selectedCity = ref('')
const cities = ref([])
const isAdmin = ref(false) // TODO: Get from auth state

const filteredRiads = computed(() => {
  if (!selectedCity.value) return riads.value
  return riads.value.filter(riad => riad.city === selectedCity.value)
})

onMounted(async () => {
  try {
    // TODO: Fetch riads from API
    loading.value = false
  } catch (error) {
    console.error('Failed to fetch riads:', error)
    loading.value = false
  }
})
</script>
