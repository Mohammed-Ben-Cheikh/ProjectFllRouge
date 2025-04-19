<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Side Navigation -->
    <nav class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg">
      <div class="px-4 py-6">
        <h2 class="text-xl font-semibold text-gray-800">Administration</h2>

        <div class="mt-6 space-y-2">
          <router-link
            v-for="item in menuItems"
            :key="item.name"
            :to="item.to"
            class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md"
            :class="{ 'bg-indigo-50 text-indigo-600': isActiveRoute(item.to) }"
          >
            <span class="mr-3">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
              </svg>
            </span>
            {{ item.name }}
          </router-link>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="pl-64">
      <!-- Top Bar -->
      <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">
              {{ currentPageTitle }}
            </h1>
            <div class="flex items-center">
              <span class="text-sm text-gray-500 mr-4">{{ currentUser?.name }}</span>
              <button
                @click="logout"
                class="text-sm text-gray-600 hover:text-gray-900"
              >
                Déconnexion
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()
const route = useRoute()

const menuItems = [
  { name: 'Dashboard', to: '/admin', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
  { name: 'Riads', to: '/admin/riads', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
  { name: 'Services', to: '/admin/services', icon: 'M13 10V3L4 14h7v7l9-11h-7z' },
  { name: 'Utilisateurs', to: '/admin/users', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' },
  { name: 'Réservations', to: '/admin/reservations', icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z' },
  { name: 'Rapports', to: '/admin/reports', icon: 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
]

const currentUser = ref({
  name: 'Admin User', // TODO: Get from auth state
})

const currentPageTitle = computed(() => {
  const currentItem = menuItems.find(item => isActiveRoute(item.to))
  return currentItem?.name || 'Dashboard'
})

const isActiveRoute = (path) => {
  return route.path.startsWith(path)
}

const logout = async () => {
  try {
    // TODO: Implement logout logic
    router.push('/login')
  } catch (error) {
    console.error('Logout failed:', error)
  }
}
</script>
