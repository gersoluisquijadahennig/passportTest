<template>
    <div class="q-pa-md">
        <div class="q-gutter-y-md" style="max-width: 100%">
            <q-card>
                <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary"
                    align="justify" narrow-indicator>
                    <q-tab name="welcome" label="Bienvenida" />
                    <q-tab name="server_info" label="Información Servidor" />
                    <q-tab name="provider_info" label="Información Provider" />
                </q-tabs>

                <q-separator />

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="welcome">
                        <div class="text-h6">Bienvenido a Oauth {{realm.name}}</div>
                        Sistema de gestion de usuarios centralizado, SSO, seguridad de la información
                    </q-tab-panel>

                    <q-tab-panel name="server_info">
                        <div class="text-h6">Información del servidor</div>
                        Version de la aplicación: {{ info.version }}
                    </q-tab-panel>

                    <q-tab-panel name="provider_info">
                        <div class="text-h6">Información del provider</div>
                        información del provider.
                    </q-tab-panel>
                </q-tab-panels>
            </q-card>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Layouts/Admin/Layout.vue'
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    realm: Object,
    required: true
})

const info = usePage()
defineOptions({ layout: Layout })

const tab = ref('welcome')
</script>

<style scoped></style>