<template>
    <div class="q-pa-md">
        <q-table
            flat bordered
            title="Reinos Oauth"
            dense
            :rows="realms"
            :columns="columns"
            row-key="name"
            :filter="filter"
            :loading="loading"
            selection="single"
            v-model:selected="selected"
        >
            <template v-slot:top>
                <q-btn color="primary" :disable="loading" label="Nuevo" @click="create" />
                <q-btn v-if="selected.length > 0" color="secondary" class="q-ml-sm" label="Editar" @click="edit" />
                <q-btn v-if="selected.length > 0" color="secondary" class="q-ml-sm" label="Borrar" @click="distroy" />
                <q-space />
                <q-input borderless dense debounce="300" color="primary" v-model="filter">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </template>
        </q-table>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '@/Layouts/Admin/Layout.vue'
defineOptions({ layout: Layout })

const filter = ref('')
const loading = ref(false)
const selected = ref([])

const props = defineProps({
    realms: {
        type: Object,
        required: true
    }
})

const columns = [
    {
        name: 'name',
        required: true,
        label: 'Nombre',
        align: 'left',
        field: row => row.name,
        format: val => `${val}`,
        sortable: true
    },
    { name: 'description', align: 'left', label: 'Description', field: 'description', sortable: true },
    { name: 'active', label: 'Activado', field: 'active', sortable: true }
]

const create = () => {
    router.replace({
        url: '/admin/realms/create',
        component: 'Admin/Realms/Create',
    })
}

const edit = async () => {
    if (selected.value.length > 0) {
        const selectedRealm = selected.value[0]
        await router.get(route('admin.realm.edit',{realm : selectedRealm}),{
            onSuccess: () => {
                console.log('Realm edit')
                selected.value = []
            },
            onError: (error) => {
                console.error('Error edit realm:', error)
            }

        })

    }
}

const distroy = async () => {
    if (selected.value.length > 0) {
        const selectedRealm = selected.value[0]
        await router.delete(route('admin.realm.destroy',{realm : selectedRealm}),{
            onSuccess: () => {
                console.log('Realm deleted')
                selected.value = []
            },
            onError: (error) => {
                console.error('Error delete realm:', error)
            }
        })
    }
}
</script>