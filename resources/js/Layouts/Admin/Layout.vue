<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted, onBeforeMount } from 'vue'
import { useQuasar } from 'quasar'
import DropDown from './Drop-Down-Profile.vue'
import DropDownOrganization from './DropDownOrganization.vue'
import { useRealmStore } from '@/Stores/Admin/Realm/RealmStore'
import { storeToRefs } from 'pinia'

const realmStore = useRealmStore()
const { realm } = storeToRefs(realmStore)

onBeforeMount(async () => {
    await realmStore.fetchRealms()
    console.log(realm.value.slug)
})

const page = usePage()

const q = useQuasar()
const darkMode = ref(true)
q.dark.set(darkMode.value)

const drawer = ref(false)
const ajaxBarRef = ref(null)

const updateDarkMode = (value) => {
  darkMode.value = value
  q.dark.set(value)
}

onMounted(() => {
  router.on('start', () => {
    ajaxBarRef.value?.start()
  })
  router.on('finish', () => {
    ajaxBarRef.value?.stop()
  })
})
</script>

<template>
    <div class="q-pa-md">
        <q-ajax-bar ref="ajaxBarRef" position="top" color="red" size="4px" />
        <q-layout view="lHh Lpr lff" class="shadow-2 rounded-borders">
            <q-header elevated >
                <q-toolbar >
                    <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
                    <q-separator dark vertical inset />
                    <!--<q-btn stretch flat label="Menu" />-->
                    <q-space />
                    <DropDown stretch flat label="Perfil" :dark-mode="darkMode" @update:darkMode="updateDarkMode" />
                    <DropDownOrganization stretch flat label="Organización" />
                    <!--<q-separator dark vertical />
                    <q-btn stretch flat label="Link" />-->
                </q-toolbar>
            </q-header>

            <q-drawer v-model="drawer" show-if-above :width="200" :breakpoint="400">
                <q-scroll-area style="height: calc(100% - 200px); margin-top: 200px; border-right: 1px solid #ddd">
                    <q-list padding>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="inbox" />
                            </q-item-section>

                            <q-item-section>
                                <Link :href="`/admin/${ realm.slug}/dashboard`" class="text-link">Dashboard</Link>
                            </q-item-section>
                        </q-item>
                        <q-item active clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="star" />
                            </q-item-section>

                            <q-item-section>
                                <Link :href="`/admin/${ realm.slug}/users`" class="text-link">Usuarios</Link>
                            </q-item-section>
                        </q-item>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="send" />
                            </q-item-section>

                            <q-item-section>
                                <Link href="/admin/users" class="text-link">Clientes</Link>
                            </q-item-section>
                        </q-item>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="drafts" />
                            </q-item-section>
                            <q-item-section>
                                <Link href="/admin/dashboard" class="text-link">Sesiones</Link>
                            </q-item-section>
                        </q-item>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="build" />
                            </q-item-section>
                            <q-item-section>
                                <Link href="/admin/realms" class="text-link">Reinos</Link>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-scroll-area>
                <q-img class="absolute-top" src="" style="height: 200px">
                    <div class="absolute-bottom bg-transparent text-center">
                        <q-avatar size="80px" class="q-mb-sm">
                            <img src="/img/logo_ssbb.jpg" alt="Avatar">
                        </q-avatar>
                        <div class="text-weight-bold">{{ page.props.auth.user.alias }}</div>
                        <div>{{page.props.auth.user.email}}</div>
                    </div>
                </q-img>
            </q-drawer>
            <q-page-container>
                <q-page padding>
                    <slot />
                </q-page>
            </q-page-container>
        </q-layout>
    </div>
</template>

<style>
.text-link {
    color: inherit;
    text-decoration: none;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.text-link:hover {
    text-decoration: none;
}
</style>