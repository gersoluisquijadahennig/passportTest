<template>
    <div class="q-pa-md" style="max-width: 400px">
        <q-form @submit="store" @reset="onReset" class="q-gutter-md">
            <q-input filled v-model="form.name" label="Nombre *" hint="Nombre del Reino" lazy-rules
                :rules="[val => val && val.length > 0 || 'la descripcion no puede estar vacia']" />

            <q-input filled v-model="form.description" label="Descripción *" lazy-rules :rules="[
                val => val !== null && val !== '' || 'Introduzca una descripción corta para el reino',
                val => val !== null && val.length > 10 || 'La descripción debe tener al menos 10 caracteres'
            ]" />

            <q-toggle v-model="form.active" label="Estado Activado/Desactivado" />

            <div>
                <q-btn label="Guardar" type="submit" color="primary" />
                <q-btn label="Resetear" type="reset" color="secundary" flat class="q-ml-sm" />
            </div>
        </q-form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '@/Layouts/Admin/Layout.vue'
import axios from 'axios';
import { useRealmStore } from '@/Stores/Admin/Realm/RealmStore'
import { storeToRefs } from 'pinia'

const realmStore = useRealmStore()

const { realms } = storeToRefs(realmStore)

defineOptions({ layout: Layout })

let form = reactive({
    name: null,
    description: null,
    active: true,
})

async function store() {
    await axios.post(route('admin.realm.store'), form)
        .then(response => {
            console.log('Realm created', response.data.realm)
            realmStore.addRealm(response.data.realm)
            onReset()
        })
        .catch(error => {
            console.error('Error creating realm:', error)
        })
        .finally(() => {
            router.get(route('admin.realm.index'))
        })
}

function onReset() {
    form.name = null
    form.description = null
    form.active = false
}

</script>
