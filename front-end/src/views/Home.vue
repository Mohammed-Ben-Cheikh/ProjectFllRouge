<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import RiadCard from '@/components/riads/RiadCard.vue'

const router = useRouter()

const featuredRiads = ref([])
const popularCities = ref([])
const services = ref([
  {
    id: 1,
    name: 'Service de chambre 24/7',
    description: 'Un service personnalisé à toute heure',
    icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
  },
  {
    id: 2,
    name: 'Restaurant gastronomique',
    description: 'Cuisine traditionnelle marocaine',
    icon: 'M21 15.999h-2.25v-3h.75a.75.75 0 00.75-.75v-.75a.75.75 0 00-.75-.75H3.75a.75.75 0 00-.75.75v.75c0 .414.336.75.75.75h.75v3H2.25'
  },
  {
    id: 3,
    name: 'Spa & Bien-être',
    description: 'Détente et relaxation garanties',
    icon: 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
  },
  {
    id: 4,
    name: 'Excursions guidées',
    description: 'Découvrez la culture locale',
    icon: 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'
  },
])

const navigateToCity = (city) => {
  router.push({
    name: 'riads',
    query: { city: city.name }
  })
}

const fetchFeaturedRiads = async () => {
  try {
    // TODO: Implement API call to fetch featured riads
  } catch (error) {
    console.error('Failed to fetch featured riads:', error)
  }
}

const fetchPopularCities = async () => {
  try {
    // TODO: Implement API call to fetch popular cities
  } catch (error) {
    console.error('Failed to fetch popular cities:', error)
  }
}

onMounted(async () => {
  await Promise.all([
    fetchFeaturedRiads(),
    fetchPopularCities()
  ])
})
</script>

<template>
  <div>
    <!-- Hero Section -->
    <div class="relative bg-gray-900">
      <div class="absolute inset-0">
        <img
          class="w-full h-full object-cover"
          src="/images/hero-bg.jpg"
          alt="Hero background"
        />
        <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
      </div>
      <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
          Découvrez les plus beaux Riads du Maroc
        </h1>
        <p class="mt-6 text-xl text-gray-300 max-w-3xl">
          Explorez notre sélection de riads authentiques et vivez une expérience unique au cœur de la culture marocaine.
        </p>
        <div class="mt-10">
          <router-link
            to="/riads"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
          >
            Explorer les Riads
          </router-link>
        </div>
      </div>
    </div>

    <!-- Featured Riads Section -->
    <div class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            Riads en vedette
          </h2>
          <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
            Découvrez nos plus beaux riads sélectionnés pour vous
          </p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          <RiadCard
            v-for="riad in featuredRiads"
            :key="riad.id"
            :riad="riad"
          />
        </div>
      </div>
    </div>

    <!-- Popular Cities Section -->
    <div class="bg-gray-50 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            Destinations populaires
          </h2>
          <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
            Explorez les plus belles villes du Maroc
          </p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="city in popularCities"
            :key="city.id"
            class="relative rounded-lg overflow-hidden group cursor-pointer"
            @click="navigateToCity(city)"
          >
            <div class="aspect-w-3 aspect-h-2">
              <img
                :src="city.image"
                :alt="city.name"
                class="w-full h-full object-center object-cover group-hover:scale-110 transition-transform duration-300"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <h3 class="text-2xl font-bold text-white">{{ city.name }}</h3>
              <p class="mt-2 text-sm text-gray-300">{{ city.riadCount }} riads disponibles</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Services Section -->
    <div class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            Nos services
          </h2>
          <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
            Des prestations haut de gamme pour un séjour inoubliable
          </p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
          <div v-for="service in services" :key="service.id" class="text-center">
            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white mx-auto">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="service.icon" />
              </svg>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ service.name }}</h3>
            <p class="mt-2 text-base text-gray-500">{{ service.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Newsletter Section -->
    <div class="bg-indigo-700">
      <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center">
        <div class="lg:w-0 lg:flex-1">
          <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            Restez informé
          </h2>
          <p class="mt-3 max-w-3xl text-lg text-indigo-200">
            Inscrivez-vous à notre newsletter pour recevoir nos meilleures offres
          </p>
        </div>
        <div class="mt-8 lg:mt-0 lg:ml-8">
          <form class="sm:flex">
            <label for="email-address" class="sr-only">Adresse email</label>
            <input
              id="email-address"
              name="email-address"
              type="email"
              autocomplete="email"
              required
              class="w-full px-5 py-3 border border-transparent placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-700 focus:ring-white focus:border-white sm:max-w-xs rounded-md"
              placeholder="Entrez votre email"
            />
            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
              <button
                type="submit"
                class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50"
              >
                S'inscrire
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
