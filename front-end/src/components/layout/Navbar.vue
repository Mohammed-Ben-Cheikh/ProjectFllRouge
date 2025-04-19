<template>
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center">
            <router-link to="/" class="text-xl font-bold text-indigo-600">
              RiadBooking
            </router-link>
          </div>

          <!-- Navigation Links -->
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <router-link
              to="/riads"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium"
              :class="[
                $route.path.startsWith('/riads')
                  ? 'text-gray-900 border-b-2 border-indigo-500'
                  : 'text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              Riads
            </router-link>

            <router-link
              to="/services"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium"
              :class="[
                $route.path.startsWith('/services')
                  ? 'text-gray-900 border-b-2 border-indigo-500'
                  : 'text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              Services
            </router-link>

            <router-link
              v-if="authStore.isAuthenticated && authStore.userRole === 'admin'"
              to="/admin"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium"
              :class="[
                $route.path.startsWith('/admin')
                  ? 'text-gray-900 border-b-2 border-indigo-500'
                  : 'text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              Administration
            </router-link>

            <router-link
              v-if="authStore.isAuthenticated && authStore.userRole === 'proprietaire'"
              to="/dashboard"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium"
              :class="[
                $route.path.startsWith('/dashboard')
                  ? 'text-gray-900 border-b-2 border-indigo-500'
                  : 'text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              Tableau de bord
            </router-link>
          </div>
        </div>

        <!-- Right side menu -->
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <!-- Search -->
          <button
            @click="openSearch"
            class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <span class="sr-only">Rechercher</span>
            <svg
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
          </button>

          <!-- Notifications -->
          <button
            v-if="authStore.isAuthenticated"
            @click="toggleNotifications"
            class="ml-3 p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <span class="sr-only">Voir les notifications</span>
            <svg
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
              />
            </svg>
          </button>

          <!-- Profile dropdown -->
          <div v-if="authStore.isAuthenticated" class="ml-3 relative">
            <div>
              <button
                @click="toggleProfileMenu"
                class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <span class="sr-only">Ouvrir le menu utilisateur</span>
                <img
                  v-if="authStore.user?.avatar"
                  :src="authStore.user.avatar"
                  alt=""
                  class="h-8 w-8 rounded-full"
                />
                <div
                  v-else
                  class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center"
                >
                  <span class="text-indigo-600 font-medium text-sm">
                    {{ authStore.user?.name?.charAt(0) }}
                  </span>
                </div>
              </button>
            </div>

            <transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="showProfileMenu"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <router-link
                  to="/profile"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Mon profil
                </router-link>
                <router-link
                  to="/reservations"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Mes réservations
                </router-link>
                <router-link
                  to="/favoris"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Mes favoris
                </router-link>
                <button
                  @click="logout"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Déconnexion
                </button>
              </div>
            </transition>
          </div>

          <!-- Login/Register buttons -->
          <div v-else class="flex items-center space-x-4">
            <router-link
              to="/login"
              class="text-gray-500 hover:text-gray-700"
            >
              Connexion
            </router-link>
            <router-link
              to="/register"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
            >
              Inscription
            </router-link>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="-mr-2 flex items-center sm:hidden">
          <button
            @click="toggleMobileMenu"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
          >
            <span class="sr-only">Ouvrir le menu principal</span>
            <svg
              :class="{ 'hidden': showMobileMenu, 'block': !showMobileMenu }"
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg
              :class="{ 'hidden': !showMobileMenu, 'block': showMobileMenu }"
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div v-if="showMobileMenu" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <router-link
            to="/riads"
            class="block pl-3 pr-4 py-2 text-base font-medium"
            :class="[
              $route.path.startsWith('/riads')
                ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50'
                : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'
            ]"
          >
            Riads
          </router-link>

          <router-link
            to="/services"
            class="block pl-3 pr-4 py-2 text-base font-medium"
            :class="[
              $route.path.startsWith('/services')
                ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50'
                : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'
            ]"
          >
            Services
          </router-link>

          <router-link
            v-if="authStore.isAuthenticated && authStore.userRole === 'admin'"
            to="/admin"
            class="block pl-3 pr-4 py-2 text-base font-medium"
            :class="[
              $route.path.startsWith('/admin')
                ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50'
                : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'
            ]"
          >
            Administration
          </router-link>

          <router-link
            v-if="authStore.isAuthenticated && authStore.userRole === 'proprietaire'"
            to="/dashboard"
            class="block pl-3 pr-4 py-2 text-base font-medium"
            :class="[
              $route.path.startsWith('/dashboard')
                ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50'
                : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'
            ]"
          >
            Tableau de bord
          </router-link>
        </div>

        <!-- Mobile profile section -->
        <div v-if="authStore.isAuthenticated" class="pt-4 pb-3 border-t border-gray-200">
          <div class="flex items-center px-4">
            <div class="flex-shrink-0">
              <img
                v-if="authStore.user?.avatar"
                :src="authStore.user.avatar"
                alt=""
                class="h-10 w-10 rounded-full"
              />
              <div
                v-else
                class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center"
              >
                <span class="text-indigo-600 font-medium">
                  {{ authStore.user?.name?.charAt(0) }}
                </span>
              </div>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800">
                {{ authStore.user?.name }}
              </div>
              <div class="text-sm font-medium text-gray-500">
                {{ authStore.user?.email }}
              </div>
            </div>
          </div>
          <div class="mt-3 space-y-1">
            <router-link
              to="/profile"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Mon profil
            </router-link>
            <router-link
              to="/reservations"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Mes réservations
            </router-link>
            <router-link
              to="/favoris"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Mes favoris
            </router-link>
            <button
              @click="logout"
              class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Déconnexion
            </button>
          </div>
        </div>

        <!-- Mobile login/register section -->
        <div v-else class="pt-4 pb-3 border-t border-gray-200">
          <div class="space-y-1">
            <router-link
              to="/login"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Connexion
            </router-link>
            <router-link
              to="/register"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Inscription
            </router-link>
          </div>
        </div>
      </div>
    </transition>
  </nav>

  <SearchModal
    :is-visible="showSearchModal"
    @close="closeSearch"
  />

  <NotificationsPanel
    :is-visible="showNotificationsPanel"
    @close="showNotificationsPanel = false"
  />
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useNotificationStore } from '@/stores/notifications'
import SearchModal from '@/components/search/SearchModal.vue'
import NotificationsPanel from '@/components/notifications/NotificationsPanel.vue'

const router = useRouter()
const authStore = useAuthStore()
const notificationStore = useNotificationStore()

const showMobileMenu = ref(false)
const showProfileMenu = ref(false)
const showSearchModal = ref(false)
const showNotificationsPanel = ref(false)

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value
}

const toggleProfileMenu = () => {
  showProfileMenu.value = !showProfileMenu.value
}

const toggleNotifications = () => {
  showNotificationsPanel.value = !showNotificationsPanel.value
}

const openSearch = () => {
  showSearchModal.value = true
}

const closeSearch = () => {
  showSearchModal.value = false
}

const logout = async () => {
  try {
    await authStore.logout()
    showProfileMenu.value = false
    showMobileMenu.value = false
    notificationStore.success('Vous avez été déconnecté avec succès')
    router.push('/login')
  } catch (error) {
    notificationStore.error('Une erreur est survenue lors de la déconnexion')
  }
}
</script>
