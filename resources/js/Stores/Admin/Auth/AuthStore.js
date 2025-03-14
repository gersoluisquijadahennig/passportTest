import { defineStore } from 'pinia'
import { router } from '@inertiajs/vue3'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: {}
  }),
  actions: {
    setUser(userData) {
      this.user = userData
    },
    async logout() {
      await router.post('/logout')
      this.user = null
    }
  }
})
