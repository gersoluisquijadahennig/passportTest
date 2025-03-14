<template>
    <div class="q-pa-md">
        <q-table
        flat bordered
        title="Usuarios"
        dense
        :rows="users"
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
import Layout from '@/Layouts/Admin/Layout.vue'
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
defineOptions({ layout: Layout })

const page = usePage()
const { current_realm } = page.props.auth.user
const props = defineProps({
    users: {
        type: Object,
        required: true
    }
})

const filter = ref('')
const loading = ref(false)
const selected = ref([])

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
{ name: 'email', align: 'left', label: 'Correo', field: 'email', sortable: true },
{ name: 'rut', label: 'R.u.t', field: 'rut', sortable: true },
{ name: 'first_name', label: 'Primer Nombre', field: 'first_name' },
{ name: 'last_name', label: 'Segundo Nombre', field: 'last_name' },
{ name: 'alias', label: 'Alias', field: 'alias' },

]

const create = () => {
    router.visit(`/admin/${current_realm.slug}/users/create`)
}

const edit = () => {
    console.log('edit', selected.value[0])
}

const distroy = () => {
    console.log('distroy', selected.value[0])
}


</script>
