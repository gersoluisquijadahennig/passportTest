<template>
    <q-btn-dropdown stretch flat label="Organization">
        <q-list>
            <q-item-label header>Organizaciones</q-item-label>
            <q-item v-for="realm in realms" :key="`x.${realm.id}`" clickable v-close-popup tabindex="0" @click="selectedRealm(realm)">
                <q-item-section avatar>
                    <q-avatar :icon="realm.id === realmStore.realm.id ? 'check' : 'check'" :color="realm.id === realmStore.realm.id ? 'primary' : 'secondary'" text-color="white" />
                </q-item-section>
                <q-item-section>
                    <q-item-label>{{ realm.name }}</q-item-label>
                    <q-item-label caption>{{ realm.description }}</q-item-label>
                </q-item-section>
                <q-item-section side>
                    <q-icon name="info" />
                </q-item-section>
            </q-item>
            <q-separator inset spaced />
            <q-item>
                <q-item-section>
                    <q-btn color="primary" label="Crear Nuevo" @click="createRealm" />
                </q-item-section>
            </q-item>
        </q-list>
    </q-btn-dropdown>
</template>
<script setup>

import { router, usePage } from '@inertiajs/vue3'
import { useRealmStore } from '@/Stores/Admin/Realm/RealmStore'
import { storeToRefs } from 'pinia'

const realmStore = useRealmStore()
const { realms } = storeToRefs(realmStore)

const page = usePage()
const current_realm = page.props.auth.user.current_realm.slug

realmStore.setRealm(current_realm)

const selectedRealm = (realm) => {
    realmStore.setRealm(realm)
    router.get(route('admin.dashboard', { realm_slug: realm.slug },{
        realm : realm
    }))
}

const createRealm = () => {
      router.replace({
        url: `/admin/${current_realm}/realms/create`,
        component: `Admin/Realms/Create`,
    });
}
</script>