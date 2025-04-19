<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">Réserver une chambre</h1>

      <form @submit.prevent="handleSubmit" class="space-y-8">
        <!-- Dates de séjour -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div>
            <label for="check_in" class="block text-sm font-medium text-gray-700">Date d'arrivée</label>
            <input
              type="date"
              id="check_in"
              v-model="formData.checkIn"
              required
              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div>
            <label for="check_out" class="block text-sm font-medium text-gray-700">Date de départ</label>
            <input
              type="date"
              id="check_out"
              v-model="formData.checkOut"
              required
              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <!-- Sélection de chambre -->
        <div>
          <label for="room" class="block text-sm font-medium text-gray-700">Chambre</label>
          <select
            id="room"
            v-model="formData.roomId"
            required
            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          >
            <option value="">Sélectionnez une chambre</option>
            <option v-for="room in availableRooms" :key="room.id" :value="room.id">
              {{ room.name }} - {{ room.price }} DH/nuit
            </option>
          </select>
        </div>

        <!-- Nombre de personnes -->
        <div>
          <label for="guests" class="block text-sm font-medium text-gray-700">Nombre de personnes</label>
          <input
            type="number"
            id="guests"
            v-model="formData.guests"
            min="1"
            required
            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <!-- Services additionnels -->
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4">Services additionnels</h3>
          <div class="space-y-4">
            <div v-for="service in availableServices" :key="service.id" class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  :id="'service-' + service.id"
                  type="checkbox"
                  v-model="formData.services"
                  :value="service.id"
                  class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                />
              </div>
              <div class="ml-3 text-sm">
                <label :for="'service-' + service.id" class="font-medium text-gray-700">{{ service.name }}</label>
                <p class="text-gray-500">{{ service.description }} - {{ service.price }} DH</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Commentaires -->
        <div>
          <label for="comments" class="block text-sm font-medium text-gray-700">Commentaires spéciaux</label>
          <textarea
            id="comments"
            v-model="formData.comments"
            rows="3"
            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          ></textarea>
        </div>

        <!-- Résumé de la réservation -->
        <div class="bg-gray-50 p-6 rounded-lg">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Résumé de votre réservation</h3>
          <dl class="space-y-3">
            <div class="flex justify-between">
              <dt class="text-sm font-medium text-gray-500">Durée du séjour</dt>
              <dd class="text-sm text-gray-900">{{ numberOfNights }} nuits</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-sm font-medium text-gray-500">Prix de la chambre</dt>
              <dd class="text-sm text-gray-900">{{ roomPrice }} DH</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-sm font-medium text-gray-500">Services additionnels</dt>
              <dd class="text-sm text-gray-900">{{ servicesPrice }} DH</dd>
            </div>
            <div class="pt-3 flex justify-between border-t border-gray-200">
              <dt class="text-base font-medium text-gray-900">Total</dt>
              <dd class="text-base font-medium text-gray-900">{{ totalPrice }} DH</dd>
            </div>
          </dl>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-4">
          <button
            type="button"
            @click="router.back()"
            class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Annuler
          </button>
          <button
            type="submit"
            class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Confirmer la réservation
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const availableRooms = ref([])
const availableServices = ref([])

const formData = ref({
  checkIn: '',
  checkOut: '',
  roomId: '',
  guests: 1,
  services: [],
  comments: ''
})

// Computed properties for pricing
const numberOfNights = computed(() => {
  if (!formData.value.checkIn || !formData.value.checkOut) return 0
  const start = new Date(formData.value.checkIn)
  const end = new Date(formData.value.checkOut)
  return Math.ceil((end - start) / (1000 * 60 * 60 * 24))
})

const roomPrice = computed(() => {
  const room = availableRooms.value.find(r => r.id === formData.value.roomId)
  return room ? room.price * numberOfNights.value : 0
})

const servicesPrice = computed(() => {
  return formData.value.services.reduce((total, serviceId) => {
    const service = availableServices.value.find(s => s.id === serviceId)
    return total + (service ? service.price : 0)
  }, 0)
})

const totalPrice = computed(() => {
  return roomPrice.value + servicesPrice.value
})

const handleSubmit = async () => {
  try {
    // TODO: Implement reservation submission to API
    router.push({ name: 'my-reservations' })
  } catch (error) {
    console.error('Failed to submit reservation:', error)
  }
}

onMounted(async () => {
  try {
    // TODO: Fetch available rooms and services from API
  } catch (error) {
    console.error('Failed to fetch data:', error)
  }
})
</script>
