import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useNotificationStore = defineStore('notifications', () => {
  const notifications = ref([])
  const nextId = ref(1)

  const addNotification = (notification) => {
    const id = nextId.value++
    notifications.value.push({
      id,
      created_at: new Date().toISOString(),
      read_at: null,
      ...notification
    })

    // Auto-remove after 5 seconds if not persistent
    if (!notification.persistent) {
      setTimeout(() => {
        removeNotification(id)
      }, 5000)
    }

    return id
  }

  const success = (message, title = 'Succès') => {
    return addNotification({
      type: 'success',
      title,
      message,
      persistent: false
    })
  }

  const error = (message, title = 'Erreur') => {
    return addNotification({
      type: 'error',
      title,
      message,
      persistent: true
    })
  }

  const info = (message, title = 'Information') => {
    return addNotification({
      type: 'info',
      title,
      message,
      persistent: false
    })
  }

  const warning = (message, title = 'Attention') => {
    return addNotification({
      type: 'warning',
      title,
      message,
      persistent: true
    })
  }

  const removeNotification = (id) => {
    const index = notifications.value.findIndex(n => n.id === id)
    if (index !== -1) {
      notifications.value.splice(index, 1)
    }
  }

  const markAsRead = (id) => {
    const notification = notifications.value.find(n => n.id === id)
    if (notification) {
      notification.read_at = new Date().toISOString()
    }
  }

  const markAllAsRead = () => {
    const now = new Date().toISOString()
    notifications.value.forEach(notification => {
      if (!notification.read_at) {
        notification.read_at = now
      }
    })
  }

  const clearAll = () => {
    notifications.value = []
  }

  const getUnreadCount = () => {
    return notifications.value.filter(n => !n.read_at).length
  }

  return {
    notifications,
    success,
    error,
    info,
    warning,
    removeNotification,
    markAsRead,
    markAllAsRead,
    clearAll,
    getUnreadCount
  }
})
