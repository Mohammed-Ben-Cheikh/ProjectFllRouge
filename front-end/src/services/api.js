import axios from 'axios'

// Configure axios defaults
axios.defaults.baseURL = import.meta.env.VITE_API_URL || 'http://localhost:8000'
axios.defaults.headers.common['Accept'] = 'application/json'

// API service object
export const api = {
  // Riads
  riads: {
    getAll: (params) => axios.get('/api/riads', { params }),
    getById: (slug) => axios.get(`/api/riads/${slug}`),
    create: (data) => axios.post('/api/riads', data),
    update: (slug, data) => axios.put(`/api/riads/${slug}`, data),
    delete: (slug) => axios.delete(`/api/riads/${slug}`),
    getByEntreprise: (slug) => axios.get(`/api/admin/riads/${slug}`),
  },

  // Rooms
  rooms: {
    getAll: (params) => axios.get('/api/chambres', { params }),
    getById: (slug) => axios.get(`/api/chambres/${slug}`),
    create: (data) => axios.post('/api/chambres', data),
    update: (slug, data) => axios.put(`/api/chambres/${slug}`, data),
    delete: (slug) => axios.delete(`/api/chambres/${slug}`),
    getByRiad: (slug) => axios.get(`/api/riads/${slug}/chambres`),
  },

  // Services
  services: {
    getAll: (params) => axios.get('/api/services', { params }),
    getById: (slug) => axios.get(`/api/services/${slug}`),
    create: (data) => axios.post('/api/services', data),
    update: (slug, data) => axios.put(`/api/services/${slug}`, data),
    delete: (slug) => axios.delete(`/api/services/${slug}`),
    getByEntreprise: (slug) => axios.get(`/api/entreprises/${slug}/services`),
  },

  // Reservations
  reservations: {
    getAll: (params) => axios.get('/api/reservations', { params }),
    getById: (slug) => axios.get(`/api/reservations/${slug}`),
    create: (data) => axios.post('/api/reservations', data),
    update: (slug, data) => axios.put(`/api/reservations/${slug}`, data),
    delete: (slug) => axios.delete(`/api/reservations/${slug}`),
    getByUser: (slug) => axios.get(`/api/users/${slug}/reservations`),
    getByChambre: (slug) => axios.get(`/api/chambres/${slug}/reservations`),
    getByStatus: (status) => axios.get(`/api/reservations/status/${status}`),
  },

  // Reviews
  reviews: {
    getAll: (params) => axios.get('/api/avis', { params }),
    getById: (slug) => axios.get(`/api/avis/${slug}`),
    create: (data) => axios.post('/api/avis', data),
    update: (slug, data) => axios.put(`/api/avis/${slug}`, data),
    delete: (slug) => axios.delete(`/api/avis/${slug}`),
    getByRiad: (slug) => axios.get(`/api/riads/${slug}/avis`),
    getByChambre: (slug) => axios.get(`/api/chambres/${slug}/avis`),
    getByService: (slug) => axios.get(`/api/services/${slug}/avis`),
  },

  // Favorites
  favorites: {
    getAll: (params) => axios.get('/api/favoris', { params }),
    getById: (slug) => axios.get(`/api/favoris/${slug}`),
    create: (data) => axios.post('/api/favoris', data),
    delete: (slug) => axios.delete(`/api/favoris/${slug}`),
    getByUser: (slug) => axios.get(`/api/users/${slug}/favoris`),
    getByRiad: (slug) => axios.get(`/api/riads/${slug}/favoris`),
  },

  // Cities
  cities: {
    getAll: (params) => axios.get('/api/villes', { params }),
    getById: (slug) => axios.get(`/api/villes/${slug}`),
    create: (data) => axios.post('/api/villes', data),
    update: (slug, data) => axios.put(`/api/villes/${slug}`, data),
    delete: (slug) => axios.delete(`/api/villes/${slug}`),
  },

  // Employees
  employees: {
    getAll: (params) => axios.get('/api/employes', { params }),
    getById: (slug) => axios.get(`/api/employes/${slug}`),
    create: (data) => axios.post('/api/employes', data),
    update: (slug, data) => axios.put(`/api/employes/${slug}`, data),
    delete: (slug) => axios.delete(`/api/employes/${slug}`),
    getByRiad: (slug) => axios.get(`/api/riads/${slug}/employes`),
  },

  // Payments
  payments: {
    getAll: (params) => axios.get('/api/paiements', { params }),
    getById: (slug) => axios.get(`/api/paiements/${slug}`),
    create: (data) => axios.post('/api/paiements', data),
    update: (slug, data) => axios.put(`/api/paiements/${slug}`, data),
    delete: (slug) => axios.delete(`/api/paiements/${slug}`),
    getByReservation: (slug) => axios.get(`/api/reservations/${slug}/paiements`),
    getByUser: (slug) => axios.get(`/api/users/${slug}/paiements`),
  },
}

// Response interceptor for handling errors globally
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response) {
      // Handle specific error cases
      switch (error.response.status) {
        case 401:
          // Handle unauthorized
          break
        case 403:
          // Handle forbidden
          break
        case 404:
          // Handle not found
          break
        case 422:
          // Handle validation errors
          break
        case 500:
          // Handle server error
          break
      }
    }
    return Promise.reject(error)
  }
)

export default api
