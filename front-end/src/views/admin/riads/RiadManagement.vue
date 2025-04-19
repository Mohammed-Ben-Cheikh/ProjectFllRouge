<template>
  <div>
    <!-- En-tête avec bouton d'ajout -->
    <div class="mb-6 flex justify-between items-center">
      <h2 class="text-xl font-bold text-gray-900">Gestion des Riads</h2>
      <button
        @click="openCreateModal"
        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Ajouter un Riad
      </button>
    </div>

    <!-- Filtres -->
    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div>
        <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
        <input
          type="text"
          id="search"
          v-model="filters.search"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          placeholder="Rechercher un riad..."
        />
      </div>
      <div>
        <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
        <select
          id="city"
          v-model="filters.city"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
          <option value="">Toutes les villes</option>
          <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
        </select>
      </div>
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
        <select
          id="status"
          v-model="filters.status"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
          <option value="">Tous les statuts</option>
          <option value="active">Actif</option>
          <option value="inactive">Inactif</option>
        </select>
      </div>
    </div>

    <!-- Table des riads -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Riad
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Ville
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Chambres
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Note
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Statut
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="riad in filteredRiads" :key="riad.id">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                  <img :src="riad.image" :alt="riad.name" class="h-10 w-10 rounded-full object-cover" />
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ riad.name }}</div>
                  <div class="text-sm text-gray-500">{{ riad.address }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ riad.city }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ riad.rooms }} chambres</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <span class="text-yellow-400">
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </span>
                <span class="ml-1 text-sm text-gray-600">{{ riad.rating }}</span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                :class="{
                  'bg-green-100 text-green-800': riad.status === 'active',
                  'bg-red-100 text-red-800': riad.status === 'inactive'
                }"
              >
                {{ riad.status === 'active' ? 'Actif' : 'Inactif' }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <button
                @click="editRiad(riad)"
                class="text-indigo-600 hover:text-indigo-900 mr-4"
              >
                Modifier
              </button>
              <button
                @click="confirmDelete(riad)"
                class="text-red-600 hover:text-red-900"
              >
                Supprimer
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal de création/modification -->
    <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <form @submit.prevent="saveRiad">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input
                  type="text"
                  id="name"
                  v-model="formData.name"
                  required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
              </div>
              <div class="mb-4">
                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                <select
                  id="city"
                  v-model="formData.city"
                  required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                  <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input
                  type="text"
                  id="address"
                  v-model="formData.address"
                  required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
              </div>
              <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea
                  id="description"
                  v-model="formData.description"
                  rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                ></textarea>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button
                type="submit"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
              >
                {{ formData.id ? 'Mettre à jour' : 'Créer' }}
              </button>
              <button
                type="button"
                @click="closeModal"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
              >
                Annuler
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const riads = ref([])
const cities = ref([])
const showModal = ref(false)
const loading = ref(false)

const filters = ref({
  search: '',
  city: '',
  status: ''
})

const formData = ref({
  id: null,
  name: '',
  city: '',
  address: '',
  description: '',
  status: 'active'
})

const filteredRiads = computed(() => {
  return riads.value.filter(riad => {
    const searchMatch = !filters.value.search ||
      riad.name.toLowerCase().includes(filters.value.search.toLowerCase())
    const cityMatch = !filters.value.city || riad.city === filters.value.city
    const statusMatch = !filters.value.status || riad.status === filters.value.status
    return searchMatch && cityMatch && statusMatch
  })
})

const openCreateModal = () => {
  formData.value = {
    id: null,
    name: '',
    city: '',
    address: '',
    description: '',
    status: 'active'
  }
  showModal.value = true
}

const editRiad = (riad) => {
  formData.value = { ...riad }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  formData.value = {
    id: null,
    name: '',
    city: '',
    address: '',
    description: '',
    status: 'active'
  }
}

const saveRiad = async () => {
  try {
    loading.value = true
    // TODO: Implement API call to save riad
    if (formData.value.id) {
      // Update existing riad
    } else {
      // Create new riad
    }
    closeModal()
    // Refresh riads list
    await fetchRiads()
  } catch (error) {
    console.error('Failed to save riad:', error)
  } finally {
    loading.value = false
  }
}

const confirmDelete = async (riad) => {
  if (confirm(`Êtes-vous sûr de vouloir supprimer le riad "${riad.name}" ?`)) {
    try {
      loading.value = true
      // TODO: Implement API call to delete riad
      // Refresh riads list
      await fetchRiads()
    } catch (error) {
      console.error('Failed to delete riad:', error)
    } finally {
      loading.value = false
    }
  }
}

const fetchRiads = async () => {
  try {
    loading.value = true
    // TODO: Implement API call to fetch riads
  } catch (error) {
    console.error('Failed to fetch riads:', error)
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await fetchRiads()
})
</script>
