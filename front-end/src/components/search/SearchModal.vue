<template>
  <TransitionRoot appear :show="isVisible" as="template">
    <Dialog as="div" class="relative z-50" @close="$emit('close')">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-900/75" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-start justify-center p-4 pt-16">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
              <div class="relative">
                <div class="flex items-center border-b border-gray-200 px-4">
                  <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                  <input
                    ref="searchInput"
                    v-model="searchQuery"
                    type="text"
                    class="w-full border-0 bg-transparent py-4 pl-3 pr-8 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                    placeholder="Rechercher..."
                    @keyup.esc="$emit('close')"
                  />
                  <button
                    type="button"
                    class="text-gray-400 hover:text-gray-500"
                    @click="$emit('close')"
                  >
                    <span class="sr-only">Fermer</span>
                    <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                  </button>
                </div>

                <div v-if="isLoading" class="p-4 text-center">
                  <Spinner size="md" class="mx-auto text-primary-600" />
                </div>

                <div v-else-if="searchResults.length > 0" class="max-h-[32rem] divide-y divide-gray-100 overflow-y-auto">
                  <div v-for="result in searchResults" :key="result.id" class="p-4">
                    <router-link
                      :to="result.url"
                      class="block rounded-lg hover:bg-gray-50 p-2"
                      @click="$emit('close')"
                    >
                      <div class="flex items-center gap-4">
                        <div class="flex-1 min-w-0">
                          <p class="text-sm font-medium text-gray-900 truncate">
                            {{ result.title }}
                          </p>
                          <p class="text-sm text-gray-500 truncate">
                            {{ result.description }}
                          </p>
                        </div>
                        <ChevronRightIcon class="h-5 w-5 text-gray-400" />
                      </div>
                    </router-link>
                  </div>
                </div>

                <div
                  v-else-if="searchQuery"
                  class="p-4 text-center text-sm text-gray-500"
                >
                  Aucun résultat trouvé pour "{{ searchQuery }}"
                </div>

                <div
                  v-else
                  class="p-4 text-center text-sm text-gray-500"
                >
                  Commencez à taper pour rechercher...
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, watch, nextTick, onMounted } from 'vue'
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot
} from '@headlessui/vue'
import {
  MagnifyingGlassIcon,
  XMarkIcon,
  ChevronRightIcon
} from '@heroicons/vue/24/outline'
import { useDebounce } from '@vueuse/core'
import Spinner from '@/components/common/Spinner.vue'

const props = defineProps({
  isVisible: {
    type: Boolean,
    required: true
  }
})

defineEmits(['close'])

const searchInput = ref(null)
const searchQuery = ref('')
const debouncedSearchQuery = useDebounce(searchQuery, 300)
const isLoading = ref(false)
const searchResults = ref([])

watch(() => props.isVisible, async (visible) => {
  if (visible) {
    await nextTick()
    searchInput.value?.focus()
  } else {
    searchQuery.value = ''
    searchResults.value = []
  }
})

watch(debouncedSearchQuery, async (query) => {
  if (!query) {
    searchResults.value = []
    return
  }

  isLoading.value = true
  try {
    // TODO: Implement actual search API call
    await new Promise(resolve => setTimeout(resolve, 500))
    searchResults.value = [
      {
        id: 1,
        title: 'Résultat exemple 1',
        description: 'Description du résultat 1',
        url: '/'
      },
      {
        id: 2,
        title: 'Résultat exemple 2',
        description: 'Description du résultat 2',
        url: '/'
      }
    ]
  } catch (error) {
    console.error('Erreur lors de la recherche:', error)
    searchResults.value = []
  } finally {
    isLoading.value = false
  }
})
</script>
