import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useLoadingStore = defineStore('loading', () => {
  const loadingStates = ref(new Map())

  const startLoading = (key) => {
    loadingStates.value.set(key, true)
  }

  const stopLoading = (key) => {
    loadingStates.value.set(key, false)
  }

  const isLoading = (key) => {
    return loadingStates.value.get(key) || false
  }

  const withLoading = async (key, callback) => {
    try {
      startLoading(key)
      return await callback()
    } finally {
      stopLoading(key)
    }
  }

  return {
    loadingStates,
    startLoading,
    stopLoading,
    isLoading,
    withLoading
  }
})
