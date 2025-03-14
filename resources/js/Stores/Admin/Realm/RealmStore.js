import { defineStore } from 'pinia'
import axios from 'axios'
import { usePage } from '@inertiajs/vue3'

export const useRealmStore = defineStore('realm', {
  state: () => ({
    realms: [],
    realm: {}
  }),
  actions: {
    async fetchRealms() {
      try {
        const response = await axios.get(`/admin/realms/getrealms`)
        this.realms = response.data
        this.setDefaultRealm()
      } catch (error) {
        console.error('Error fetching realms:', error)
      }
    },
    setDefaultRealm() {
      const { props } = usePage() // Initialize $page using usePage
      const currentRealmSlug = props.realm.slug // Access the current realm slug

      // Find the realm in the realms array that matches the current realm slug
      let realm = this.realms.find(realm => realm.slug === currentRealmSlug)
      if (realm) {
        this.setRealm(realm) // Set the default realm if found
      }
    },
    setRealm(realmData) {
      this.realm = realmData
    },
    addRealm(newRealm) {
      this.realms.push(newRealm)
    }
  }
})