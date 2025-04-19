import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('token'))
  const user = ref(null)

  const isAuthenticated = computed(() => !!token.value)
  const userRole = computed(() => user.value?.role)

  const setToken = (newToken) => {
    token.value = newToken
    if (newToken) {
      localStorage.setItem('token', newToken)
      axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
    } else {
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  }

  const setUser = (newUser) => {
    user.value = newUser
  }

  const login = async (credentials) => {
    try {
      const response = await axios.post('/api/login', credentials)
      setToken(response.data.token)
      setUser(response.data.user)
      return response.data
    } catch (error) {
      throw error
    }
  }

  const register = async (userData) => {
    try {
      const response = await axios.post('/api/register', userData)
      return response.data
    } catch (error) {
      throw error
    }
  }

  const logout = async () => {
    try {
      await axios.post('/api/logout')
    } finally {
      setToken(null)
      setUser(null)
    }
  }

  const checkAuth = async () => {
    if (!token.value) return false

    try {
      const response = await axios.get('/api/user')
      setUser(response.data)
      return true
    } catch (error) {
      setToken(null)
      setUser(null)
      return false
    }
  }

  const sendPasswordResetLink = async (email) => {
    try {
      const response = await axios.post('/api/password-reset', { email })
      return response.data
    } catch (error) {
      throw error
    }
  }

  const resetPassword = async (token, password) => {
    try {
      const response = await axios.post('/api/password-reset/confirm', {
        token,
        password,
        password_confirmation: password
      })
      return response.data
    } catch (error) {
      throw error
    }
  }

  // Initialize axios header if token exists
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
  }

  return {
    token,
    user,
    isAuthenticated,
    userRole,
    login,
    register,
    logout,
    checkAuth,
    sendPasswordResetLink,
    resetPassword
  }
})
