<template>
  <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <!-- Profile Info -->
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Informations du profil</h3>
          <p class="mt-1 text-sm text-gray-600">
            Mettez à jour vos informations personnelles
          </p>
        </div>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        <form @submit.prevent="updateProfile">
          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <!-- Avatar -->
              <div>
                <label class="block text-sm font-medium text-gray-700">Photo</label>
                <div class="mt-2 flex items-center">
                  <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                    <img
                      v-if="preview || user.avatar"
                      :src="preview || user.avatar"
                      alt="Avatar"
                      class="h-full w-full object-cover"
                    />
                    <svg
                      v-else
                      class="h-full w-full text-gray-300"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                  </span>
                  <input
                    type="file"
                    ref="fileInput"
                    @change="handleFileUpload"
                    accept="image/*"
                    class="hidden"
                  />
                  <button
                    type="button"
                    @click="$refs.fileInput.click()"
                    class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  >
                    Changer
                  </button>
                </div>
              </div>

              <!-- Name -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>

              <!-- Phone -->
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button
                type="submit"
                :disabled="loading"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <svg
                  v-if="loading"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sauvegarder
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Change Password Section -->
    <div class="hidden sm:block" aria-hidden="true">
      <div class="py-5">
        <div class="border-t border-gray-200"></div>
      </div>
    </div>

    <div class="mt-10 sm:mt-0">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Mot de passe</h3>
            <p class="mt-1 text-sm text-gray-600">
              Mettez à jour votre mot de passe
            </p>
          </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
          <form @submit.prevent="updatePassword">
            <div class="shadow overflow-hidden sm:rounded-md">
              <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div>
                  <label for="current_password" class="block text-sm font-medium text-gray-700">
                    Mot de passe actuel
                  </label>
                  <input
                    type="password"
                    id="current_password"
                    v-model="passwordForm.current_password"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>

                <div>
                  <label for="new_password" class="block text-sm font-medium text-gray-700">
                    Nouveau mot de passe
                  </label>
                  <input
                    type="password"
                    id="new_password"
                    v-model="passwordForm.new_password"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>

                <div>
                  <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirmer le nouveau mot de passe
                  </label>
                  <input
                    type="password"
                    id="new_password_confirmation"
                    v-model="passwordForm.new_password_confirmation"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
              </div>

              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button
                  type="submit"
                  :disabled="passwordLoading"
                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  <svg
                    v-if="passwordLoading"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Mettre à jour le mot de passe
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import api from '@/services/api'

const authStore = useAuthStore()
const user = ref(null)
const loading = ref(false)
const passwordLoading = ref(false)
const preview = ref(null)

const form = ref({
  name: '',
  email: '',
  phone: '',
  avatar: null
})

const passwordForm = ref({
  current_password: '',
  new_password: '',
  new_password_confirmation: ''
})

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.value.avatar = file
    preview.value = URL.createObjectURL(file)
  }
}

const updateProfile = async () => {
  try {
    loading.value = true
    const formData = new FormData()
    Object.keys(form.value).forEach(key => {
      if (form.value[key] !== null) {
        formData.append(key, form.value[key])
      }
    })

    // TODO: Implement API call to update profile
    // const response = await api.auth.updateProfile(formData)
    // user.value = response.data

    // Show success message
  } catch (error) {
    console.error('Failed to update profile:', error)
    // Show error message
  } finally {
    loading.value = false
  }
}

const updatePassword = async () => {
  try {
    passwordLoading.value = true
    // TODO: Implement API call to update password
    // await api.auth.updatePassword(passwordForm.value)

    // Reset form
    passwordForm.value = {
      current_password: '',
      new_password: '',
      new_password_confirmation: ''
    }

    // Show success message
  } catch (error) {
    console.error('Failed to update password:', error)
    // Show error message
  } finally {
    passwordLoading.value = false
  }
}

onMounted(async () => {
  try {
    // TODO: Implement API call to get user profile
    // const response = await api.auth.getProfile()
    // user.value = response.data
    // form.value = { ...response.data }
  } catch (error) {
    console.error('Failed to fetch profile:', error)
  }
})
</script>
