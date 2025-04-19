import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'

export const useSearchStore = defineStore('search', () => {
  const searchResults = ref({
    riads: [],
    services: [],
    villes: []
  })
  const isLoading = ref(false)
  const searchQuery = ref('')

  const search = async (query) => {
    if (!query) return

    try {
      isLoading.value = true
      searchQuery.value = query

      const [riadsResponse, servicesResponse, villesResponse] = await Promise.all([
        api.riads.getAll({ search: query }),
        api.services.getAll({ search: query }),
        api.cities.getAll({ search: query })
      ])

      searchResults.value = {
        riads: riadsResponse.data,
        services: servicesResponse.data,
        villes: villesResponse.data
      }
    } catch (error) {
      console.error('Search failed:', error)
      throw error
    } finally {
      isLoading.value = false
    }
  }

  const clearSearch = () => {
    searchResults.value = {
      riads: [],
      services: [],
      villes: []
    }
    searchQuery.value = ''
  }

  return {
    searchResults,
    isLoading,
    searchQuery,
    search,
    clearSearch
  }
})
