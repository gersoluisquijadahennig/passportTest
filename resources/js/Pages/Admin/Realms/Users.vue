<template>
<div class="q-pa-md">
    <q-table
    flat bordered
    title="Usuarios"
    dense
    :rows="users"
    :columns="columns"
    row-key="name"
    :loading="loading"
    />
</div>
</template>

<script setup>
import Layout from '@/Layouts/Admin/Layout.vue'
import { onBeforeMount, ref } from 'vue'
defineOptions({ layout: Layout })

const props = defineProps({
    realm: {
        type: Object,
        required: true
    }
})

const loading = ref(true)

const users = ref([])

onBeforeMount(async () => {
    try {
        const response = await axios.get(route('admin.realm.getusers', { realm: props.realm }))
        users.value = response.data
        loading.value = false

    } catch (error) {
        console.error('Error get users:', error)
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
{ name: 'email', align: 'left', label: 'Correo', field: 'email', sortable: true },
{ name: 'rut', label: 'R.u.t', field: 'rut', sortable: true },
{ name: 'first_name', label: 'Primer Nombre', field: 'first_name' },
{ name: 'last_name', label: 'Segundo Nombre', field: 'last_name' },
{ name: 'alias', label: 'Alias', field: 'alias' },

]
</script>
